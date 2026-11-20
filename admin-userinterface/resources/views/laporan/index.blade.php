@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               placeholder="Pencarian umum sistem..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-11 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all">
    </div>

    <div class="flex items-center gap-3">
        <button class="relative w-10 h-10 rounded-full bg-[#f8fafc] hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-all border border-gray-100">
            <i class="bi bi-bell text-base"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-[#f43f5e] rounded-full ring-2 ring-white"></span>
        </button>

        <div class="flex items-center gap-3 pl-2 pr-3 py-1.5 rounded-full bg-[#f8fafc] border border-gray-100 hover:bg-gray-50 transition-all cursor-pointer">
            <img src="{{ asset('images/avatar-admin.png') }}" 
                 alt="Admin" 
                 class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-100">
            <div class="text-left hidden sm:block">
                <p class="text-xs font-bold text-[#1e293b] leading-tight">Admin Perpustakaan</p>
                <p class="text-[10px] text-[#64748b] font-medium">Super Administrator</p>
            </div>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

<!-- PAGE TITLE & DESCRIPTION -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Laporan</h2>
    <p class="text-xs text-[#64748b] font-medium mt-0.5">Buat, tinjau, dan ekspor laporan rekapitulasi data perpustakaan</p>
</div>

<!-- 5 REPORT TYPE CARDS -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <!-- 1. Laporan Buku -->
    <a href="{{ route('laporan.index', ['tab' => 'buku']) }}" 
       class="bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group {{ $activeTab == 'buku' ? 'border-2 border-[#554fed]' : '' }}">
        <div class="w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-book"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#1e293b]">Laporan Buku</h4>
            <p class="text-[11px] text-[#64748b] mt-0.5">Koleksi & Eksemplar</p>
        </div>
    </a>

    <!-- 2. Laporan Anggota -->
    <a href="{{ route('laporan.index', ['tab' => 'anggota']) }}" 
       class="bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group {{ $activeTab == 'anggota' ? 'border-2 border-[#554fed]' : '' }}">
        <div class="w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#1e293b]">Laporan Anggota</h4>
            <p class="text-[11px] text-[#64748b] mt-0.5">Keanggotaan & Status</p>
        </div>
    </a>

    <!-- 3. Laporan Peminjaman (Active) -->
    <a href="{{ route('laporan.index', ['tab' => 'peminjaman']) }}" 
       class="bg-white rounded-3xl p-5 glass-card transition-all flex flex-col justify-between relative border-2 border-[#554fed] shadow-md shadow-indigo-500/10">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-2xl bg-[#554fed] text-white flex items-center justify-center text-lg">
                <i class="bi bi-journal-text"></i>
            </div>
            <span class="text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#1e293b]">Laporan Peminjaman</h4>
            <p class="text-[11px] text-[#64748b] mt-0.5">Riwayat Sirkulasi & Jatuh Tempo</p>
        </div>
    </a>

    <!-- 4. Laporan Pengembalian -->
    <a href="{{ route('laporan.index', ['tab' => 'pengembalian']) }}" 
       class="bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group {{ $activeTab == 'pengembalian' ? 'border-2 border-[#554fed]' : '' }}">
        <div class="w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-box-arrow-in-down-left"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#1e293b]">Laporan Pengembalian</h4>
            <p class="text-[11px] text-[#64748b] mt-0.5">Pengembalian & Kondisi</p>
        </div>
    </a>

    <!-- 5. Laporan Denda -->
    <a href="{{ route('laporan.index', ['tab' => 'denda']) }}" 
       class="bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group {{ $activeTab == 'denda' ? 'border-2 border-[#554fed]' : '' }}">
        <div class="w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-cash-coin"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#1e293b]">Laporan Denda</h4>
            <p class="text-[11px] text-[#64748b] mt-0.5">Kas & Rekap Pembayaran</p>
        </div>
    </a>
</div>

<!-- FILTER & PARAMETER CARD -->
<div class="bg-white rounded-3xl p-6 glass-card mb-6">
    <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <i class="bi bi-sliders text-[#554fed] text-base"></i>
            <h3 class="text-sm font-bold text-[#1e293b]">Filter & Parameter Laporan</h3>
        </div>
        <span class="text-xs text-[#64748b]">Pilih rentang tanggal dan status transaksi</span>
    </div>

    <div class="space-y-4">
        <div>
            <p class="text-[11px] font-bold text-[#1e293b] mb-2">Periode Waktu</p>
            <div class="flex flex-wrap items-center gap-2">
                <button class="px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100">Hari Ini</button>
                <button class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#554fed] text-white shadow-sm">Bulan Ini</button>
                <button class="px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100">3 Bulan</button>
                <button class="px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100">Tahun Ini</button>
                <button class="px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100">Kustom</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-4">
                <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2.5 text-xs text-gray-700">
                    <i class="bi bi-calendar text-gray-400"></i>
                    <span>01 Okt 2026 – 31 Okt 2026</span>
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-[10px] text-gray-400 mb-1">Status Peminjaman</label>
                <select class="w-full bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                    <option>Semua Status</option>
                    <option>Selesai</option>
                    <option>Dipinjam</option>
                    <option>Terlambat</option>
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-[10px] text-gray-400 mb-1">Kategori Buku</label>
                <select class="w-full bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                    <option>Semua Kategori</option>
                    <option>Novel</option>
                    <option>Sastra</option>
                    <option>Pengembangan Diri</option>
                    <option>Fiksi Sejarah</option>
                    <option>Sejarah & Sains</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button class="w-full bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 px-4 rounded-full flex items-center justify-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-funnel"></i>
                    <span>Tampilkan Laporan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- REPORT PREVIEW CARD -->
<div class="bg-white rounded-3xl p-6 glass-card">
    <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-5 border-b border-gray-100">
        <div>
            <h3 class="text-base font-bold text-[#1e293b]">Pratinjau: Rekapitulasi Peminjaman Buku (Oktober 2026)</h3>
            <p class="text-xs text-[#64748b] mt-0.5">Menampilkan seluruh catatan riwayat transaksi aktif dan terselesaikan</p>
        </div>

        <div class="flex items-center gap-2">
            <button class="bg-[#fef2f2] hover:bg-rose-100 border border-[#fee2e2] text-[#ef4444] text-xs font-bold px-4 py-2 rounded-full flex items-center gap-1.5 transition-colors">
                <i class="bi bi-file-earmark-pdf"></i>
                <span>Ekspor PDF</span>
            </button>
            <button class="bg-[#ecfdf5] hover:bg-emerald-100 border border-[#d1fae5] text-[#10b981] text-xs font-bold px-4 py-2 rounded-full flex items-center gap-1.5 transition-colors">
                <i class="bi bi-file-earmark-excel"></i>
                <span>Ekspor Excel</span>
            </button>
        </div>
    </div>

    <!-- 4 SUMMARY STATS -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                <i class="bi bi-journal-check"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]">Total Transaksi</p>
                <h4 class="text-xl font-extrabold text-[#1e293b]">{{ $metrics['total_transaksi'] }}</h4>
            </div>
        </div>

        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-[#f59e0b] flex items-center justify-center text-lg">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]">Dipinjam</p>
                <h4 class="text-xl font-extrabold text-[#f59e0b]">{{ $metrics['dipinjam'] }}</h4>
            </div>
        </div>

        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#10b981] flex items-center justify-center text-lg">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]">Kembali Tepat Waktu</p>
                <h4 class="text-xl font-extrabold text-[#10b981]">{{ $metrics['tepat_waktu'] }}</h4>
            </div>
        </div>

        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-rose-100 text-[#ef4444] flex items-center justify-center text-lg">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]">Terlambat</p>
                <h4 class="text-xl font-extrabold text-[#ef4444]">{{ $metrics['terlambat'] }}</h4>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="text-[#64748b] font-semibold border-b border-gray-100 uppercase text-[11px]">
                    <th class="pb-3.5 pl-2">Kode Transaksi</th>
                    <th class="pb-3.5">Anggota</th>
                    <th class="pb-3.5">Buku Dipinjam</th>
                    <th class="pb-3.5">Tgl Pinjam</th>
                    <th class="pb-3.5">Tgl Kembali / Jatuh Tempo</th>
                    <th class="pb-3.5 text-center">Status Sirkulasi</th>
                    <th class="pb-3.5">Petugas</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($laporanList as $row)
                <tr class="hover:bg-slate-50/70 transition-colors">
                    <td class="py-4 pl-2 font-bold text-[#554fed] font-mono">
                        {{ $row['kode'] }}
                    </td>

                    <td class="py-4">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                                {{ $row['inisial'] }}
                            </div>
                            <div>
                                <p class="font-bold text-[#1e293b] leading-tight">{{ $row['anggota'] }}</p>
                                <p class="text-[10px] text-[#64748b] font-mono">{{ $row['no_anggota'] }}</p>
                            </div>
                        </div>
                    </td>

                    <td class="py-4">
                        <div class="flex items-center gap-2">
                            <i class="bi bi-book text-[#554fed]"></i>
                            <span class="font-medium text-[#1e293b]">{{ $row['buku'] }}</span>
                        </div>
                    </td>

                    <td class="py-4 text-[#64748b]">
                        {{ $row['tgl_pinjam'] }}
                    </td>

                    <td class="py-4">
                        @if($row['is_late'])
                        <span class="text-[#ef4444] font-bold">{{ $row['tgl_kembali'] }}</span>
                        @else
                        <span class="text-[#1e293b] font-medium">{{ $row['tgl_kembali'] }}</span>
                        @endif
                    </td>

                    <td class="py-4 text-center">
                        @if($row['status'] == 'Selesai')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Selesai
                        </span>
                        @elseif($row['status'] == 'Terlambat')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span> Terlambat
                        </span>
                        @elseif($row['status'] == 'Dipinjam')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span> Dipinjam
                        </span>
                        @endif
                    </td>

                    <td class="py-4 text-[#64748b] font-medium">
                        {{ $row['petugas'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 text-xs text-[#64748b]">
        <p>Menampilkan <span class="font-semibold text-[#1e293b]">1–6</span> dari <span class="font-semibold text-[#1e293b]">214</span> baris data</p>
        <div class="flex items-center gap-1.5">
            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                <i class="bi bi-chevron-left text-[10px]"></i>
            </button>
            <button class="w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
            <span class="px-1 text-gray-400">...</span>
            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">36</button>
            <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                <i class="bi bi-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>
</div>
@endsection
