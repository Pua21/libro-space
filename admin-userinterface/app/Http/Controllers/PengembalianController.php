<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\DendaPembayaran;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total_denda' => 'Rp 450.000',
            'total_change' => '+12% dibanding bulan lalu',
            'belum_bayar' => 'Rp 175.000',
            'menunggak' => '14 Anggota Menunggak',
            'denda_lunas' => 'Rp 275.000',
            'lunas_transaksi' => '38 Transaksi Selesai'
        ];

        $pengembalianList = Pengembalian::with(['peminjaman.anggota.user', 'peminjaman.buku', 'petugas', 'dendaPembayaran'])->get()->map(function ($pg) {
            $isPaid = $pg->dendaPembayaran && $pg->dendaPembayaran->status_bayar === 'lunas';
            $statusBayar = $pg->total_denda > 0 ? ($isPaid ? 'Lunas' : 'Belum Bayar') : 'Lunas';
            $action = $pg->total_denda > 0 ? ($isPaid ? 'kuitansi' : 'lunasi') : 'view';

            return [
                'kode' => $pg->kode_pengembalian,
                'anggota' => $pg->peminjaman->anggota->user->name ?? 'Anggota',
                'no_anggota' => $pg->peminjaman->anggota->no_anggota ?? 'AGT-0000',
                'avatar' => $pg->peminjaman->anggota->user->avatar ?? 'images/avatar-dimas.png',
                'buku' => $pg->peminjaman->buku->judul ?? '-',
                'cover' => $pg->peminjaman->buku->cover_image ?? 'images/book-bumi-manusia.png',
                'tgl_kembali' => $pg->tgl_dikembalikan ? $pg->tgl_dikembalikan->format('d M Y') : '30 Okt 2026',
                'keterlambatan' => $pg->hari_terlambat > 0 ? "{$pg->hari_terlambat} hari terlambat" : 'Tepat Waktu (0 hari)',
                'kondisi' => ucfirst(str_replace('_', ' ', $pg->kondisi_buku)),
                'nominal' => 'Rp ' . number_format($pg->total_denda, 0, ',', '.'),
                'keterangan_biaya' => $pg->denda_kondisi > 0 ? 'Telat + Rusak' : '',
                'status_bayar' => $statusBayar,
                'action' => $action
            ];
        })->toArray();

        if (empty($pengembalianList)) {
            $pengembalianList = [
                ['kode' => 'PG-001', 'anggota' => 'Dimas Pratama', 'no_anggota' => 'AGT-0002', 'avatar' => 'images/avatar-dimas.png', 'buku' => 'Bumi Manusia', 'cover' => 'images/book-bumi-manusia.png', 'tgl_kembali' => '30 Okt 2026', 'keterlambatan' => '3 hari terlambat', 'kondisi' => 'Baik', 'nominal' => 'Rp 3.000', 'keterangan_biaya' => '', 'status_bayar' => 'Belum Bayar', 'action' => 'lunasi'],
                ['kode' => 'PG-002', 'anggota' => 'Rina Wulandari', 'no_anggota' => 'AGT-0003', 'avatar' => 'images/avatar-siti.png', 'buku' => 'Filosofi Teras', 'cover' => 'images/book-filosofi-teras.png', 'tgl_kembali' => '22 Okt 2026', 'keterlambatan' => 'Tepat Waktu (0 hari)', 'kondisi' => 'Baik', 'nominal' => 'Rp 0', 'keterangan_biaya' => '', 'status_bayar' => 'Lunas', 'action' => 'view'],
            ];
        }

        $paymentQuick = [
            'kode' => 'PG-001',
            'inisial' => 'DP',
            'anggota' => 'Dimas Pratama',
            'keterangan' => '3 hari telat (Bumi Manusia)',
            'tarif_denda' => 'Rp 3.000',
            'biaya_admin' => 'Gratis',
            'total' => 'Rp 3.000',
            'uang_diterima' => '5.000',
            'kembalian' => 'Rp 2.000'
        ];

        return view('pengembalian.index', compact('stats', 'pengembalianList', 'paymentQuick'));
    }
}
