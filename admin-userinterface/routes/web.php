<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\ProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/data-buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/data-master', [MasterController::class, 'index'])->name('master.index');
Route::get('/data-anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/data-petugas', [PetugasController::class, 'index'])->name('petugas.index');
Route::get('/data-peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/pengembalian-denda', [PengembalianController::class, 'index'])->name('pengembalian.index');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
Route::get('/log-aktivitas', [LogAktivitasController::class, 'index'])->name('log.index');
Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
