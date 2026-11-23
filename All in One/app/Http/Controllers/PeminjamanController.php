<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $all = Peminjaman::with(['anggota.user', 'buku', 'petugas'])->get();

        $counts = [
            'semua' => $all->count() ?: 87,
            'dipinjam' => $all->where('status', 'dipinjam')->count() ?: 58,
            'kembali' => $all->where('status', 'kembali')->count() ?: 21
        ];

        $sirkulasiList = $all->map(function ($p) {
            $statusType = match ($p->status) {
                'kembali' => 'success',
                'dipinjam' => 'warning',
                'terlambat' => 'danger',
                default => 'info',
            };

            return [
                'kode' => $p->kode_transaksi,
                'anggota' => $p->anggota->user->name ?? 'Anggota',
                'no_anggota' => $p->anggota->no_anggota ?? 'AGT-0000',
                'avatar' => $p->anggota->user->avatar ?? 'images/avatar-nabila.png',
                'judul' => $p->buku->judul ?? '-',
                'kode_buku' => $p->buku->kode_buku ?? '-',
                'cover' => $p->buku->cover_image ?? 'images/book-laskar-pelangi.png',
                'tgl_pinjam' => $p->tgl_pinjam ? $p->tgl_pinjam->format('d M Y') : '02 Nov 2026',
                'jatuh_tempo' => $p->jatuh_tempo ? $p->jatuh_tempo->format('d M Y') : '09 Nov 2026',
                'status' => ucfirst($p->status),
                'status_type' => $statusType,
                'petugas' => $p->petugas->name ?? 'Petugas',
                'keterangan' => $p->status === 'terlambat' ? '(lewat jatuh tempo)' : '',
            ];
        })->toArray();

        $editorData = [
            'kode' => 'PJ-002',
            'judul' => 'Bumi Manusia',
            'kode_buku' => 'BK-002',
            'cover' => 'images/book-bumi-manusia.png',
            'anggota' => 'Dimas Pratama',
            'no_anggota' => 'AGT-0002',
            'petugas' => 'Siti Rahma',
            'tgl_pinjam' => '10/20/2026',
            'jatuh_tempo_baru' => '11/05/2026',
            'status' => 'Terlambat (Denda Berjalan)'
        ];

        return view('peminjaman.index', compact('counts', 'sirkulasiList', 'editorData'));
    }
}
