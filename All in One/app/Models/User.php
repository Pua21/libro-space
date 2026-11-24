<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'avatar',
        'status',
        'two_factor_secret',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    // Alias 'nama' attribute to support ERD v2.0
    public function getNamaAttribute()
    {
        return $this->attributes['name'] ?? null;
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['name'] = $value;
    }

    // Relations
    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id');
    }

    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    public function peminjamanDilayani()
    {
        return $this->hasMany(Peminjaman::class, 'petugas_id');
    }

    public function pengembalianDiperiksa()
    {
        return $this->hasMany(Pengembalian::class, 'petugas_id');
    }

    public function dendaDiterima()
    {
        return $this->hasMany(DendaPembayaran::class, 'petugas_id');
    }

    public function logAktivitas()
    {
        return $this->hasMany(LogAktivitas::class, 'user_id');
    }

    // Role helper
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }
}
