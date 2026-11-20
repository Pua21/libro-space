@extends('layouts.app')

@section('title', 'Data Peminjaman')

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

<!-- PAGE TITLE & ACTIONS -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Peminjaman</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Semua transaksi peminjaman buku perpustakaan aktif dan riwayat sirkulasi</p>
    </div>

    <div class="flex items-center gap-3">
        <button class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-download text-gray-600"></i>
            <span>Ekspor Data</span>
        </button>

        <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Transaksi</span>
        </button>
    </div>
</div>

<!-- FILTERS & TABS -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center justify-between gap-4 mb-6">
    <!-- Tabs: Semua, Dipinjam, Kembali -->
    <div class="flex items-center gap-2">
        <button class="bg-[#554fed] text-white text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
            Semua <span class="ml-1 opacity-90">{{ $counts['semua'] }}</span>
        </button>
        <button class="bg-[#fef9c3] hover:bg-amber-100 text-[#ca8a04] text-xs font-semibold px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#ca8a04]"></span>
            Dipinjam <span class="opacity-90">{{ $counts['dipinjam'] }}</span>
        </button>
        <button class="bg-[#ecfdf5] hover:bg-emerald-100 text-[#10b981] text-xs font-semibold px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
            Kembali <span class="opacity-90">{{ $counts['kembali'] }}</span>
        </button>
    </div>

    <!-- Date Range & Search -->
    <div class="flex flex-wrap items-center gap-3">
        <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2 text-xs text-gray-700">
            <i class="bi bi-calendar text-gray-400"></i>
            <span>01 Okt 2026 – 02 Nov 2026</span>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>

        <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2 text-xs text-gray-700 cursor-pointer">
            <i class="bi bi-filter text-gray-400"></i>
            <span>Kategori Buku</span>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>

        <div class="relative min-w-[200px]">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   placeholder="Cari anggota, buku..." 
                   class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
        </div>
    </div>
</div>

<!-- MAIN GRID (Table & Editor Panel) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    
    <!-- LEFT: Table (8 cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <i class="bi bi-journal-text text-[#554fed] text-lg"></i>
                <h3 class="text-sm font-bold text-[#1e293b]">Daftar Sirkulasi Aktif</h3>
            </div>
            <span class="text-[11px] text-[#64748b]">Diperbarui 3 menit yang lalu</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[#64748b] font-semibold border-b border-gray-100">
                        <th class="pb-3.5 pl-2">Kode</th>
                        <th class="pb-3.5">Anggota</th>
                        <th class="pb-3.5">Buku Dipinjam</th>
                        <th class="pb-3.5">Tgl Pinjam</th>
                        <th class="pb-3.5">Jatuh Tempo</th>
                        <th class="pb-3.5 text-center">Status</th>
                        <th class="pb-3.5">Petugas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($sirkulasiList as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors {{ $item['kode'] == 'PJ-002' ? 'bg-[#fcfaff]' : '' }}">
                        <!-- Kode -->
                        <td class="py-4 pl-2 font-bold text-[#554fed]">
                            {{ $item['kode'] }}
                        </td>

                        <!-- Anggota -->
                        <td class="py-4">
                            <div class="flex items-center gap-2.5">
                                <img src="{{ asset($item['avatar']) }}" 
                                     alt="{{ $item['anggota'] }}" 
                                     class="w-8 h-8 rounded-full object-cover border border-gray-100">
                                <div>
                                    <p class="font-bold text-[#1e293b] leading-tight">{{ $item['anggota'] }}</p>
                                    <p class="text-[10px] text-[#64748b] font-mono">{{ $item['no_anggota'] }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Buku Dipinjam -->
                        <td class="py-4">
                            <div class="flex items-center gap-2.5">
                                <img src="{{ asset($item['cover']) }}" 
                                     alt="{{ $item['judul'] }}" 
                                     class="w-7 h-10 object-cover rounded shadow-sm border border-gray-100">
                                <div>
                                    <p class="font-bold text-[#1e293b] leading-tight">{{ $item['judul'] }}</p>
                                    <p class="text-[10px] text-[#64748b] font-mono">{{ $item['kode_buku'] }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Tgl Pinjam -->
                        <td class="py-4 text-[#64748b]">
                            {{ $item['tgl_pinjam'] }}
                        </td>

                        <!-- Jatuh Tempo -->
                        <td class="py-4">
                            @if($item['status'] == 'Terlambat')
                            <p class="font-bold text-[#ef4444] leading-tight">{{ $item['jatuh_tempo'] }}</p>
                            <p class="text-[10px] text-[#ef4444] font-medium">{{ $item['keterangan'] }}</p>
                            @else
                            <p class="text-[#1e293b] font-medium">{{ $item['jatuh_tempo'] }}</p>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="py-4 text-center">
                            @if($item['status'] == 'Dipinjam')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                                Dipinjam
                            </span>
                            @elseif($item['status'] == 'Kembali')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                Kembali
                            </span>
                            @elseif($item['status'] == 'Terlambat')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                                Terlambat
                            </span>
                            @endif
                        </td>

                        <!-- Petugas -->
                        <td class="py-4 text-[#64748b] font-medium">
                            {{ $item['petugas'] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 text-xs text-[#64748b]">
            <p>Menampilkan <span class="font-semibold text-[#1e293b]">1–6</span> dari <span class="font-semibold text-[#1e293b]">87</span> transaksi</p>
            <div class="flex items-center gap-1.5">
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
                <span class="px-1 text-gray-400">...</span>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">15</button>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- RIGHT: Panel Editor (4 cols) -->
    <div class="lg:col-span-4 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center justify-between mb-2">
            <div class="flex items-center gap-2">
                <i class="bi bi-sliders text-[#554fed] text-base"></i>
                <span class="text-[10px] font-bold tracking-wider text-[#554fed] uppercase">Panel Editor</span>
            </div>
            <span class="text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] px-2.5 py-0.5 rounded-full border border-[#fee2e2]">Terlambat</span>
        </div>

        <h3 class="text-base font-bold text-[#1e293b] tracking-tight">Koreksi Data Transaksi</h3>
        <p class="text-[11px] text-[#64748b] mt-0.5 mb-4">Ubah tenggat waktu atau status peminjaman {{ $editorData['kode'] }}</p>

        <!-- Preview Card for selected transaction -->
        <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4">
            <img src="{{ asset($editorData['cover']) }}" alt="Buku" class="w-10 h-14 object-cover rounded-md shadow border border-gray-200">
            <div>
                <span class="text-[10px] font-bold text-[#554fed]">{{ $editorData['kode'] }}</span>
                <h4 class="text-xs font-bold text-[#1e293b] leading-tight">{{ $editorData['judul'] }}</h4>
                <p class="text-[11px] text-[#64748b]">{{ $editorData['anggota'] }} ({{ $editorData['no_anggota'] }})</p>
                <p class="text-[10px] text-gray-400 mt-0.5">Petugas: {{ $editorData['petugas'] }}</p>
            </div>
        </div>

        <!-- Form fields -->
        <div class="space-y-3.5 text-xs">
            <!-- Nama Anggota (Disabled) -->
            <div>
                <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Nama Anggota</label>
                <div class="relative">
                    <input type="text" value="{{ $editorData['anggota'] }} ({{ $editorData['no_anggota'] }})" readonly 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-500 pr-9 cursor-not-allowed">
                    <i class="bi bi-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Judul Buku (Disabled) -->
            <div>
                <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Judul Buku</label>
                <div class="relative">
                    <input type="text" value="{{ $editorData['judul'] }} ({{ $editorData['kode_buku'] }})" readonly 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-500 pr-9 cursor-not-allowed">
                    <i class="bi bi-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Date columns -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Tanggal Pinjam</label>
                    <input type="text" value="{{ $editorData['tgl_pinjam'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2 text-xs text-gray-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-[#554fed] mb-1">Jatuh Tempo Baru</label>
                    <input type="text" value="{{ $editorData['jatuh_tempo_baru'] }}" 
                           class="w-full bg-white border-2 border-[#554fed] rounded-xl px-3 py-2 text-xs font-bold text-[#1e293b] focus:outline-none shadow-sm">
                </div>
            </div>

            <!-- Status Sirkulasi -->
            <div>
                <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Status Sirkulasi</label>
                <select class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                    <option selected>Terlambat (Denda Berjalan)</option>
                    <option>Dipinjam</option>
                    <option>Kembali</option>
                </select>
            </div>

            <!-- Alasan Koreksi Transaksi -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-[11px] font-bold text-[#1e293b]">Alasan Koreksi Transaksi <span class="text-rose-500">*</span></label>
                    <span class="text-[10px] text-gray-400">Wajib</span>
                </div>
                <textarea rows="3" 
                          placeholder="Misal: Perpanjangan khusus masa ujian, perbaikan tanggal input, konfirmasi dispensasi dosen..." 
                          class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl p-3 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 resize-none"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 pt-2">
                <button class="flex-1 bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 rounded-full flex items-center justify-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-check-lg"></i>
                    <span>Simpan Koreksi</span>
                </button>
                <button class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all">
                    Batal
                </button>
            </div>

            <!-- Footer note -->
            <div class="flex items-start gap-2 pt-2 text-[10px] text-[#64748b] leading-tight">
                <i class="bi bi-shield-check text-[#554fed] mt-0.5 text-xs"></i>
                <p>Semua koreksi transaksi dicatat dalam Log Aktivitas Audit Sirkulasi.</p>
            </div>
        </div>
    </div>

</div>
@endsection
