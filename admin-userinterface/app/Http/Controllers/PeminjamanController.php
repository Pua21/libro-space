<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $counts = [
            'semua' => 87,
            'dipinjam' => 58,
            'kembali' => 21
        ];

        $sirkulasiList = [
            [
                'kode' => 'PJ-001',
                'anggota' => 'Putri Ayu Lestari',
                'no_anggota' => 'AGT-0001',
                'avatar' => 'images/avatar-nabila.png',
                'judul' => 'Laskar Pelangi',
                'kode_buku' => 'BK-001',
                'cover' => 'images/book-laskar-pelangi.png',
                'tgl_pinjam' => '02 Nov 2026',
                'jatuh_tempo' => '09 Nov 2026',
                'status' => 'Dipinjam',
                'status_type' => 'warning',
                'petugas' => 'Budi',
                'keterangan' => ''
            ],
            [
                'kode' => 'PJ-002',
                'anggota' => 'Dimas Pratama',
                'no_anggota' => 'AGT-0002',
                'avatar' => 'images/avatar-dimas.png',
                'judul' => 'Bumi Manusia',
                'kode_buku' => 'BK-002',
                'cover' => 'images/book-bumi-manusia.png',
                'tgl_pinjam' => '20 Okt 2026',
                'jatuh_tempo' => '27 Okt 2026',
                'status' => 'Terlambat',
                'status_type' => 'danger',
                'petugas' => 'Siti Rahma',
                'keterangan' => '(lewat 6 hari)'
            ],
            [
                'kode' => 'PJ-003',
                'anggota' => 'Rina Wulandari',
                'no_anggota' => 'AGT-0003',
                'avatar' => 'images/avatar-siti.png',
                'judul' => 'Filosofi Teras',
                'kode_buku' => 'BK-003',
                'cover' => 'images/book-filosofi-teras.png',
                'tgl_pinjam' => '15 Okt 2026',
                'jatuh_tempo' => '22 Okt 2026',
                'status' => 'Kembali',
                'status_type' => 'success',
                'petugas' => 'Ahmad',
                'keterangan' => ''
            ],
            [
                'kode' => 'PJ-004',
                'anggota' => 'Fajar Ramadhan',
                'no_anggota' => 'AGT-0004',
                'avatar' => 'images/avatar-budi.png',
                'judul' => 'Laut Bercerita',
                'kode_buku' => 'BK-004',
                'cover' => 'images/book-laut-bercerita.png',
                'tgl_pinjam' => '28 Okt 2026',
                'jatuh_tempo' => '04 Nov 2026',
                'status' => 'Dipinjam',
                'status_type' => 'warning',
                'petugas' => 'Budi',
                'keterangan' => ''
            ],
            [
                'kode' => 'PJ-005',
                'anggota' => 'Siti Nurhaliza',
                'no_anggota' => 'AGT-0005',
                'avatar' => 'images/avatar-siti.png',
                'judul' => 'Sapiens',
                'kode_buku' => 'BK-005',
                'cover' => 'images/book-sapiens.png',
                'tgl_pinjam' => '18 Okt 2026',
                'jatuh_tempo' => '25 Okt 2026',
                'status' => 'Terlambat',
                'status_type' => 'danger',
                'petugas' => 'Maya',
                'keterangan' => '(lewat 8 hari)'
            ],
            [
                'kode' => 'PJ-006',
                'anggota' => 'Bima Sakti',
                'no_anggota' => 'AGT-0006',
                'avatar' => 'images/avatar-dimas.png',
                'judul' => 'Atomic Habits',
                'kode_buku' => 'BK-006',
                'cover' => 'images/book-atomic-habits.png',
                'tgl_pinjam' => '25 Okt 2026',
                'jatuh_tempo' => '01 Nov 2026',
                'status' => 'Kembali',
                'status_type' => 'success',
                'petugas' => 'Dewi',
                'keterangan' => ''
            ],
        ];

        $editorData = [
            'kode' => 'PJ-002',
            'judul' => 'Bumi Manusia',
            'kode_buku' => 'BK-002',
            'cover' => 'images/book-bumi-manusia.png',
            'anggota' => 'Dimas Pratama',
            'no_anggota' => 'AGT-0002',
            'petugas' => 'Siti Rahma',
            'tgl_pinjam' => '10/20/2026',
            'jatuh_tempo_baru' => '11/05/2026',
            'status' => 'Terlambat (Denda Berjalan)'
        ];

        return view('peminjaman.index', compact('counts', 'sirkulasiList', 'editorData'));
    }
}
