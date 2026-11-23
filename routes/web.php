<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
if (app()->isLocal()) {
    Route::get('/preview-layout/{role}', function (string $role) {
        return view('preview.layout', ['role' => $role]);
    })->whereIn('role', ['admin', 'petugas', 'anggota']);
}