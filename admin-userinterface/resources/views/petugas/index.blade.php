@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               placeholder="Cari fitur, buku, staf..." 
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
                <p class="text-[10px] text-[#64748b] font-medium">Administrator Utama</p>
            </div>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

<!-- PAGE TITLE & ACTIONS -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Petugas</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Manajemen akun staf, petugas sirkulasi, dan hak akses sistem</p>
    </div>

    <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
        <i class="bi bi-person-plus text-sm"></i>
        <span>+ Tambah Petugas</span>
    </button>
</div>

<!-- 3 METRIC CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <!-- Total Petugas -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-xl">
                <i class="bi bi-person-badge"></i>
            </div>
            <div>
                <p class="text-xs text-[#64748b] font-medium">Total Petugas</p>
                <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight">{{ $stats['total'] }} <span class="text-xs font-normal text-gray-500">Petugas</span></h3>
            </div>
        </div>
        <span class="text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] px-3 py-1 rounded-full">Total Staf</span>
    </div>

    <!-- Petugas Aktif -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#ecfdf5] text-[#10b981] flex items-center justify-center text-xl">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <p class="text-xs text-[#64748b] font-medium">Petugas Aktif</p>
                <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight">{{ $stats['aktif'] }} <span class="text-xs font-normal text-gray-500">Aktif</span></h3>
            </div>
        </div>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] px-3 py-1 rounded-full border border-[#d1fae5]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Terverifikasi
        </span>
    </div>

    <!-- Sedang Bertugas -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#fffbeb] text-[#f59e0b] flex items-center justify-center text-xl">
                <i class="bi bi-clock"></i>
            </div>
            <div>
                <p class="text-xs text-[#64748b] font-medium">Sedang Bertugas</p>
                <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight">{{ $stats['online'] }} <span class="text-xs font-normal text-gray-500">Online Saat Ini</span></h3>
            </div>
        </div>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#0d9488] bg-[#f0fdfa] px-3 py-1 rounded-full border border-[#ccfbf1]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#0d9488]"></span> Shift Pagi
        </span>
    </div>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center gap-3 mb-6">
    <div class="relative flex-1 min-w-[240px]">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        <input type="text" 
               placeholder="Cari nama petugas, username, atau email..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
    </div>

    <select class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option>Peran / Role: Semua</option>
        <option>Kepala Sirkulasi</option>
        <option>Staf Inventaris & Katalog</option>
        <option>Staf Peminjaman & Layanan</option>
        <option>Staf Pengembalian & Denda</option>
        <option>Petugas Arsip</option>
    </select>

    <select class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option>Status: Semua</option>
        <option>Aktif</option>
        <option>Nonaktif</option>
    </select>

    <button class="bg-[#f8fafc] hover:bg-gray-100 border border-gray-200 text-[#64748b] text-xs font-semibold px-4 py-2 rounded-full flex items-center gap-1.5 transition-all">
        <i class="bi bi-arrow-clockwise"></i>
        <span>Reset</span>
    </button>
</div>

<!-- MAIN GRID (Table & Quick Action) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-6">
    
    <!-- LEFT: Table (8 cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
            <div>
                <h3 class="text-sm font-bold text-[#1e293b]">Daftar Akun Petugas</h3>
                <p class="text-[11px] text-[#64748b] mt-0.5">6 akun staf terdaftar dalam sistem perpustakaan</p>
            </div>
            <select class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-3 py-1.5 text-gray-700 focus:outline-none cursor-pointer">
                <option>Urutkan: Terbaru Aktif</option>
                <option>Nama A-Z</option>
                <option>Role</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[#64748b] font-semibold border-b border-gray-100">
                        <th class="pb-3.5 pl-2">Petugas</th>
                        <th class="pb-3.5">Username</th>
                        <th class="pb-3.5">Email</th>
                        <th class="pb-3.5">Terakhir Login</th>
                        <th class="pb-3.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($petugasList as $petugas)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <!-- Petugas & Role -->
                        <td class="py-4 pl-2 flex items-center gap-3">
                            <img src="{{ asset($petugas['avatar']) }}" 
                                 alt="{{ $petugas['nama'] }}" 
                                 class="w-10 h-10 rounded-full object-cover border border-gray-100">
                            <div>
                                <p class="font-bold text-[#1e293b] text-xs leading-snug">{{ $petugas['nama'] }}</p>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-semibold text-[#554fed] bg-[#eef2ff]">
                                    {{ $petugas['role'] }}
                                </span>
                            </div>
                        </td>

                        <!-- Username -->
                        <td class="py-4 text-[#475569] font-medium font-mono text-[11px]">
                            {{ $petugas['username'] }}
                        </td>

                        <!-- Email -->
                        <td class="py-4 text-[#64748b]">
                            {{ $petugas['email'] }}
                        </td>

                        <!-- Terakhir Login -->
                        <td class="py-4 text-[#64748b]">
                            {{ $petugas['terakhir_login'] }}
                        </td>

                        <!-- Status -->
                        <td class="py-4 text-center">
                            @if($petugas['status'] == 'Aktif')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 text-xs text-[#64748b]">
            <p>Menampilkan <span class="font-semibold text-[#1e293b]">1–6</span> dari <span class="font-semibold text-[#1e293b]">6</span> petugas</p>
            <div class="flex items-center gap-1.5">
                <button class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 cursor-not-allowed">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-7 h-7 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                <button class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 cursor-not-allowed">
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- RIGHT: Quick Action (Reset Password) (4 cols) -->
    <div class="lg:col-span-4 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl bg-[#fef3c7] text-[#d97706] flex items-center justify-center text-lg">
                <i class="bi bi-key"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#1e293b]">Aksi Cepat</h3>
                <p class="text-[11px] text-[#64748b]">Reset Password Petugas</p>
            </div>
        </div>

        <p class="text-xs text-[#64748b] leading-relaxed mb-4">
            Buat kata sandi sementara yang aman untuk staf yang lupa akses login atau memerlukan pembaruan kredensial.
        </p>

        <!-- Selected User Box -->
        <div class="flex items-center justify-between p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/avatar-budi.png') }}" alt="Budi" class="w-9 h-9 rounded-full object-cover">
                <div>
                    <p class="text-xs font-bold text-[#1e293b] leading-tight">Budi Santoso, S.Kom</p>
                    <p class="text-[11px] text-[#64748b] font-mono">budi.s</p>
                </div>
            </div>
            <span class="text-[10px] font-semibold text-[#554fed] bg-[#eef2ff] px-2.5 py-1 rounded-full">Dipilih</span>
        </div>

        <!-- Password Generator Input -->
        <div class="mb-3">
            <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Kata Sandi Sementara (Acak & Aman)</label>
            <div class="relative">
                <input type="text" 
                       value="Perpus#2025!K9mZ" 
                       readonly
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-mono font-bold text-[#1e293b] pr-10 focus:outline-none">
                <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#554fed] transition-colors" title="Salin Password">
                    <i class="bi bi-copy text-sm"></i>
                </button>
            </div>
            <p class="flex items-center gap-1.5 text-[10px] text-[#10b981] font-semibold mt-1.5">
                <i class="bi bi-check-circle-fill"></i> Tingkat keamanan: Sangat Kuat (16 Karakter)
            </p>
        </div>

        <!-- Notification Checkbox -->
        <div class="flex items-start gap-2.5 p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4">
            <input type="checkbox" checked id="notifyEmail" class="mt-0.5 rounded text-[#554fed] focus:ring-[#554fed]">
            <label for="notifyEmail" class="text-xs text-[#1e293b] leading-snug cursor-pointer">
                <span class="font-semibold block">Kirim notifikasi ke email petugas</span>
                <span class="text-[11px] text-[#64748b]">Kredensial baru akan otomatis dikirimkan ke budi.santoso@perpustakaan.go.id</span>
            </label>
        </div>

        <!-- Alert note -->
        <div class="p-3 rounded-2xl bg-[#fffbeb] border border-[#fef3c7] text-[#92400e] text-[11px] flex items-start gap-2 mb-5">
            <i class="bi bi-info-circle-fill text-amber-500 mt-0.5 text-xs"></i>
            <p>Petugas diwajibkan mengganti kata sandi sementara ini saat login pertama kali ke sistem.</p>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-2">
            <button class="flex-1 bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 rounded-full flex items-center justify-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                <i class="bi bi-arrow-repeat"></i>
                <span>Reset Password</span>
            </button>
            <button class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all">
                Batal
            </button>
        </div>
    </div>

</div>

<!-- BOTTOM INFO FOOTER -->
<div class="flex flex-wrap items-center justify-between gap-4 text-xs text-[#64748b] pt-2 border-t border-gray-200/60">
    <div class="flex items-center gap-2">
        <i class="bi bi-shield-check text-[#10b981]"></i>
        <span>Semua pergantian kata sandi dan hak akses dicatat dalam <a href="{{ route('log.index') }}" class="text-[#554fed] font-semibold hover:underline">Log Aktivitas Keamanan</a>.</span>
    </div>
    <div>
        <span>Perpustakaan SIM v3.4 • Desain Serene Codex</span>
    </div>
</div>
@endsection
