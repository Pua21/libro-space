<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $anggotaList = [
            [
                'id' => 'AGT-0001',
                'nama' => 'Putri Ayu Lestari',
                'email' => 'putri.ayu@univ.ac.id',
                'jurusan' => 'Sistem Informasi',
                'kontak' => '0812-3456-1234',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-nabila.png',
                'total_pinjam' => 3,
                'status_denda' => 'Tidak Ada (Lunas)',
                'tgl_registrasi' => '14 Sep 2023',
                'masa_berlaku' => '31 Des 2025'
            ],
            [
                'id' => 'AGT-0002',
                'nama' => 'Dimas Pratama',
                'email' => 'dimas.p@univ.ac.id',
                'jurusan' => 'Akuntansi',
                'kontak' => '0813-9876-5678',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-dimas.png',
                'total_pinjam' => 1,
                'status_denda' => 'Rp 3.000',
                'tgl_registrasi' => '10 Okt 2023',
                'masa_berlaku' => '31 Des 2025'
            ],
            [
                'id' => 'AGT-0003',
                'nama' => 'Rina Wulandari',
                'email' => 'rina.w@univ.ac.id',
                'jurusan' => 'Manajemen',
                'kontak' => '0857-1122-9012',
                'status' => 'Nonaktif',
                'avatar' => 'images/avatar-siti.png',
                'total_pinjam' => 0,
                'status_denda' => 'Tidak Ada (Lunas)',
                'tgl_registrasi' => '05 Agu 2023',
                'masa_berlaku' => '31 Des 2024'
            ],
            [
                'id' => 'AGT-0004',
                'nama' => 'Fajar Ramadhan',
                'email' => 'fajar.r@univ.ac.id',
                'jurusan' => 'Teknik Informatika',
                'kontak' => '0821-4455-6677',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-budi.png',
                'total_pinjam' => 2,
                'status_denda' => 'Tidak Ada (Lunas)',
                'tgl_registrasi' => '22 Sep 2023',
                'masa_berlaku' => '31 Des 2025'
            ],
            [
                'id' => 'AGT-0005',
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.n@univ.ac.id',
                'jurusan' => 'Ilmu Komunikasi',
                'kontak' => '0878-3344-5566',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-siti.png',
                'total_pinjam' => 1,
                'status_denda' => 'Rp 8.000',
                'tgl_registrasi' => '18 Nov 2023',
                'masa_berlaku' => '31 Des 2025'
            ],
            [
                'id' => 'AGT-0006',
                'nama' => 'Bima Sakti',
                'email' => 'bima.s@univ.ac.id',
                'jurusan' => 'Desain Komunikasi Visual',
                'kontak' => '0819-7788-9900',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-dimas.png',
                'total_pinjam' => 1,
                'status_denda' => 'Tidak Ada (Lunas)',
                'tgl_registrasi' => '01 Des 2023',
                'masa_berlaku' => '31 Des 2025'
            ],
        ];

        $selectedAnggota = $anggotaList[0];

        $summary = [
            'total' => 342,
            'total_growth' => '+12 bulan ini',
            'aktif' => 318,
            'aktif_percent' => '93% dari total'
        ];

        return view('anggota.index', compact('anggotaList', 'selectedAnggota', 'summary'));
    }
}
