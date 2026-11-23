<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_buku' => [
                'val' => '1.250',
                'change' => '+12',
                'desc' => '+12 judul bulan ini'
            ],
            'total_anggota' => [
                'val' => '342',
                'change' => '+5',
                'desc' => '+5 anggota minggu ini'
            ],
            'total_petugas' => [
                'val' => '6',
                'status' => 'Standby',
                'desc' => '6 bertugas aktif'
            ],
            'buku_dipinjam' => [
                'val' => '87',
                'status' => 'Aktif',
                'desc' => 'Sirkuasi beroperasi lancar'
            ],
            'buku_terlambat' => [
                'val' => '12',
                'badge' => 'Perlu Tindakan',
                'desc' => 'Kenaikan denda akumulatif'
            ]
        ];

        $chart_summary = [
            'rata_rata' => '148 buku',
            'puncak' => '210 buku (Okt)',
            'tingkat_kembali' => '94.8% tepat waktu'
        ];

        $buku_populer = [
            [
                'rank' => 1,
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'cover' => 'images/book-bumi-manusia.png',
                'count' => '94x',
                'percent' => 94
            ],
            [
                'rank' => 2,
                'judul' => 'Atomic Habits',
                'pengarang' => 'James Clear',
                'cover' => 'images/book-atomic-habits.png',
                'count' => '82x',
                'percent' => 82
            ],
            [
                'rank' => 3,
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'cover' => 'images/book-filosofi-teras.png',
                'count' => '76x',
                'percent' => 76
            ],
            [
                'rank' => 4,
                'judul' => 'Laut Bercerita',
                'pengarang' => 'Leila S. Chudori',
                'cover' => 'images/book-laut-bercerita.png',
                'count' => '65x',
                'percent' => 65
            ],
            [
                'rank' => 5,
                'judul' => 'Sapiens',
                'pengarang' => 'Yuval Noah Harari',
                'cover' => 'images/book-sapiens.png',
                'count' => '59x',
                'percent' => 59
            ]
        ];

        $peminjaman_terbaru = [
            [
                'anggota' => 'Dimas Arya Pradana',
                'nim' => 'MHS-2023-0142',
                'avatar' => 'images/avatar-dimas.png',
                'judul_buku' => 'Struktur Data & Algoritma',
                'kode_rak' => 'Rak B-04 • INF-089',
                'tgl_pinjam' => '20 Okt 2024',
                'jatuh_tempo' => '27 Okt 2024',
                'is_overdue' => false,
                'status' => 'Dipinjam',
                'status_type' => 'warning'
            ],
            [
                'anggota' => 'Nabila Fitri Annisa',
                'nim' => 'MHS-2022-0918',
                'avatar' => 'images/avatar-nabila.png',
                'judul_buku' => 'Psikologi Komunikasi',
                'kode_rak' => 'Rak A-12 • SOS-201',
                'tgl_pinjam' => '14 Okt 2024',
                'jatuh_tempo' => '21 Okt 2024',
                'is_overdue' => false,
                'status' => 'Kembali',
                'status_type' => 'success'
            ],
            [
                'anggota' => 'Budi Santoso, M.Kom',
                'nim' => 'DOS-2019-0022',
                'avatar' => 'images/avatar-budi.png',
                'judul_buku' => 'Artificial Intelligence: Modern Approach',
                'kode_rak' => 'Terlambat 3 hari • Denda Rp 6.000',
                'tgl_pinjam' => '09 Okt 2024',
                'jatuh_tempo' => '16 Okt 2024',
                'is_overdue' => true,
                'status' => 'Terlambat',
                'status_type' => 'danger'
            ],
            [
                'anggota' => 'Siti Maharani',
                'nim' => 'MHS-2023-0402',
                'avatar' => 'images/avatar-siti.png',
                'judul_buku' => 'Metodologi Penelitian Kualitatif',
                'kode_rak' => 'Rak C-01 • MET-112',
                'tgl_pinjam' => '21 Okt 2024',
                'jatuh_tempo' => '28 Okt 2024',
                'is_overdue' => false,
                'status' => 'Dipinjam',
                'status_type' => 'warning'
            ],
        ];

        return view('dashboard', compact('stats', 'chart_summary', 'buku_populer', 'peminjaman_terbaru'));
    }
}
