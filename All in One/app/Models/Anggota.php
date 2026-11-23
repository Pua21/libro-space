<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'no_anggota',
        'tipe_anggota',
        'jurusan_unit',
        'no_telepon',
        'alamat',
        'tgl_registrasi',
        'masa_berlaku',
        'barcode',
    ];

    protected $casts = [
        'tgl_registrasi' => 'date',
        'masa_berlaku' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    public function dendaPembayaran()
    {
        return $this->hasMany(DendaPembayaran::class, 'anggota_id');
    }
}
