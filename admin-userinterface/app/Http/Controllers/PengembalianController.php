<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_denda' => 'Rp 450.000',
            'total_change' => '+12% dibanding bulan lalu',
            'belum_bayar' => 'Rp 175.000',
            'menunggak' => '14 Anggota Menunggak',
            'denda_lunas' => 'Rp 275.000',
            'lunas_transaksi' => '38 Transaksi Selesai'
        ];

        $pengembalianList = [
            [
                'kode' => 'PG-001',
                'anggota' => 'Dimas Pratama',
                'no_anggota' => 'AGT-0002',
                'avatar' => 'images/avatar-dimas.png',
                'buku' => 'Bumi Manusia',
                'cover' => 'images/book-bumi-manusia.png',
                'tgl_kembali' => '30 Okt 2026',
                'keterlambatan' => '3 hari terlambat',
                'kondisi' => 'Baik',
                'nominal' => 'Rp 3.000',
                'keterangan_biaya' => '',
                'status_bayar' => 'Belum Bayar',
                'action' => 'lunasi'
            ],
            [
                'kode' => 'PG-002',
                'anggota' => 'Rina Wulandari',
                'no_anggota' => 'AGT-0003',
                'avatar' => 'images/avatar-siti.png',
                'buku' => 'Filosofi Teras',
                'cover' => 'images/book-filosofi-teras.png',
                'tgl_kembali' => '22 Okt 2026',
                'keterlambatan' => 'Tepat Waktu (0 hari)',
                'kondisi' => 'Baik',
                'nominal' => 'Rp 0',
                'keterangan_biaya' => '',
                'status_bayar' => 'Lunas',
                'action' => 'view'
            ],
            [
                'kode' => 'PG-003',
                'anggota' => 'Andi Saputra',
                'no_anggota' => 'AGT-0008',
                'avatar' => 'images/avatar-budi.png',
                'buku' => 'Atomic Habits',
                'cover' => 'images/book-atomic-habits.png',
                'tgl_kembali' => '18 Okt 2026',
                'keterlambatan' => '5 hari terlambat',
                'kondisi' => 'Rusak',
                'nominal' => 'Rp 55.000',
                'keterangan_biaya' => 'Telat + Rusak',
                'status_bayar' => 'Lunas',
                'action' => 'kuitansi'
            ],
            [
                'kode' => 'PG-004',
                'anggota' => 'Dewi Lestari',
                'no_anggota' => 'AGT-0012',
                'avatar' => 'images/avatar-nabila.png',
                'buku' => 'Laut Bercerita',
                'cover' => 'images/book-laut-bercerita.png',
                'tgl_kembali' => '25 Okt 2026',
                'keterlambatan' => '7 hari terlambat',
                'kondisi' => 'Hilang',
                'nominal' => 'Rp 107.000',
                'keterangan_biaya' => 'Telat + Ganti Buku',
                'status_bayar' => 'Belum Bayar',
                'action' => 'lunasi'
            ],
            [
                'kode' => 'PG-005',
                'anggota' => 'Fajar Ramadhan',
                'no_anggota' => 'AGT-0004',
                'avatar' => 'images/avatar-budi.png',
                'buku' => 'Struktur Data & Algoritma',
                'cover' => 'images/book-laskar-pelangi.png',
                'tgl_kembali' => '24 Okt 2026',
                'keterlambatan' => '2 hari terlambat',
                'kondisi' => 'Baik',
                'nominal' => 'Rp 2.000',
                'keterangan_biaya' => '',
                'status_bayar' => 'Lunas',
                'action' => 'kuitansi'
            ],
            [
                'kode' => 'PG-006',
                'anggota' => 'Putri Ayu Lestari',
                'no_anggota' => 'AGT-0001',
                'avatar' => 'images/avatar-nabila.png',
                'buku' => 'Sapiens',
                'cover' => 'images/book-sapiens.png',
                'tgl_kembali' => '20 Okt 2026',
                'keterlambatan' => 'Tepat Waktu',
                'kondisi' => 'Baik',
                'nominal' => 'Rp 0',
                'keterangan_biaya' => '',
                'status_bayar' => 'Lunas',
                'action' => 'view'
            ],
        ];

        $paymentQuick = [
            'kode' => 'PG-001',
            'inisial' => 'DP',
            'anggota' => 'Dimas Pratama',
            'keterangan' => '3 hari telat (Bumi Manusia)',
            'tarif_denda' => 'Rp 3.000',
            'biaya_admin' => 'Gratis',
            'total' => 'Rp 3.000',
            'uang_diterima' => '5.000',
            'kembalian' => 'Rp 2.000'
        ];

        return view('pengembalian.index', compact('stats', 'pengembalianList', 'paymentQuick'));
    }
}
