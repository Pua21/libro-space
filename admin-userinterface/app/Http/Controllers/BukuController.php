<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        // Fetch books from database with relationships
        $bukuQuery = Buku::with(['kategori', 'pengarang', 'penerbit', 'rak']);

        $search = $request->query('search');
        $selectedKategori = $request->query('kategori');
        $selectedStatus = $request->query('status');

        if ($search) {
            $term = strtolower($search);
            $bukuQuery->where(function ($q) use ($term) {
                $q->where('judul', 'like', "%{$term}%")
                  ->orWhere('kode_buku', 'like', "%{$term}%")
                  ->orWhereHas('pengarang', function ($qp) use ($term) {
                      $qp->where('nama_pengarang', 'like', "%{$term}%");
                  });
            });
        }

        if ($selectedKategori && $selectedKategori !== 'Semua Kategori') {
            $bukuQuery->whereHas('kategori', function ($q) use ($selectedKategori) {
                $q->where('nama_kategori', $selectedKategori);
            });
        }

        if ($selectedStatus && $selectedStatus !== 'Semua Status') {
            $bukuQuery->where('status', strtolower($selectedStatus));
        }

        $bukuCollection = $bukuQuery->get();

        // Format to array for the view
        $buku = $bukuCollection->map(function ($item) {
            $statusType = match (strtolower($item->status)) {
                'tersedia' => 'success',
                'dipinjam' => 'warning',
                'rusak' => 'danger',
                default => 'info',
            };

            return [
                'id' => $item->id,
                'cover' => $item->cover_image ?: 'images/book-laskar-pelangi.png',
                'kode' => $item->kode_buku,
                'isbn' => $item->isbn,
                'judul' => $item->judul,
                'pengarang' => $item->pengarang->nama_pengarang ?? '-',
                'penerbit' => $item->penerbit->nama_penerbit ?? '-',
                'kategori' => $item->kategori->nama_kategori ?? '-',
                'rak' => $item->rak->kode_rak ?? '-',
                'lokasi_rak' => $item->rak->nama_rak ?? '-',
                'stok' => $item->stok_tersedia,
                'total_stok' => $item->total_stok,
                'status' => ucfirst($item->status),
                'status_type' => $statusType,
            ];
        })->toArray();

        // If database was empty, fall back to initial dataset
        if (empty($buku) && !$search && !$selectedKategori && !$selectedStatus) {
            $buku = [
                ['cover' => 'images/book-laskar-pelangi.png', 'kode' => 'BK-001', 'judul' => 'Laskar Pelangi', 'pengarang' => 'Andrea Hirata', 'kategori' => 'Novel', 'rak' => 'Rak A1', 'stok' => 5, 'status' => 'Tersedia', 'status_type' => 'success'],
                ['cover' => 'images/book-bumi-manusia.png', 'kode' => 'BK-002', 'judul' => 'Bumi Manusia', 'pengarang' => 'Pramoedya Ananta Toer', 'kategori' => 'Sastra', 'rak' => 'Rak A2', 'stok' => 0, 'status' => 'Dipinjam', 'status_type' => 'warning'],
                ['cover' => 'images/book-filosofi-teras.png', 'kode' => 'BK-003', 'judul' => 'Filosofi Teras', 'pengarang' => 'Henry Manampiring', 'kategori' => 'Pengembangan Diri', 'rak' => 'Rak B1', 'stok' => 2, 'status' => 'Rusak', 'status_type' => 'danger'],
                ['cover' => 'images/book-laut-bercerita.png', 'kode' => 'BK-004', 'judul' => 'Laut Bercerita', 'pengarang' => 'Leila S. Chudori', 'kategori' => 'Fiksi Sejarah', 'rak' => 'Rak A3', 'stok' => 4, 'status' => 'Tersedia', 'status_type' => 'success'],
                ['cover' => 'images/book-sapiens.png', 'kode' => 'BK-005', 'judul' => 'Sapiens', 'pengarang' => 'Yuval Noah Harari', 'kategori' => 'Sejarah & Sains', 'rak' => 'Rak C2', 'stok' => 1, 'status' => 'Tersedia', 'status_type' => 'success'],
                ['cover' => 'images/book-atomic-habits.png', 'kode' => 'BK-006', 'judul' => 'Atomic Habits', 'pengarang' => 'James Clear', 'kategori' => 'Pengembangan Diri', 'rak' => 'Rak B2', 'stok' => 6, 'status' => 'Tersedia', 'status_type' => 'success'],
            ];
        }

        $kategoriList = ['Semua Kategori', 'Novel', 'Sastra', 'Pengembangan Diri', 'Fiksi Sejarah', 'Sejarah & Budaya', 'Sains & Teknologi', 'Filsafat'];
        $statusList = ['Semua Status', 'Tersedia', 'Dipinjam', 'Rusak'];

        $totalBukuCount = Buku::count();
        $totalBuku = $totalBukuCount > 0 ? number_format($totalBukuCount, 0, ',', '.') : '1.250';

        return view('buku.index', [
            'buku' => $buku,
            'kategoriList' => $kategoriList,
            'statusList' => $statusList,
            'search' => $search,
            'selectedKategori' => $selectedKategori,
            'selectedStatus' => $selectedStatus,
            'totalBuku' => $totalBuku
        ]);
    }
}
