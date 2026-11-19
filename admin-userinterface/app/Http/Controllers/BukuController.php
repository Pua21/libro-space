<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $allBuku = [
            [
                'cover' => 'images/book-laskar-pelangi.png',
                'kode' => 'BK-001',
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'kategori' => 'Novel',
                'rak' => 'Rak A1',
                'stok' => 5,
                'status' => 'Tersedia',
                'status_type' => 'success'
            ],
            [
                'cover' => 'images/book-bumi-manusia.png',
                'kode' => 'BK-002',
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'kategori' => 'Sastra',
                'rak' => 'Rak A2',
                'stok' => 0,
                'status' => 'Dipinjam',
                'status_type' => 'warning'
            ],
            [
                'cover' => 'images/book-filosofi-teras.png',
                'kode' => 'BK-003',
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'kategori' => 'Pengembangan Diri',
                'rak' => 'Rak B1',
                'stok' => 2,
                'status' => 'Rusak',
                'status_type' => 'danger'
            ],
            [
                'cover' => 'images/book-laut-bercerita.png',
                'kode' => 'BK-004',
                'judul' => 'Laut Bercerita',
                'pengarang' => 'Leila S. Chudori',
                'kategori' => 'Fiksi Sejarah',
                'rak' => 'Rak A3',
                'stok' => 4,
                'status' => 'Tersedia',
                'status_type' => 'success'
            ],
            [
                'cover' => 'images/book-sapiens.png',
                'kode' => 'BK-005',
                'judul' => 'Sapiens',
                'pengarang' => 'Yuval Noah Harari',
                'kategori' => 'Sejarah & Sains',
                'rak' => 'Rak C2',
                'stok' => 1,
                'status' => 'Tersedia',
                'status_type' => 'success'
            ],
            [
                'cover' => 'images/book-atomic-habits.png',
                'kode' => 'BK-006',
                'judul' => 'Atomic Habits',
                'pengarang' => 'James Clear',
                'kategori' => 'Pengembangan Diri',
                'rak' => 'Rak B2',
                'stok' => 6,
                'status' => 'Tersedia',
                'status_type' => 'success'
            ],
        ];

        $kategoriList = ['Semua Kategori', 'Novel', 'Sastra', 'Pengembangan Diri', 'Fiksi Sejarah', 'Sejarah & Sains', 'Sains & Teknologi', 'Filsafat'];
        $statusList = ['Semua Status', 'Tersedia', 'Dipinjam', 'Rusak'];

        $search = $request->query('search');
        $selectedKategori = $request->query('kategori');
        $selectedStatus = $request->query('status');

        $buku = array_filter($allBuku, function ($item) use ($search, $selectedKategori, $selectedStatus) {
            if ($search) {
                $term = strtolower($search);
                $matchJudul = str_contains(strtolower($item['judul']), $term);
                $matchPengarang = str_contains(strtolower($item['pengarang']), $term);
                $matchKode = str_contains(strtolower($item['kode']), $term);
                if (!$matchJudul && !$matchPengarang && !$matchKode) {
                    return false;
                }
            }
            if ($selectedKategori && $selectedKategori !== 'Semua Kategori' && $item['kategori'] !== $selectedKategori) {
                return false;
            }
            if ($selectedStatus && $selectedStatus !== 'Semua Status' && $item['status'] !== $selectedStatus) {
                return false;
            }
            return true;
        });

        return view('buku.index', [
            'buku' => $buku,
            'kategoriList' => $kategoriList,
            'statusList' => $statusList,
            'search' => $search,
            'selectedKategori' => $selectedKategori,
            'selectedStatus' => $selectedStatus,
            'totalBuku' => '1.250'
        ]);
    }
}
