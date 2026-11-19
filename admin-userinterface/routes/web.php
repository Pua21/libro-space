<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MasterController;

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

// Placeholder routes for other sidebar items
Route::get('/data-anggota', function () {
    return redirect()->route('dashboard');
})->name('anggota.index');

Route::get('/data-petugas', function () {
    return redirect()->route('dashboard');
})->name('petugas.index');

Route::get('/data-peminjaman', function () {
    return redirect()->route('dashboard');
})->name('peminjaman.index');

Route::get('/pengembalian-denda', function () {
    return redirect()->route('dashboard');
})->name('pengembalian.index');

Route::get('/laporan', function () {
    return redirect()->route('dashboard');
})->name('laporan.index');

Route::get('/log-aktivitas', function () {
    return redirect()->route('dashboard');
})->name('log.index');

Route::get('/pengaturan', function () {
    return redirect()->route('dashboard');
})->name('pengaturan.index');

Route::get('/profil', function () {
    return redirect()->route('dashboard');
})->name('profil.index');
