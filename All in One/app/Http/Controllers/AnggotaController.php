<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $anggotaList = Anggota::with(['user', 'peminjaman'])->get()->map(function ($a) {
            $pinjamAktif = $a->peminjaman->where('status', 'dipinjam')->count();

            return [
                'id' => $a->no_anggota,
                'nama' => $a->user->name ?? 'Anggota',
                'email' => $a->user->email ?? '-',
                'jurusan' => $a->jurusan_unit ?? 'Umum',
                'kontak' => $a->no_telepon,
                'status' => ucfirst($a->user->status ?? 'aktif'),
                'avatar' => $a->user->avatar ?? 'images/avatar-nabila.png',
                'total_pinjam' => $pinjamAktif,
                'status_denda' => 'Tidak Ada (Lunas)',
                'tgl_registrasi' => $a->tgl_registrasi ? $a->tgl_registrasi->format('d M Y') : '14 Sep 2023',
                'masa_berlaku' => $a->masa_berlaku ? $a->masa_berlaku->format('d M Y') : '31 Des 2025',
            ];
        })->toArray();

        if (empty($anggotaList)) {
            $anggotaList = [
                ['id' => 'AGT-0001', 'nama' => 'Putri Ayu Lestari', 'email' => 'putri.ayu@univ.ac.id', 'jurusan' => 'Sistem Informasi', 'kontak' => '0812-3456-1234', 'status' => 'Aktif', 'avatar' => 'images/avatar-nabila.png', 'total_pinjam' => 3, 'status_denda' => 'Tidak Ada (Lunas)', 'tgl_registrasi' => '14 Sep 2023', 'masa_berlaku' => '31 Des 2025'],
                ['id' => 'AGT-0002', 'nama' => 'Dimas Pratama', 'email' => 'dimas.p@univ.ac.id', 'jurusan' => 'Akuntansi', 'kontak' => '0813-9876-5678', 'status' => 'Aktif', 'avatar' => 'images/avatar-dimas.png', 'total_pinjam' => 1, 'status_denda' => 'Rp 3.000', 'tgl_registrasi' => '10 Okt 2023', 'masa_berlaku' => '31 Des 2025'],
            ];
        }

        $selectedAnggota = $anggotaList[0];

        $totalCount = Anggota::count();
        $summary = [
            'total' => $totalCount > 0 ? $totalCount : 342,
            'total_growth' => '+12 bulan ini',
            'aktif' => $totalCount > 0 ? $totalCount : 318,
            'aktif_percent' => '93% dari total'
        ];

        return view('anggota.index', compact('anggotaList', 'selectedAnggota', 'summary'));
    }
}
