<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'kode_transaksi',
        'anggota_id',
        'buku_id',
        'petugas_id',
        'tgl_pinjam',
        'jatuh_tempo',
        'tgl_kembali_aktual',
        'jumlah_perpanjangan',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tgl_pinjam' => 'date',
        'jatuh_tempo' => 'date',
        'tgl_kembali_aktual' => 'date',
        'jumlah_perpanjangan' => 'integer',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}
