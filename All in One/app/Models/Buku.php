<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'kode_buku',
        'isbn',
        'judul',
        'kategori_id',
        'pengarang_id',
        'penerbit_id',
        'rak_id',
        'tahun_terbit',
        'sinopsis',
        'cover_image',
        'harga_asli',
        'total_stok',
        'stok_tersedia',
        'stok_dipinjam',
        'stok_rusak',
        'status',
    ];

    protected $casts = [
        'harga_asli' => 'decimal:2',
        'total_stok' => 'integer',
        'stok_tersedia' => 'integer',
        'stok_dipinjam' => 'integer',
        'stok_rusak' => 'integer',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function pengarang()
    {
        return $this->belongsTo(Pengarang::class, 'pengarang_id');
    }

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function rak()
    {
        return $this->belongsTo(Rak::class, 'rak_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}
