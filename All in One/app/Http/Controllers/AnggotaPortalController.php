<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnggotaPortalController extends Controller
{
    /**
     * Tampilkan Portal Anggota (Libro Space).
     */
    public function index()
    {
        return view('anggota.portal');
    }
}
