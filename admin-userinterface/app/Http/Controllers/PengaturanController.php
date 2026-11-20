<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index(Request $request)
    {
        $settings = [
            'lama_pinjam' => 7,
            'max_buku' => 3,
            'max_perpanjangan' => 2,
            'grace_period' => 1,
            'allow_pinjam_denda' => false,
            'denda_harian' => '1.000',
            'denda_rusak_ringan' => '50.000',
            'denda_hilang' => '100.000',
            'notifikasi_wa' => true,
            'terakhir_update' => '15 Okt 2026, 09:30 WIB oleh Admin Utama'
        ];

        return view('pengaturan.index', compact('settings'));
    }
}
