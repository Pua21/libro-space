@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="globalPeminjamanSearch"
               onkeyup="liveFilterPeminjaman()"
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
        <button onclick="exportPeminjamanData()" class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-download text-gray-600"></i>
            <span>Ekspor Data</span>
        </button>

        <button onclick="document.getElementById('addPeminjamanModal').classList.remove('hidden')" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Transaksi</span>
        </button>
    </div>
</div>

<!-- FILTERS & TABS -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center justify-between gap-4 mb-6">
    <!-- Tabs: Semua, Dipinjam, Kembali -->
    <div class="flex items-center gap-2" id="loanFilterTabs">
        <button onclick="setLoanStatusFilter('', this)" class="loan-tab-btn bg-[#554fed] text-white text-xs font-semibold px-4 py-2 rounded-full shadow-sm transition-all">
            Semua <span class="ml-1 opacity-90">{{ $counts['semua'] }}</span>
        </button>
        <button onclick="setLoanStatusFilter('Dipinjam', this)" class="loan-tab-btn bg-[#fef9c3] hover:bg-amber-100 text-[#ca8a04] text-xs font-semibold px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#ca8a04]"></span>
            Dipinjam <span class="opacity-90">{{ $counts['dipinjam'] }}</span>
        </button>
        <button onclick="setLoanStatusFilter('Kembali', this)" class="loan-tab-btn bg-[#ecfdf5] hover:bg-emerald-100 text-[#10b981] text-xs font-semibold px-4 py-2 rounded-full transition-colors flex items-center gap-1.5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
            Kembali <span class="opacity-90">{{ $counts['kembali'] }}</span>
        </button>
    </div>

    <!-- Date Range & Search -->
    <div class="flex flex-wrap items-center gap-3">
        <div class="relative">
            <select id="peminjamanDateFilter" onchange="liveFilterPeminjaman()" class="appearance-none bg-[#f8fafc] border border-gray-100 rounded-full pl-9 pr-8 py-2 text-xs text-gray-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                <option value="all">01 Okt 2026 – 02 Nov 2026</option>
                <option value="today">Hari Ini</option>
                <option value="month">Bulan Ini</option>
            </select>
            <i class="bi bi-calendar absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
        </div>

        <div class="relative">
            <select id="peminjamanCatFilter" onchange="liveFilterPeminjaman()" class="appearance-none bg-[#f8fafc] border border-gray-100 rounded-full pl-9 pr-8 py-2 text-xs text-gray-700 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                <option value="">Kategori Buku: Semua</option>
                <option value="Novel">Novel</option>
                <option value="Sastra">Sastra</option>
                <option value="Pengembangan Diri">Pengembangan Diri</option>
                <option value="Fiksi Sejarah">Fiksi Sejarah</option>
                <option value="Sejarah & Sains">Sejarah & Sains</option>
            </select>
            <i class="bi bi-filter absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
            <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
        </div>

        <div class="relative min-w-[200px]">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   id="peminjamanSearchInput"
                   onkeyup="liveFilterPeminjaman()"
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
            <table id="peminjamanTable" class="w-full text-left text-xs">
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
                    @foreach($sirkulasiList as $idx => $item)
                    <tr onclick="selectTransactionForEditor(this)" 
                        class="sirkulasi-row hover:bg-slate-50/80 cursor-pointer transition-colors {{ $item['kode'] == 'PJ-002' ? 'bg-[#fcfaff]' : '' }}"
                        data-kode="{{ $item['kode'] }}"
                        data-anggota="{{ $item['anggota'] }}"
                        data-no-anggota="{{ $item['no_anggota'] }}"
                        data-judul="{{ $item['judul'] }}"
                        data-kode-buku="{{ $item['kode_buku'] }}"
                        data-cover="{{ asset($item['cover']) }}"
                        data-pinjam="{{ $item['tgl_pinjam'] }}"
                        data-tempo="{{ $item['jatuh_tempo'] }}"
                        data-status="{{ $item['status'] }}"
                        data-petugas="{{ $item['petugas'] }}">
                        <!-- Kode -->
                        <td class="py-4 pl-2 font-bold text-[#554fed] row-kode-text">
                            {{ $item['kode'] }}
                        </td>

                        <!-- Anggota -->
                        <td class="py-4">
                            <div class="flex items-center gap-2.5">
                                @include('partials.avatar', [
                                    'name' => $item['anggota'],
                                    'avatar' => $item['avatar'] ?? null,
                                    'size' => 'w-8 h-8',
                                    'textSize' => 'text-[11px]'
                                ])
                                <div>
                                    <p class="font-bold text-[#1e293b] leading-tight row-anggota-text">{{ $item['anggota'] }}</p>
                                    <p class="text-[10px] text-[#64748b] font-mono">{{ $item['no_anggota'] }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Buku Dipinjam -->
                        <td class="py-4">
                            <div class="flex items-center gap-2.5">
                                <img src="{{ asset($item['cover']) }}" 
                                     alt="{{ $item['judul'] }}" 
                                     class="w-7 h-10 object-cover rounded shadow-sm border border-gray-100 row-cover-img">
                                <div>
                                    <p class="font-bold text-[#1e293b] leading-tight row-judul-text">{{ $item['judul'] }}</p>
                                    <p class="text-[10px] text-[#64748b] font-mono">{{ $item['kode_buku'] }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Tgl Pinjam -->
                        <td class="py-4 text-[#64748b] row-pinjam-text">
                            {{ $item['tgl_pinjam'] }}
                        </td>

                        <!-- Jatuh Tempo -->
                        <td class="py-4 row-tempo-cell">
                            @if($item['status'] == 'Terlambat')
                            <p class="font-bold text-[#ef4444] leading-tight row-tempo-text">{{ $item['jatuh_tempo'] }}</p>
                            <p class="text-[10px] text-[#ef4444] font-medium">{{ $item['keterangan'] }}</p>
                            @else
                            <p class="text-[#1e293b] font-medium row-tempo-text">{{ $item['jatuh_tempo'] }}</p>
                            @endif
                        </td>

                        <!-- Status -->
                        <td class="py-4 text-center row-status-cell">
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
            <p>Menampilkan <span class="font-semibold text-[#1e293b]" id="peminjamanVisibleCount">1–6</span> dari <span class="font-semibold text-[#1e293b]">87</span> transaksi</p>
            <div class="flex items-center gap-1.5">
                <button onclick="showToast('Halaman sebelumnya.');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                <button onclick="showToast('Membuka halaman 2...');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
                <button onclick="showToast('Membuka halaman 3...');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
                <span class="px-1 text-gray-400">...</span>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">15</button>
                <button onclick="showToast('Halaman berikutnya.');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
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
            <span id="editorStatusBadge" class="text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] px-2.5 py-0.5 rounded-full border border-[#fee2e2]">Terlambat</span>
        </div>

        <h3 class="text-base font-bold text-[#1e293b] tracking-tight">Koreksi Data Transaksi</h3>
        <p class="text-[11px] text-[#64748b] mt-0.5 mb-4">Ubah tenggat waktu atau status peminjaman <span id="editorTargetKode" class="font-bold text-[#554fed]">{{ $editorData['kode'] }}</span></p>

        <!-- Preview Card for selected transaction -->
        <div class="flex items-center gap-3 p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4">
            <img id="editorCover" src="{{ asset($editorData['cover']) }}" alt="Buku" class="w-10 h-14 object-cover rounded-md shadow border border-gray-200">
            <div>
                <span id="editorKodeLabel" class="text-[10px] font-bold text-[#554fed]">{{ $editorData['kode'] }}</span>
                <h4 id="editorJudul" class="text-xs font-bold text-[#1e293b] leading-tight">{{ $editorData['judul'] }}</h4>
                <p id="editorAnggota" class="text-[11px] text-[#64748b]">{{ $editorData['anggota'] }} ({{ $editorData['no_anggota'] }})</p>
                <p id="editorPetugas" class="text-[10px] text-gray-400 mt-0.5">Petugas: {{ $editorData['petugas'] }}</p>
            </div>
        </div>

        <!-- Form fields -->
        <form onsubmit="handleSaveCorrection(event)" class="space-y-3.5 text-xs">
            <!-- Nama Anggota (Disabled) -->
            <div>
                <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Nama Anggota</label>
                <div class="relative">
                    <input type="text" id="editorInputAnggota" value="{{ $editorData['anggota'] }} ({{ $editorData['no_anggota'] }})" readonly 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-500 pr-9 cursor-not-allowed">
                    <i class="bi bi-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Judul Buku (Disabled) -->
            <div>
                <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Judul Buku</label>
                <div class="relative">
                    <input type="text" id="editorInputBuku" value="{{ $editorData['judul'] }} ({{ $editorData['kode_buku'] }})" readonly 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-500 pr-9 cursor-not-allowed">
                    <i class="bi bi-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                </div>
            </div>

            <!-- Date columns -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Tanggal Pinjam</label>
                    <input type="text" id="editorInputPinjam" value="{{ $editorData['tgl_pinjam'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2 text-xs text-gray-700 focus:outline-none">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-[#554fed] mb-1">Jatuh Tempo Baru</label>
                    <input type="text" id="editorInputTempoBaru" value="{{ $editorData['jatuh_tempo_baru'] }}" 
                           class="w-full bg-white border-2 border-[#554fed] rounded-xl px-3 py-2 text-xs font-bold text-[#1e293b] focus:outline-none shadow-sm">
                </div>
            </div>

            <!-- Status Sirkulasi -->
            <div>
                <label class="block text-[11px] font-bold text-[#1e293b] mb-1">Status Sirkulasi</label>
                <select id="editorSelectStatus" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                    <option value="Terlambat">Terlambat (Denda Berjalan)</option>
                    <option value="Dipinjam">Dipinjam (Berjalan Normal)</option>
                    <option value="Kembali">Kembali (Selesai)</option>
                </select>
            </div>

            <!-- Alasan Koreksi Transaksi -->
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label class="text-[11px] font-bold text-[#1e293b]">Alasan Koreksi Transaksi <span class="text-rose-500">*</span></label>
                    <span class="text-[10px] text-gray-400">Wajib</span>
                </div>
                <textarea id="editorInputAlasan" rows="3" required
                          placeholder="Misal: Perpanjangan khusus masa ujian, perbaikan tanggal input, konfirmasi dispensasi dosen..." 
                          class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl p-3 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 resize-none"></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 pt-2">
                <button type="submit" class="flex-1 bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 rounded-full flex items-center justify-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-check-lg"></i>
                    <span>Simpan Koreksi</span>
                </button>
                <button type="button" onclick="resetEditorForm()" class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all">
                    Batal
                </button>
            </div>

            <!-- Footer note -->
            <div class="flex items-start gap-2 pt-2 text-[10px] text-[#64748b] leading-tight">
                <i class="bi bi-shield-check text-[#554fed] mt-0.5 text-xs"></i>
                <p>Semua koreksi transaksi dicatat dalam Log Aktivitas Audit Sirkulasi.</p>
            </div>
        </form>
    </div>

</div>

<!-- MODAL TAMBAH TRANSAKSI -->
<div id="addPeminjamanModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-journal-plus"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Buat Transaksi Peminjaman Baru</h3>
                    <p class="text-xs text-[#64748b]">Catat data peminjaman buku ke anggota perpustakaan</p>
                </div>
            </div>
            <button onclick="document.getElementById('addPeminjamanModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <form onsubmit="handleAddNewPeminjaman(event)" class="space-y-4 text-xs">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Nama Anggota</label>
                    <input type="text" id="newLoanNama" placeholder="Nama mahasiswa..." required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">No. Anggota / NIM</label>
                    <input type="text" id="newLoanNoAnggota" placeholder="Contoh: AGT-0009" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Buku Dipinjam</label>
                    <select id="newLoanBuku" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option value="Laskar Pelangi|BK-001">Laskar Pelangi (BK-001)</option>
                        <option value="Bumi Manusia|BK-002">Bumi Manusia (BK-002)</option>
                        <option value="Filosofi Teras|BK-003">Filosofi Teras (BK-003)</option>
                        <option value="Laut Bercerita|BK-004">Laut Bercerita (BK-004)</option>
                        <option value="Sapiens|BK-005">Sapiens (BK-005)</option>
                        <option value="Atomic Habits|BK-006">Atomic Habits (BK-006)</option>
                    </select>
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Petugas Pelayanan</label>
                    <input type="text" id="newLoanPetugas" value="Budi Santoso" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Tanggal Pinjam</label>
                    <input type="text" id="newLoanTglPinjam" value="21 Nov 2026" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Jatuh Tempo</label>
                    <input type="text" id="newLoanTglTempo" value="28 Nov 2026" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
            </div>
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('addPeminjamanModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                    <i class="bi bi-check-lg"></i>
                    <span>Simpan Transaksi</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeEditorRow = document.querySelector('.sirkulasi-row[data-kode="PJ-002"]') || document.querySelector('.sirkulasi-row');
    let activeLoanStatusFilter = '';

    function setLoanStatusFilter(status, btn) {
        activeLoanStatusFilter = status.toLowerCase();
        document.querySelectorAll('#loanFilterTabs button').forEach(b => {
            b.classList.remove('bg-[#554fed]', 'text-white');
            b.classList.add('bg-[#f8fafc]', 'text-[#64748b]');
        });
        btn.classList.remove('bg-[#f8fafc]', 'text-[#64748b]');
        btn.classList.add('bg-[#554fed]', 'text-white');

        liveFilterPeminjaman();
        showToast(status ? `Menampilkan status: ${status}` : 'Menampilkan semua transaksi peminjaman.', 'info');
    }

    function liveFilterPeminjaman() {
        const query = (document.getElementById('peminjamanSearchInput')?.value || document.getElementById('globalPeminjamanSearch')?.value || '').toLowerCase();
        const cat = (document.getElementById('peminjamanCatFilter')?.value || '').toLowerCase();
        const rows = document.querySelectorAll('.sirkulasi-row');
        let count = 0;

        rows.forEach(row => {
            const kode = (row.getAttribute('data-kode') || '').toLowerCase();
            const anggota = (row.getAttribute('data-anggota') || '').toLowerCase();
            const judul = (row.getAttribute('data-judul') || '').toLowerCase();
            const status = (row.getAttribute('data-status') || '').toLowerCase();

            const matchQuery = kode.includes(query) || anggota.includes(query) || judul.includes(query);
            const matchStatus = !activeLoanStatusFilter || status === activeLoanStatusFilter;
            const matchCat = !cat || judul.includes(cat);

            if (matchQuery && matchStatus && matchCat) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('peminjamanVisibleCount').textContent = `1–${count}`;
    }

    function selectTransactionForEditor(row) {
        document.querySelectorAll('.sirkulasi-row').forEach(r => r.classList.remove('bg-[#fcfaff]'));
        row.classList.add('bg-[#fcfaff]');
        activeEditorRow = row;

        const kode = row.getAttribute('data-kode');
        const anggota = row.getAttribute('data-anggota');
        const noAnggota = row.getAttribute('data-no-anggota');
        const judul = row.getAttribute('data-judul');
        const kodeBuku = row.getAttribute('data-kode-buku');
        const cover = row.getAttribute('data-cover');
        const pinjam = row.getAttribute('data-pinjam');
        const tempo = row.getAttribute('data-tempo');
        const status = row.getAttribute('data-status');
        const petugas = row.getAttribute('data-petugas');

        document.getElementById('editorTargetKode').textContent = kode;
        document.getElementById('editorKodeLabel').textContent = kode;
        document.getElementById('editorCover').src = cover;
        document.getElementById('editorJudul').textContent = judul;
        document.getElementById('editorAnggota').textContent = `${anggota} (${noAnggota})`;
        document.getElementById('editorPetugas').textContent = `Petugas: ${petugas}`;

        document.getElementById('editorInputAnggota').value = `${anggota} (${noAnggota})`;
        document.getElementById('editorInputBuku').value = `${judul} (${kodeBuku})`;
        document.getElementById('editorInputPinjam').value = pinjam;
        document.getElementById('editorInputTempoBaru').value = tempo;
        document.getElementById('editorSelectStatus').value = status;

        const badge = document.getElementById('editorStatusBadge');
        badge.textContent = status;
        if (status === 'Terlambat') {
            badge.className = 'text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] px-2.5 py-0.5 rounded-full border border-[#fee2e2]';
        } else if (status === 'Kembali') {
            badge.className = 'text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] px-2.5 py-0.5 rounded-full border border-[#d1fae5]';
        } else {
            badge.className = 'text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] px-2.5 py-0.5 rounded-full border border-[#fef3c7]';
        }

        showToast(`Memuat data ${kode} ke Panel Editor.`, 'info');
    }

    function handleSaveCorrection(e) {
        e.preventDefault();
        if (!activeEditorRow) return;

        const kode = activeEditorRow.getAttribute('data-kode');
        const newTempo = document.getElementById('editorInputTempoBaru').value;
        const newStatus = document.getElementById('editorSelectStatus').value;
        const alasan = document.getElementById('editorInputAlasan').value;

        activeEditorRow.setAttribute('data-tempo', newTempo);
        activeEditorRow.setAttribute('data-status', newStatus);

        const tempoCell = activeEditorRow.querySelector('.row-tempo-cell');
        const statusCell = activeEditorRow.querySelector('.row-status-cell');

        if (newStatus === 'Terlambat') {
            tempoCell.innerHTML = `<p class="font-bold text-[#ef4444] leading-tight row-tempo-text">${newTempo}</p><p class="text-[10px] text-[#ef4444] font-medium">(diperpanjang khusus)</p>`;
            statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]"><span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>Terlambat</span>`;
        } else if (newStatus === 'Kembali') {
            tempoCell.innerHTML = `<p class="text-[#1e293b] font-medium row-tempo-text">${newTempo}</p>`;
            statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]"><span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>Kembali</span>`;
        } else {
            tempoCell.innerHTML = `<p class="text-[#1e293b] font-medium row-tempo-text">${newTempo}</p>`;
            statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7]"><span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>Dipinjam</span>`;
        }

        document.getElementById('editorStatusBadge').textContent = newStatus;
        showToast(`Koreksi data ${kode} berhasil disimpan! Catatan audit telah diperbarui.`);
    }

    function resetEditorForm() {
        if (activeEditorRow) {
            selectTransactionForEditor(activeEditorRow);
            document.getElementById('editorInputAlasan').value = '';
            showToast('Form koreksi dikembalikan ke nilai semula.');
        }
    }

    function exportPeminjamanData() {
        const rows = document.querySelectorAll('.sirkulasi-row');
        let csv = "Kode,Anggota,No Anggota,Buku,Tgl Pinjam,Jatuh Tempo,Status,Petugas\n";
        rows.forEach(r => {
            csv += `"${r.getAttribute('data-kode')}","${r.getAttribute('data-anggota')}","${r.getAttribute('data-no-anggota')}","${r.getAttribute('data-judul')}","${r.getAttribute('data-pinjam')}","${r.getAttribute('data-tempo')}","${r.getAttribute('data-status')}","${r.getAttribute('data-petugas')}"\n`;
        });
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = "data_peminjaman_sirkulasi.csv";
        a.click();
        window.URL.revokeObjectURL(url);
        showToast('Data peminjaman berhasil diekspor ke CSV!');
    }

    function handleAddNewPeminjaman(e) {
        e.preventDefault();
        const nama = document.getElementById('newLoanNama').value;
        const noAnggota = document.getElementById('newLoanNoAnggota').value;
        const bukuRaw = document.getElementById('newLoanBuku').value.split('|');
        const judul = bukuRaw[0];
        const kodeBuku = bukuRaw[1] || 'BK-001';
        const petugas = document.getElementById('newLoanPetugas').value;
        const pinjam = document.getElementById('newLoanTglPinjam').value;
        const tempo = document.getElementById('newLoanTglTempo').value;
        const kode = 'PJ-' + String(Math.floor(Math.random() * 900) + 100);
        const cover = "{{ asset('images/book-laskar-pelangi.png') }}";

        const tbody = document.querySelector('#peminjamanTable tbody');
        const tr = document.createElement('tr');
        tr.className = 'sirkulasi-row hover:bg-slate-50/80 cursor-pointer transition-colors animate-in fade-in';
        tr.setAttribute('onclick', 'selectTransactionForEditor(this)');
        tr.setAttribute('data-kode', kode);
        tr.setAttribute('data-anggota', nama);
        tr.setAttribute('data-no-anggota', noAnggota);
        tr.setAttribute('data-judul', judul);
        tr.setAttribute('data-kode-buku', kodeBuku);
        tr.setAttribute('data-cover', cover);
        tr.setAttribute('data-pinjam', pinjam);
        tr.setAttribute('data-tempo', tempo);
        tr.setAttribute('data-status', 'Dipinjam');
        tr.setAttribute('data-petugas', petugas);

        tr.innerHTML = `
            <td class="py-4 pl-2 font-bold text-[#554fed] row-kode-text">${kode}</td>
            <td class="py-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-[#554fed] text-white flex items-center justify-center font-bold text-xs">
                        ${nama.charAt(0)}
                    </div>
                    <div>
                        <p class="font-bold text-[#1e293b] leading-tight row-anggota-text">${nama}</p>
                        <p class="text-[10px] text-[#64748b] font-mono">${noAnggota}</p>
                    </div>
                </div>
            </td>
            <td class="py-4">
                <div class="flex items-center gap-2.5">
                    <img src="${cover}" alt="${judul}" class="w-7 h-10 object-cover rounded shadow-sm border border-gray-100 row-cover-img">
                    <div>
                        <p class="font-bold text-[#1e293b] leading-tight row-judul-text">${judul}</p>
                        <p class="text-[10px] text-[#64748b] font-mono">${kodeBuku}</p>
                    </div>
                </div>
            </td>
            <td class="py-4 text-[#64748b] row-pinjam-text">${pinjam}</td>
            <td class="py-4 row-tempo-cell">
                <p class="text-[#1e293b] font-medium row-tempo-text">${tempo}</p>
            </td>
            <td class="py-4 text-center row-status-cell">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                    Dipinjam
                </span>
            </td>
            <td class="py-4 text-[#64748b] font-medium">${petugas}</td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
        document.getElementById('addPeminjamanModal').classList.add('hidden');
        showToast(`Transaksi baru ${kode} untuk ${nama} berhasil ditambahkan!`);
        selectTransactionForEditor(tr);
    }
</script>
@endpush
