<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'kategori');

        $kategori = [
            ['no' => '01', 'nama' => 'Novel', 'jumlah' => '320 Buku'],
            ['no' => '02', 'nama' => 'Sastra', 'jumlah' => '145 Buku'],
            ['no' => '03', 'nama' => 'Sains & Teknologi', 'jumlah' => '98 Buku'],
            ['no' => '04', 'nama' => 'Pengembangan Diri', 'jumlah' => '110 Buku'],
            ['no' => '05', 'nama' => 'Sejarah & Budaya', 'jumlah' => '76 Buku'],
            ['no' => '06', 'nama' => 'Filsafat', 'jumlah' => '42 Buku'],
        ];

        $pengarang = [
            ['no' => '01', 'nama' => 'Andrea Hirata', 'jumlah' => '12 Buku'],
            ['no' => '02', 'nama' => 'Pramoedya Ananta Toer', 'jumlah' => '18 Buku'],
            ['no' => '03', 'nama' => 'Henry Manampiring', 'jumlah' => '5 Buku'],
            ['no' => '04', 'nama' => 'Leila S. Chudori', 'jumlah' => '7 Buku'],
            ['no' => '05', 'nama' => 'Yuval Noah Harari', 'jumlah' => '4 Buku'],
            ['no' => '06', 'nama' => 'James Clear', 'jumlah' => '3 Buku'],
        ];

        $penerbit = [
            ['no' => '01', 'nama' => 'Gramedia Pustaka Utama', 'jumlah' => '420 Buku'],
            ['no' => '02', 'nama' => 'Bentang Pustaka', 'jumlah' => '210 Buku'],
            ['no' => '03', 'nama' => 'Mizan Media Utama', 'jumlah' => '180 Buku'],
            ['no' => '04', 'nama' => 'Kepustakaan Populer Gramedia', 'jumlah' => '150 Buku'],
            ['no' => '05', 'nama' => 'Informatika Bandung', 'jumlah' => '95 Buku'],
            ['no' => '06', 'nama' => 'Andi Offset', 'jumlah' => '85 Buku'],
        ];

        $rak = [
            ['no' => '01', 'nama' => 'Rak A1 - Sastra & Fiksi', 'jumlah' => '85 Buku'],
            ['no' => '02', 'nama' => 'Rak A2 - Sastra Klasik', 'jumlah' => '60 Buku'],
            ['no' => '03', 'nama' => 'Rak B1 - Self Development', 'jumlah' => '75 Buku'],
            ['no' => '04', 'nama' => 'Rak B2 - Motivasi & Karir', 'jumlah' => '65 Buku'],
            ['no' => '05', 'nama' => 'Rak C1 - Penelitian & Ilmiah', 'jumlah' => '90 Buku'],
            ['no' => '06', 'nama' => 'Rak C2 - Sains & Sejarah', 'jumlah' => '70 Buku'],
        ];

        $totalItems = 18;

        return view('master.index', compact('tab', 'kategori', 'pengarang', 'penerbit', 'rak', 'totalItems'));
    }
}
