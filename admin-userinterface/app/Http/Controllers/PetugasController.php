<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $petugasList = Petugas::with('user')->get()->map(function ($p) {
            return [
                'id' => $p->id,
                'nama' => $p->user->name ?? 'Petugas',
                'role' => $p->jabatan,
                'username' => $p->user->username ?? '-',
                'email' => $p->user->email ?? '-',
                'terakhir_login' => $p->user->last_login_at ? $p->user->last_login_at->diffForHumans() : 'Hari ini',
                'status' => ucfirst($p->user->status ?? 'aktif'),
                'avatar' => $p->user->avatar ?? 'images/avatar-budi.png',
            ];
        })->toArray();

        $stats = [
            'total' => count($petugasList) ?: 6,
            'aktif' => count($petugasList) ?: 5,
            'online' => 3
        ];

        $selectedPetugas = $petugasList[0] ?? [
            'id' => 1,
            'nama' => 'Budi Santoso, S.Kom',
            'role' => 'Kepala Sirkulasi',
            'username' => 'budi.s',
            'email' => 'budi.santoso@perpustakaan.go.id',
            'terakhir_login' => 'Hari ini, 08:30 WIB',
            'status' => 'Aktif',
            'avatar' => 'images/avatar-budi.png'
        ];

        return view('petugas.index', compact('stats', 'petugasList', 'selectedPetugas'));
    }
}
