
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/petugas/dashboard', function () {
    return view('petugas.dashboard');
})->name('petugas.dashboard');
