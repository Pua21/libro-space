<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Pengarang;
use App\Models\Penerbit;
use App\Models\Rak;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'kategori');

        // Fetch categories with book counts
        $kategori = Kategori::withCount('buku')->get()->map(function ($k, $idx) {
            return [
                'id' => $k->id,
                'no' => str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
                'nama' => $k->nama_kategori,
                'jumlah' => $k->buku_count . ' Buku',
            ];
        })->toArray();

        // Fetch authors with book counts
        $pengarang = Pengarang::withCount('buku')->get()->map(function ($p, $idx) {
            return [
                'id' => $p->id,
                'no' => str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
                'nama' => $p->nama_pengarang,
                'jumlah' => $p->buku_count . ' Buku',
            ];
        })->toArray();

        // Fetch publishers with book counts
        $penerbit = Penerbit::withCount('buku')->get()->map(function ($pb, $idx) {
            return [
                'id' => $pb->id,
                'no' => str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
                'nama' => $pb->nama_penerbit,
                'jumlah' => $pb->buku_count . ' Buku',
            ];
        })->toArray();

        // Fetch shelves with book counts
        $rak = Rak::withCount('buku')->get()->map(function ($r, $idx) {
            return [
                'id' => $r->id,
                'no' => str_pad($idx + 1, 2, '0', STR_PAD_LEFT),
                'nama' => $r->nama_rak,
                'jumlah' => $r->buku_count . ' Buku',
            ];
        })->toArray();

        $totalItems = count($kategori) + count($pengarang) + count($penerbit) + count($rak);

        return view('master.index', compact('tab', 'kategori', 'pengarang', 'penerbit', 'rak', 'totalItems'));
    }
}
