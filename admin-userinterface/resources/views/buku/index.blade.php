@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <!-- Center Search Input -->
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               placeholder="Pencarian umum sistem..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-11 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all">
    </div>

    <!-- Right Icons & Profile -->
    <div class="flex items-center gap-3">
        <!-- Notification Bell -->
        <button class="relative w-10 h-10 rounded-full bg-[#f8fafc] hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-all border border-gray-100">
            <i class="bi bi-bell text-base"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-[#f43f5e] rounded-full ring-2 ring-white"></span>
        </button>

        <!-- User Profile Pill -->
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
<div class="flex flex-wrap items-center justify-between gap-4 mb-5">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Buku</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Katalog dan inventaris koleksi buku perpustakaan</p>
    </div>

    <div class="flex items-center gap-3">
        <!-- Button Impor Excel -->
        <button onclick="document.getElementById('importModal').classList.remove('hidden')" 
                class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-file-earmark-excel text-[#10b981] text-sm"></i>
            <span>Impor Excel</span>
        </button>

        <!-- Button Tambah Buku -->
        <button onclick="document.getElementById('addModal').classList.remove('hidden')" 
                class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Buku</span>
        </button>
    </div>
</div>

<!-- FILTER & SEARCH BAR -->
<form method="GET" action="{{ route('buku.index') }}" class="bg-white rounded-2xl p-3 glass-card mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <!-- Search -->
        <div class="relative flex-1 min-w-[240px]">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   name="search" 
                   value="{{ $search }}"
                   placeholder="Cari judul, pengarang, atau ISBN..." 
                   class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 transition-all">
        </div>

        <!-- Filter Kategori -->
        <div class="relative min-w-[160px]">
            <select name="kategori" class="w-full appearance-none bg-[#f8fafc] border border-gray-100 text-xs font-medium text-[#1e293b] rounded-full pl-4 pr-9 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                @foreach ($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ $selectedKategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
        </div>

        <!-- Filter Status -->
        <div class="relative min-w-[140px]">
            <select name="status" class="w-full appearance-none bg-[#f8fafc] border border-gray-100 text-xs font-medium text-[#1e293b] rounded-full pl-4 pr-9 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                @foreach ($statusList as $st)
                    <option value="{{ $st }}" {{ $selectedStatus == $st ? 'selected' : '' }}>{{ $st }}</option>
                @endforeach
            </select>
            <i class="bi bi-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
        </div>

        <!-- Button Terapkan -->
        <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-filter"></i>
            <span>Terapkan</span>
        </button>
    </div>
</form>

<!-- DATA TABLE CONTAINER -->
<div class="bg-white rounded-3xl p-6 glass-card">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider">
                    <th class="pb-3.5 px-3">Cover</th>
                    <th class="pb-3.5 px-3">Kode</th>
                    <th class="pb-3.5 px-3">Judul</th>
                    <th class="pb-3.5 px-3">Pengarang</th>
                    <th class="pb-3.5 px-3">Kategori</th>
                    <th class="pb-3.5 px-3">Rak</th>
                    <th class="pb-3.5 px-3">Stok</th>
                    <th class="pb-3.5 px-3 text-center">Status</th>
                    <th class="pb-3.5 px-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs">
                @forelse ($buku as $item)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <!-- Cover -->
                    <td class="py-3 px-3">
                        <img src="{{ asset($item['cover']) }}" 
                             alt="{{ $item['judul'] }}" 
                             class="w-8 h-11 object-cover rounded shadow-sm border border-gray-100">
                    </td>

                    <!-- Kode -->
                    <td class="py-3 px-3">
                        <span class="font-bold text-[#554fed]">{{ $item['kode'] }}</span>
                    </td>

                    <!-- Judul -->
                    <td class="py-3 px-3 font-bold text-[#1e293b]">
                        {{ $item['judul'] }}
                    </td>

                    <!-- Pengarang -->
                    <td class="py-3 px-3 text-[#64748b]">
                        {{ $item['pengarang'] }}
                    </td>

                    <!-- Kategori -->
                    <td class="py-3 px-3 text-[#1e293b] font-medium">
                        {{ $item['kategori'] }}
                    </td>

                    <!-- Rak -->
                    <td class="py-3 px-3 text-[#64748b]">
                        {{ $item['rak'] }}
                    </td>

                    <!-- Stok -->
                    <td class="py-3 px-3 font-bold text-[#1e293b]">
                        {{ $item['stok'] }}
                    </td>

                    <!-- Status -->
                    <td class="py-3 px-3 text-center">
                        @if ($item['status_type'] == 'success')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                {{ $item['status'] }}
                            </span>
                        @elseif ($item['status_type'] == 'warning')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                                {{ $item['status'] }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                                {{ $item['status'] }}
                            </span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="py-3 px-3 text-center">
                        <div class="inline-flex items-center gap-2">
                            <!-- View -->
                            <button title="Lihat Detail" class="w-8 h-8 rounded-full bg-indigo-50 text-[#554fed] hover:bg-indigo-100 flex items-center justify-center transition-colors">
                                <i class="bi bi-eye text-xs"></i>
                            </button>
                            <!-- Edit -->
                            <button title="Edit Data" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                <i class="bi bi-pencil text-xs"></i>
                            </button>
                            <!-- Delete -->
                            <button title="Hapus Data" class="w-8 h-8 rounded-full bg-red-50 text-[#ef4444] hover:bg-red-100 flex items-center justify-center transition-colors">
                                <i class="bi bi-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="py-8 text-center text-gray-400">
                        Tidak ada data buku yang sesuai filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-6 mt-4 border-t border-gray-100 text-xs">
        <p class="text-[#64748b]">
            Menampilkan <span class="font-bold text-[#1e293b]">1–6</span> dari <span class="font-bold text-[#1e293b]">{{ $totalBuku }}</span> buku
        </p>
        <div class="flex items-center gap-1.5">
            <button class="w-7 h-7 rounded-lg text-gray-400 hover:bg-gray-100 flex items-center justify-center font-bold">
                <i class="bi bi-chevron-left text-[10px]"></i>
            </button>
            <button class="w-7 h-7 rounded-lg bg-[#554fed] text-white font-bold flex items-center justify-center shadow-sm">1</button>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">2</button>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">3</button>
            <span class="px-1 text-gray-400">...</span>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">209</button>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">
                <i class="bi bi-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH BUKU -->
<div id="addModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Tambah Koleksi Buku</h3>
                    <p class="text-xs text-[#64748b]">Isi formulir lengkap untuk menambahkan buku baru</p>
                </div>
            </div>
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <form onsubmit="event.preventDefault(); alert('Buku berhasil disimpan!'); document.getElementById('addModal').classList.add('hidden');" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Judul Buku</label>
                <input type="text" placeholder="Masukkan judul buku..." required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Pengarang</label>
                    <input type="text" placeholder="Nama pengarang..." required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Kategori</label>
                    <select class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option>Novel</option>
                        <option>Sastra</option>
                        <option>Pengembangan Diri</option>
                        <option>Fiksi Sejarah</option>
                        <option>Sejarah & Sains</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Lokasi Rak</label>
                    <input type="text" placeholder="Contoh: Rak A1" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Jumlah Stok</label>
                    <input type="number" value="1" min="1" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
            </div>
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20">
                    Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL IMPOR EXCEL -->
<div id="importModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <h3 class="font-bold text-[#1e293b] text-base">Impor Data Buku Excel</h3>
            <button onclick="document.getElementById('importModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:bg-gray-50 cursor-pointer">
            <i class="bi bi-cloud-arrow-up text-4xl text-[#554fed] mb-2 block"></i>
            <p class="text-xs font-bold text-[#1e293b]">Pilih file Excel (.xlsx / .xls)</p>
            <p class="text-[11px] text-gray-400 mt-1">atau seret dan lepas file di sini</p>
        </div>
        <div class="pt-4 flex items-center justify-end gap-3 mt-4">
            <button onclick="document.getElementById('importModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 text-xs font-semibold">
                Batal
            </button>
            <button onclick="alert('File berhasil diunggah!'); document.getElementById('importModal').classList.add('hidden');" class="bg-[#10b981] hover:bg-[#059669] text-white text-xs font-bold px-6 py-2.5 rounded-full">
                Unggah & Proses
            </button>
        </div>
    </div>
</div>
@endsection
