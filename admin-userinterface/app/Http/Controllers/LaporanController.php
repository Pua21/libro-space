<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'peminjaman');

        $metrics = [
            'total_transaksi' => 214,
            'dipinjam' => 87,
            'tepat_waktu' => 115,
            'terlambat' => 12
        ];

        $laporanList = [
            [
                'kode' => 'PJ-001',
                'inisial' => 'PA',
                'anggota' => 'Putri Ayu Lestari',
                'no_anggota' => 'AGT-0001',
                'buku' => 'Laskar Pelangi',
                'tgl_pinjam' => '02 Okt 2026',
                'tgl_kembali' => '09 Okt 2026',
                'is_late' => false,
                'status' => 'Selesai',
                'status_type' => 'success',
                'petugas' => 'Budi Santoso'
            ],
            [
                'kode' => 'PJ-002',
                'inisial' => 'DP',
                'anggota' => 'Dimas Pratama',
                'no_anggota' => 'AGT-0002',
                'buku' => 'Bumi Manusia',
                'tgl_pinjam' => '05 Okt 2026',
                'tgl_kembali' => '12 Okt 2026',
                'is_late' => true,
                'status' => 'Terlambat',
                'status_type' => 'danger',
                'petugas' => 'Siti Rahma'
            ],
            [
                'kode' => 'PJ-003',
                'inisial' => 'RW',
                'anggota' => 'Rina Wulandari',
                'no_anggota' => 'AGT-0003',
                'buku' => 'Filosofi Teras',
                'tgl_pinjam' => '10 Okt 2026',
                'tgl_kembali' => '17 Okt 2026',
                'is_late' => false,
                'status' => 'Selesai',
                'status_type' => 'success',
                'petugas' => 'Ahmad Fauzi'
            ],
            [
                'kode' => 'PJ-004',
                'inisial' => 'FR',
                'anggota' => 'Fajar Ramadhan',
                'no_anggota' => 'AGT-0004',
                'buku' => 'Laut Bercerita',
                'tgl_pinjam' => '14 Okt 2026',
                'tgl_kembali' => '21 Okt 2026',
                'is_late' => false,
                'status' => 'Dipinjam',
                'status_type' => 'warning',
                'petugas' => 'Budi Santoso'
            ],
            [
                'kode' => 'PJ-005',
                'inisial' => 'SN',
                'anggota' => 'Siti Nurhaliza',
                'no_anggota' => 'AGT-0005',
                'buku' => 'Sapiens',
                'tgl_pinjam' => '18 Okt 2026',
                'tgl_kembali' => '25 Okt 2026',
                'is_late' => false,
                'status' => 'Dipinjam',
                'status_type' => 'warning',
                'petugas' => 'Maya Indriani'
            ],
            [
                'kode' => 'PJ-006',
                'inisial' => 'BS',
                'anggota' => 'Bima Sakti',
                'no_anggota' => 'AGT-0006',
                'buku' => 'Atomic Habits',
                'tgl_pinjam' => '20 Okt 2026',
                'tgl_kembali' => '27 Okt 2026',
                'is_late' => false,
                'status' => 'Selesai',
                'status_type' => 'success',
                'petugas' => 'Siti Rahma'
            ],
        ];

        return view('laporan.index', compact('activeTab', 'metrics', 'laporanList'));
    }
}
