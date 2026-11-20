<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index(Request $request)
    {
        $profil = [
            'nama' => 'Admin Perpustakaan, S.Kom',
            'role' => 'Super Administrator',
            'username' => 'admin.utama',
            'email' => 'admin@perpustakaan.go.id',
            'kontak' => '0812-3456-7890',
            'nip' => 'ADM-2024-001',
            'jabatan' => 'Kepala Pengelola Sistem & TI',
            'divisi' => 'UPT Perpustakaan Pusat',
            'bergabung' => '12 Januari 2024',
            'terakhir_login' => 'Hari ini, 08:30 WIB',
            'hak_akses' => 'Akses Penuh (Super Admin)',
            'status' => 'Aktif & Terverifikasi',
            'avatar' => 'images/avatar-admin.png'
        ];

        return view('profil.index', compact('profil'));
    }
}
