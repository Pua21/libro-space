@extends('layouts.app')

@section('title', 'Log Aktivitas')

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
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Log Aktivitas</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Riwayat perubahan data dan audit trail di seluruh sistem perpustakaan</p>
    </div>

    <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
        <i class="bi bi-download"></i>
        <span>Ekspor Audit Log</span>
    </button>
</div>

<!-- FILTER BAR -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center gap-3 mb-6">
    <div class="relative flex-1 min-w-[240px]">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        <input type="text" 
               placeholder="Cari catatan aktivitas, nama pengguna..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
    </div>

    <select class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option>Semua Pengguna</option>
        <option>Budi Santoso</option>
        <option>Siti Rahmawati</option>
        <option>Ahmad Fauzi</option>
        <option>Maya Indriani</option>
        <option>Admin Perpustakaan</option>
    </select>

    <select class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option>Semua Modul</option>
        <option>Data Buku</option>
        <option>Peminjaman</option>
        <option>Data Master</option>
        <option>Pengaturan</option>
        <option>Data Anggota</option>
        <option>Autentikasi</option>
    </select>

    <select class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option>Semua Aksi</option>
        <option>Tambah</option>
        <option>Ubah</option>
        <option>Hapus</option>
        <option>Login / Keamanan</option>
    </select>

    <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2 text-xs text-gray-700">
        <i class="bi bi-calendar text-gray-400"></i>
        <span>01 Okt – 31 Okt 2026</span>
    </div>

    <button class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-colors">
        <i class="bi bi-arrow-clockwise text-sm"></i>
    </button>
</div>

<!-- MAIN GRID (Timeline & Sidebar Stats) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-6">
    
    <!-- LEFT: Timeline (8 cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center justify-between pb-4 mb-5 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-sm">
                    <i class="bi bi-activity"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1e293b]">Timeline Audit Aktivitas</h3>
            </div>
            <span class="text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] px-2.5 py-1 rounded-full">Sinkronisasi Real-time</span>
        </div>

        <div class="space-y-6">
            @foreach($timeline as $dateGroup => $items)
            <div>
                <!-- Group Header -->
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2 h-2 rounded-full bg-[#554fed]"></span>
                    <h4 class="text-xs font-bold text-[#1e293b] tracking-wider uppercase">{{ $dateGroup }}</h4>
                </div>

                <!-- Timeline items in this date -->
                <div class="space-y-3 pl-3 border-l-2 border-indigo-100/60 ml-1">
                    @foreach($items as $log)
                    <div class="p-3.5 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-indigo-100 transition-all flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-start gap-3">
                            <img src="{{ asset($log['avatar']) }}" alt="{{ $log['user'] }}" class="w-9 h-9 rounded-full object-cover border border-gray-100 mt-0.5">
                            <div>
                                <div class="flex flex-wrap items-center gap-2 mb-1">
                                    <!-- Aksi badge -->
                                    @if($log['aksi'] == 'Tambah')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5] px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Tambah
                                    </span>
                                    @elseif($log['aksi'] == 'Ubah')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7] px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span> Ubah
                                    </span>
                                    @elseif($log['aksi'] == 'Hapus')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2] px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span> Hapus
                                    </span>
                                    @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#554fed] bg-[#eff1fe] border border-indigo-100 px-2 py-0.5 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#554fed]"></span> {{ $log['aksi'] }}
                                    </span>
                                    @endif

                                    <!-- Modul badge -->
                                    <span class="text-[10px] font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">
                                        {{ $log['modul'] }}
                                    </span>

                                    <!-- Device & Time -->
                                    <span class="text-[10px] text-gray-400">
                                        {{ $log['waktu'] }} • {{ $log['device'] }}
                                    </span>
                                </div>

                                <p class="text-xs text-[#1e293b] leading-relaxed">
                                    <span class="font-bold text-[#554fed]">{{ $log['user'] }}</span> 
                                    {{ $log['deskripsi'] }}
                                    @if($log['target'])
                                        @if($log['highlight_type'] == 'danger')
                                        <span class="font-bold text-[#ef4444]">{{ $log['target'] }}</span>
                                        @elseif($log['highlight_type'] == 'bold')
                                        <span class="font-bold text-[#1e293b]">{{ $log['target'] }}</span>
                                        @else
                                        <span class="font-medium text-[#1e293b]">{{ $log['target'] }}</span>
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>

                        <a href="javascript:void(0)" class="text-[11px] font-semibold text-[#554fed] hover:underline flex items-center gap-1 shrink-0">
                            <span>Detail Payload</span>
                            <i class="bi bi-chevron-right text-[9px]"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- Load More Button -->
        <div class="mt-6 text-center">
            <button class="bg-[#f8fafc] hover:bg-gray-100 border border-gray-200 text-xs font-semibold text-[#1e293b] px-6 py-2.5 rounded-full inline-flex items-center gap-2 transition-all">
                <i class="bi bi-chevron-down text-xs"></i>
                <span>Muat Lebih Banyak Aktivitas</span>
            </button>
        </div>
    </div>

    <!-- RIGHT: Stats & Security Audit (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- Statistik Log Bulan Ini -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-[#1e293b]">Statistik Log Bulan Ini</h3>
                <span class="text-[10px] text-gray-400 font-medium">Oktober 2026</span>
            </div>

            <!-- Big number card -->
            <div class="bg-[#f8fafc] rounded-2xl p-4 mb-4 flex items-center justify-between border border-gray-100">
                <div>
                    <p class="text-[11px] text-[#64748b] font-medium">Total Aktivitas Tercatat</p>
                    <h4 class="text-2xl font-extrabold text-[#1e293b] tracking-tight mt-0.5">{{ $stats['total'] }}</h4>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#554fed] text-white flex items-center justify-center text-lg shadow-sm">
                    <i class="bi bi-activity"></i>
                </div>
            </div>

            <!-- Breakdown list -->
            <div class="space-y-2.5 text-xs">
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-[#64748b]">
                        <span class="w-2 h-2 rounded-full bg-[#10b981]"></span> Aksi Tambah
                    </span>
                    <span class="font-bold text-[#1e293b]">{{ $stats['tambah']['val'] }} <span class="text-gray-400 font-normal">({{ $stats['tambah']['pct'] }})</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-[#64748b]">
                        <span class="w-2 h-2 rounded-full bg-[#f59e0b]"></span> Aksi Ubah
                    </span>
                    <span class="font-bold text-[#1e293b]">{{ $stats['ubah']['val'] }} <span class="text-gray-400 font-normal">({{ $stats['ubah']['pct'] }})</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-[#64748b]">
                        <span class="w-2 h-2 rounded-full bg-[#ef4444]"></span> Aksi Hapus
                    </span>
                    <span class="font-bold text-[#1e293b]">{{ $stats['hapus']['val'] }} <span class="text-gray-400 font-normal">({{ $stats['hapus']['pct'] }})</span></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="flex items-center gap-2 text-[#64748b]">
                        <span class="w-2 h-2 rounded-full bg-[#554fed]"></span> Login & Keamanan
                    </span>
                    <span class="font-bold text-[#1e293b]">{{ $stats['login']['val'] }} <span class="text-gray-400 font-normal">({{ $stats['login']['pct'] }})</span></span>
                </div>
            </div>
        </div>

        <!-- Pengguna Paling Aktif -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-[#1e293b]">Pengguna Paling Aktif</h3>
                <span class="text-[10px] text-gray-400 font-medium">Top 3 Staf</span>
            </div>

            <div class="space-y-3">
                @foreach($topUsers as $user)
                <div class="flex items-center justify-between p-2.5 rounded-2xl bg-[#f8fafc] border border-gray-100">
                    <div class="flex items-center gap-2.5">
                        <div class="relative">
                            <img src="{{ asset($user['avatar']) }}" alt="{{ $user['nama'] }}" class="w-8 h-8 rounded-full object-cover">
                            <span class="absolute -top-1 -left-1 w-4 h-4 rounded-full bg-[#554fed] text-white text-[9px] font-bold flex items-center justify-center">
                                {{ $user['rank'] }}
                            </span>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-[#1e293b] leading-tight">{{ $user['nama'] }}</h4>
                            <p class="text-[10px] text-[#64748b]">{{ $user['role'] }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-extrabold text-[#554fed]">{{ $user['aksi'] }} <span class="text-[10px] font-normal text-gray-500">aksi</span></span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Integritas Audit Log -->
        <div class="bg-[#f0fdf4] rounded-3xl p-5 border border-[#bbf7d0]">
            <div class="flex items-start gap-3">
                <div class="w-7 h-7 rounded-xl bg-[#10b981] text-white flex items-center justify-center shrink-0 text-sm shadow-sm">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-[#1e293b]">Integritas Audit Log Terenkripsi & Terverifikasi</h4>
                    <p class="text-[11px] text-[#64748b] leading-relaxed mt-1">
                        Setiap entri diamankan dengan SHA-256 hash chaining untuk mencegah pemalsuan rekaman audit historis.
                    </p>
                    <span class="inline-flex items-center gap-1.5 mt-2.5 text-[10px] font-semibold text-[#10b981] bg-white px-2.5 py-1 rounded-full border border-[#bbf7d0]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Audit Chain Valid (Blok #8942)
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- BOTTOM LEGAL FOOTER -->
<div class="flex flex-wrap items-center justify-between gap-4 text-xs text-[#64748b] pt-2 border-t border-gray-200/60">
    <p>© 2026 Perpustakaan Digital - Sistem Informasi Manajemen Perpustakaan Terpadu.</p>
    <div class="flex items-center gap-4 text-[11px]">
        <a href="javascript:void(0)" class="hover:text-[#554fed]">Dokumentasi API</a>
        <span>•</span>
        <a href="javascript:void(0)" class="hover:text-[#554fed]">Kebijakan Retensi Log</a>
        <span>•</span>
        <a href="javascript:void(0)" class="hover:text-[#554fed]">Bantuan Teknis</a>
    </div>
</div>
@endsection
