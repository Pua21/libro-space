<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DendaPembayaran extends Model
{
    use HasFactory;

    protected $table = 'denda_pembayaran';

    protected $fillable = [
        'no_kuitansi',
        'pengembalian_id',
        'anggota_id',
        'petugas_id',
        'total_tagihan',
        'uang_diterima',
        'uang_kembalian',
        'metode_bayar',
        'status_bayar',
        'tgl_bayar',
        'referensi_gateway',
    ];

    protected $casts = [
        'total_tagihan' => 'decimal:2',
        'uang_diterima' => 'decimal:2',
        'uang_kembalian' => 'decimal:2',
        'tgl_bayar' => 'datetime',
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class, 'pengembalian_id');
    }

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
