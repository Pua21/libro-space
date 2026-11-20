<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total' => 6,
            'aktif' => 5,
            'online' => 3
        ];

        $petugasList = [
            [
                'id' => 1,
                'nama' => 'Budi Santoso, S.Kom',
                'role' => 'Kepala Sirkulasi',
                'username' => 'budi.s',
                'email' => 'budi.santoso@perpustakaan.go.id',
                'terakhir_login' => 'Hari ini, 08:30 WIB',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-budi.png'
            ],
            [
                'id' => 2,
                'nama' => 'Siti Rahmawati',
                'role' => 'Staf Inventaris & Katalog',
                'username' => 'siti.r',
                'email' => 'siti.rahma@perpustakaan.go.id',
                'terakhir_login' => 'Hari ini, 09:15 WIB',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-siti.png'
            ],
            [
                'id' => 3,
                'nama' => 'Ahmad Fauzi',
                'role' => 'Staf Peminjaman & Layanan',
                'username' => 'ahmad.f',
                'email' => 'ahmad.fauzi@perpustakaan.go.id',
                'terakhir_login' => 'Kemarin, 16:45 WIB',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-dimas.png'
            ],
            [
                'id' => 4,
                'nama' => 'Maya Indriani',
                'role' => 'Staf Pengembalian & Denda',
                'username' => 'maya.i',
                'email' => 'maya.indri@perpustakaan.go.id',
                'terakhir_login' => '2 hari lalu',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-nabila.png'
            ],
            [
                'id' => 5,
                'nama' => 'Agus Wijaya',
                'role' => 'Petugas Arsip',
                'username' => 'agus.w',
                'email' => 'agus.wijaya@perpustakaan.go.id',
                'terakhir_login' => '1 minggu lalu',
                'status' => 'Nonaktif',
                'avatar' => 'images/avatar-budi.png'
            ],
            [
                'id' => 6,
                'nama' => 'Dewi Kartika',
                'role' => 'Staf Layanan Referensi',
                'username' => 'dewi.k',
                'email' => 'dewi.k@perpustakaan.go.id',
                'terakhir_login' => 'Hari ini, 10:02 WIB',
                'status' => 'Aktif',
                'avatar' => 'images/avatar-siti.png'
            ],
        ];

        $selectedPetugas = $petugasList[0];

        return view('petugas.index', compact('stats', 'petugasList', 'selectedPetugas'));
    }
}
