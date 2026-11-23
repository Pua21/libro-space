<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasPortalController extends Controller
{
    /**
     * Tampilkan Portal Operasional Petugas (Libro Space).
     */
    public function index()
    {
        return view('petugas.portal');
    }
}
