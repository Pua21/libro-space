<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengaturanSistem;

class PengaturanController extends Controller
{
    public function index(Request $request)
    {
        $settings = [
            'lama_pinjam' => PengaturanSistem::getVal('lama_pinjam_default', 7),
            'max_buku' => PengaturanSistem::getVal('max_buku_pinjam', 3),
            'max_perpanjangan' => PengaturanSistem::getVal('max_perpanjangan', 2),
            'grace_period' => PengaturanSistem::getVal('grace_period', 1),
            'allow_pinjam_denda' => PengaturanSistem::getVal('allow_pinjam_denda', false),
            'denda_harian' => number_format(PengaturanSistem::getVal('denda_harian', 1000), 0, ',', '.'),
            'denda_rusak_ringan' => number_format(PengaturanSistem::getVal('denda_rusak_ringan', 50000), 0, ',', '.'),
            'denda_hilang' => number_format(PengaturanSistem::getVal('denda_hilang', 100000), 0, ',', '.'),
            'notifikasi_wa' => PengaturanSistem::getVal('notifikasi_wa', true),
            'terakhir_update' => '15 Okt 2026, 09:30 WIB oleh Admin Utama'
        ];

        return view('pengaturan.index', compact('settings'));
    }
}
