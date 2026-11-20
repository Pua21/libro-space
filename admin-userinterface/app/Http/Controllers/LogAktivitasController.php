<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index(Request $request)
    {
        $timeline = [
            'HARI INI (31 OKT 2026)' => [
                [
                    'aksi' => 'Tambah',
                    'aksi_type' => 'success',
                    'modul' => 'Data Buku',
                    'waktu' => '10:42 WIB',
                    'device' => 'Web Chrome (192.168.1.12)',
                    'user' => 'Budi Santoso',
                    'avatar' => 'images/avatar-budi.png',
                    'deskripsi' => 'menambahkan 5 eksemplar baru pada buku',
                    'target' => '"Atomic Habits" (ISBN: 978-602-06-3317-6)',
                    'highlight_type' => 'bold'
                ],
                [
                    'aksi' => 'Ubah',
                    'aksi_type' => 'warning',
                    'modul' => 'Peminjaman',
                    'waktu' => '09:15 WIB',
                    'device' => 'Firefox (192.168.1.18)',
                    'user' => 'Siti Rahmawati',
                    'avatar' => 'images/avatar-siti.png',
                    'deskripsi' => 'mengubah status peminjaman PJ-002 menjadi',
                    'target' => 'Terlambat',
                    'highlight_type' => 'danger'
                ],
                [
                    'aksi' => 'Hapus',
                    'aksi_type' => 'danger',
                    'modul' => 'Data Master',
                    'waktu' => '08:30 WIB',
                    'device' => 'Web Safari (192.168.1.33)',
                    'user' => 'Ahmad Fauzi',
                    'avatar' => 'images/avatar-dimas.png',
                    'deskripsi' => 'menghapus data kategori kedaluwarsa',
                    'target' => '"Majalah 2020"',
                    'highlight_type' => 'danger'
                ],
                [
                    'aksi' => 'Ubah',
                    'aksi_type' => 'warning',
                    'modul' => 'Pengaturan',
                    'waktu' => '07:55 WIB',
                    'device' => 'Edge (192.168.1.2)',
                    'user' => 'Admin Perpustakaan',
                    'avatar' => 'images/avatar-admin.png',
                    'deskripsi' => 'memperbarui aturan denda harian menjadi',
                    'target' => 'Rp 1.000 / hari',
                    'highlight_type' => 'bold'
                ]
            ],
            'KEMARIN (30 OKT 2026)' => [
                [
                    'aksi' => 'Tambah',
                    'aksi_type' => 'success',
                    'modul' => 'Data Anggota',
                    'waktu' => '16:20 WIB',
                    'device' => 'Chrome (192.168.1.25)',
                    'user' => 'Maya Indriani',
                    'avatar' => 'images/avatar-nabila.png',
                    'deskripsi' => 'mencetak kartu anggota baru untuk',
                    'target' => 'Putri Ayu Lestari ( AGT - 0001 )',
                    'highlight_type' => 'bold'
                ],
                [
                    'aksi' => 'Login / Keamanan',
                    'aksi_type' => 'info',
                    'modul' => 'Autentikasi',
                    'waktu' => '14:10 WIB',
                    'device' => 'Firefox (192.168.1.45)',
                    'user' => 'Budi Santoso',
                    'avatar' => 'images/avatar-budi.png',
                    'deskripsi' => 'login berhasil ke sistem melalui verifikasi dua langkah (2FA)',
                    'target' => '',
                    'highlight_type' => 'none'
                ],
                [
                    'aksi' => 'Login / Keamanan',
                    'aksi_type' => 'info',
                    'modul' => 'Petugas',
                    'waktu' => '11:05 WIB',
                    'device' => 'Chrome (192.168.1.8)',
                    'user' => 'Dewi Kartika',
                    'avatar' => 'images/avatar-siti.png',
                    'deskripsi' => 'menyetujui reset password untuk akun staf',
                    'target' => 'agus.w',
                    'highlight_type' => 'bold'
                ],
                [
                    'aksi' => 'Tambah',
                    'aksi_type' => 'success',
                    'modul' => 'Laporan',
                    'waktu' => '09:30 WIB',
                    'device' => 'Web Safari (192.168.1.2)',
                    'user' => 'Admin Perpustakaan',
                    'avatar' => 'images/avatar-admin.png',
                    'deskripsi' => 'mengekspor laporan rekapitulasi peminjaman Oktober 2026 format XLSX',
                    'target' => '',
                    'highlight_type' => 'none'
                ]
            ]
        ];

        $stats = [
            'total' => '1.482',
            'tambah' => ['val' => 340, 'pct' => '23%'],
            'ubah' => ['val' => 825, 'pct' => '56%'],
            'hapus' => ['val' => 42, 'pct' => '3%'],
            'login' => ['val' => 275, 'pct' => '18%']
        ];

        $topUsers = [
            ['rank' => 1, 'nama' => 'Budi Santoso', 'role' => 'Petugas Sirkulasi', 'aksi' => 420, 'avatar' => 'images/avatar-budi.png'],
            ['rank' => 2, 'nama' => 'Siti Rahmawati', 'role' => 'Kataloger Senior', 'aksi' => 380, 'avatar' => 'images/avatar-siti.png'],
            ['rank' => 3, 'nama' => 'Maya Indriani', 'role' => 'Staf Keanggotaan', 'aksi' => 210, 'avatar' => 'images/avatar-nabila.png'],
        ];

        return view('log.index', compact('timeline', 'stats', 'topUsers'));
    }
}
