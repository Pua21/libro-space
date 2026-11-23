<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalian';

    protected $fillable = [
        'kode_pengembalian',
        'peminjaman_id',
        'petugas_id',
        'tgl_dikembalikan',
        'hari_terlambat',
        'kondisi_buku',
        'denda_terlambat',
        'denda_kondisi',
        'total_denda',
        'catatan_pemeriksaan',
    ];

    protected $casts = [
        'tgl_dikembalikan' => 'date',
        'hari_terlambat' => 'integer',
        'denda_terlambat' => 'decimal:2',
        'denda_kondisi' => 'decimal:2',
        'total_denda' => 'decimal:2',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function dendaPembayaran()
    {
        return $this->hasOne(DendaPembayaran::class, 'pengembalian_id');
    }
}
