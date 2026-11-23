@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex flex-wrap items-center justify-between gap-4 glass-card mb-6">
    <div>
        <h2 class="text-xl lg:text-2xl font-bold text-[#1e293b] tracking-tight">Dashboard</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Ringkasan data & aktivitas perpustakaan hari ini</p>
    </div>

    <!-- Center Search Input -->
    <div class="relative flex-1 max-w-md hidden md:block">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="dashboardSearchInput"
               onkeyup="filterDashboardTable()"
               placeholder="Cari buku, anggota, atau transaksi..." 
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
                <p class="text-[10px] text-[#64748b] font-medium">Superadmin</p>
            </div>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

<!-- STATS METRIC CARDS (5 in a row) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
    <!-- Card 1: Total Buku -->
    <div class="bg-white rounded-3xl p-5 glass-card flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-lg">
                <i class="bi bi-book"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] px-2.5 py-1 rounded-full border border-[#d1fae5]">
                <i class="bi bi-arrow-up-right"></i> {{ $stats['total_buku']['change'] }}
            </span>
        </div>
        <div>
            <p class="text-xs text-[#64748b] font-medium">Total Buku</p>
            <h3 class="text-2xl font-extrabold text-[#1e293b] mt-0.5 tracking-tight">{{ $stats['total_buku']['val'] }}</h3>
            <p class="text-[11px] text-[#94a3b8] mt-1">{{ $stats['total_buku']['desc'] }}</p>
        </div>
    </div>

    <!-- Card 2: Total Anggota -->
    <div class="bg-white rounded-3xl p-5 glass-card flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-2xl bg-[#ecfdf5] text-[#10b981] flex items-center justify-center text-lg">
                <i class="bi bi-people"></i>
            </div>
            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] px-2.5 py-1 rounded-full border border-[#d1fae5]">
                <i class="bi bi-arrow-up-right"></i> {{ $stats['total_anggota']['change'] }}
            </span>
        </div>
        <div>
            <p class="text-xs text-[#64748b] font-medium">Total Anggota</p>
            <h3 class="text-2xl font-extrabold text-[#1e293b] mt-0.5 tracking-tight">{{ $stats['total_anggota']['val'] }}</h3>
            <p class="text-[11px] text-[#94a3b8] mt-1">{{ $stats['total_anggota']['desc'] }}</p>
        </div>
    </div>

    <!-- Card 3: Total Petugas -->
    <div class="bg-white rounded-3xl p-5 glass-card flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-2xl bg-[#f5f2fe] text-[#8b5cf6] flex items-center justify-center text-lg">
                <i class="bi bi-person-badge"></i>
            </div>
            <span class="inline-flex items-center text-[11px] font-semibold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
                {{ $stats['total_petugas']['status'] }}
            </span>
        </div>
        <div>
            <p class="text-xs text-[#64748b] font-medium">Total Petugas</p>
            <h3 class="text-2xl font-extrabold text-[#1e293b] mt-0.5 tracking-tight">{{ $stats['total_petugas']['val'] }}</h3>
            <p class="text-[11px] text-[#10b981] font-medium mt-1">{{ $stats['total_petugas']['desc'] }}</p>
        </div>
    </div>

    <!-- Card 4: Buku Sedang Dipinjam -->
    <div class="bg-white rounded-3xl p-5 glass-card flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-2xl bg-[#fffbeb] text-[#f59e0b] flex items-center justify-center text-lg">
                <i class="bi bi-clock"></i>
            </div>
            <span class="inline-flex items-center text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] px-2.5 py-1 rounded-full border border-[#fef3c7]">
                {{ $stats['buku_dipinjam']['status'] }}
            </span>
        </div>
        <div>
            <p class="text-xs text-[#64748b] font-medium">Buku Sedang Dipinjam</p>
            <h3 class="text-2xl font-extrabold text-[#1e293b] mt-0.5 tracking-tight">{{ $stats['buku_dipinjam']['val'] }}</h3>
            <p class="text-[11px] text-[#94a3b8] mt-1">{{ $stats['buku_dipinjam']['desc'] }}</p>
        </div>
    </div>

    <!-- Card 5: Buku Terlambat (Warning Red) -->
    <div class="bg-[#fff6f6] border border-[#fed7d7] rounded-3xl p-5 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-2xl bg-[#fee2e2] text-[#f43f5e] flex items-center justify-center text-lg">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <span class="inline-flex items-center text-[11px] font-semibold text-white bg-[#f43f5e] px-2.5 py-1 rounded-full shadow-sm shadow-rose-500/20">
                {{ $stats['buku_terlambat']['badge'] }}
            </span>
        </div>
        <div>
            <p class="text-xs text-[#f43f5e] font-semibold">Buku Terlambat</p>
            <h3 class="text-2xl font-extrabold text-[#f43f5e] mt-0.5 tracking-tight">{{ $stats['buku_terlambat']['val'] }}</h3>
            <p class="text-[11px] text-[#f43f5e]/80 font-medium mt-1">{{ $stats['buku_terlambat']['desc'] }}</p>
        </div>
    </div>
</div>

<!-- MIDDLE SECTION: 2 COLUMNS (Chart + 5 Buku Terpopuler) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Chart Column (Takes 2 Cols) -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 glass-card flex flex-col justify-between">
        <!-- Header & Action -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h3 class="text-lg font-bold text-[#1e293b]">Peminjaman per Bulan</h3>
                <p class="text-xs text-[#64748b] font-medium mt-0.5">Tren sirkulasi bahan pustaka tahun berjalan</p>
            </div>
            <div class="flex items-center gap-2.5">
                <div class="relative">
                    <select id="chartPeriodSelect" onchange="updateBorrowChart(this.value)" class="appearance-none bg-[#f8fafc] border border-gray-200 text-xs font-semibold text-[#1e293b] rounded-full pl-3.5 pr-8 py-2 focus:outline-none cursor-pointer">
                        <option value="2024">Januari – Desember 2024</option>
                        <option value="2023">Januari – Desember 2023</option>
                        <option value="sem1">Semester 1 (Jan - Jun)</option>
                        <option value="sem2">Semester 2 (Jul - Des)</option>
                    </select>
                    <i class="bi bi-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
                </div>
                <button onclick="exportChartData()" class="flex items-center gap-1.5 bg-[#f8fafc] hover:bg-gray-100 border border-gray-200 text-xs font-semibold text-[#1e293b] rounded-full px-3.5 py-2 transition-all">
                    <i class="bi bi-download text-xs text-gray-500"></i>
                    <span>Ekspor</span>
                </button>
            </div>
        </div>

        <!-- Metric Badges Row -->
        <div class="flex flex-wrap items-center gap-6 mb-4 text-xs font-medium">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#554fed]"></span>
                <span class="text-[#64748b]">Rata-rata / Bulan</span>
                <span id="chartStatRata" class="font-bold text-[#1e293b]">{{ $chart_summary['rata_rata'] }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#10b981]"></span>
                <span class="text-[#64748b]">Puncak Tertinggi</span>
                <span id="chartStatPuncak" class="font-bold text-[#1e293b]">{{ $chart_summary['puncak'] }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-[#f59e0b]"></span>
                <span class="text-[#64748b]">Tingkat Pengembalian</span>
                <span id="chartStatTingkat" class="font-bold text-[#1e293b]">{{ $chart_summary['tingkat_kembali'] }}</span>
            </div>
        </div>

        <!-- Interactive Chart with Peak Badge -->
        <div class="relative w-full h-[260px] pt-4">
            <canvas id="borrowChart"></canvas>
            <!-- Badge 210 Buku at Oktober -->
            <div id="chartPeakBadge" class="absolute top-3 right-[18%] -translate-x-1/2 bg-[#554fed] text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md shadow-indigo-500/30 flex items-center gap-1">
                210 Buku
            </div>
        </div>
    </div>

    <!-- 5 Buku Terpopuler Column (Takes 1 Col) -->
    <div class="bg-white rounded-3xl p-6 glass-card flex flex-col justify-between">
        <div>
            <!-- Header -->
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h3 class="text-lg font-bold text-[#1e293b]">5 Buku Terpopuler</h3>
                    <p class="text-xs text-[#64748b] font-medium mt-0.5">Paling sering dipinjam</p>
                </div>
                <button onclick="togglePopularSort()" title="Urutkan / Filter Populer" class="w-8 h-8 rounded-full bg-[#f8fafc] hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-[#554fed] text-sm transition-colors">
                    <i class="bi bi-sliders"></i>
                </button>
            </div>

            <!-- List of 5 Books -->
            <div id="popularBooksList" class="space-y-4">
                @foreach ($buku_populer as $item)
                <div class="popular-book-item flex items-center gap-3" data-count="{{ $item['count'] }}" data-percent="{{ $item['percent'] }}">
                    <!-- Rank Badge -->
                    <span class="rank-badge w-6 h-6 rounded-full {{ $item['rank'] == 1 ? 'bg-[#554fed] text-white' : 'bg-gray-100 text-gray-500' }} text-xs font-bold flex items-center justify-center shrink-0">
                        {{ $item['rank'] }}
                    </span>

                    <!-- Book Cover -->
                    <img src="{{ asset($item['cover']) }}" 
                         alt="{{ $item['judul'] }}" 
                         class="w-8 h-11 object-cover rounded shadow-sm border border-gray-100 shrink-0">

                    <!-- Info & Progress -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="text-xs font-bold text-[#1e293b] truncate">{{ $item['judul'] }}</h4>
                            <span class="text-xs font-bold text-[#554fed] ml-2 shrink-0">{{ $item['count'] }}</span>
                        </div>
                        <p class="text-[10px] text-[#64748b] truncate mb-1.5">{{ $item['pengarang'] }}</p>
                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 h-1.5 rounded-full overflow-hidden">
                            <div class="bg-[#554fed] h-full rounded-full transition-all duration-500" style="width: {{ $item['percent'] }}%"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Footer Link -->
        <div class="pt-5 mt-4 border-t border-gray-100 text-center">
            <a href="{{ route('buku.index') }}" class="text-xs font-bold text-[#554fed] hover:text-[#4338ca] inline-flex items-center gap-1.5 transition-colors">
                <span>Lihat Semua Katalog Buku</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- BOTTOM SECTION: PEMINJAMAN TERBARU -->
<div class="bg-white rounded-3xl p-6 glass-card">
    <!-- Header & Action -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div>
            <h3 class="text-lg font-bold text-[#1e293b]">Peminjaman Terbaru</h3>
            <p class="text-xs text-[#64748b] font-medium mt-0.5">Aktivitas peminjaman dan sirkulasi hari ini</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openAddTransactionModal()" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-4 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                <i class="bi bi-plus-lg"></i>
                <span>Tambah Transaksi</span>
            </button>
            <a href="{{ route('peminjaman.index') }}" class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full transition-all flex items-center gap-1">
                <span>Lihat Seluruh Data</span>
                <i class="bi bi-chevron-right text-[10px] text-gray-400"></i>
            </a>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="dashboardLoansTable" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider">
                    <th class="pb-3 px-3">Anggota</th>
                    <th class="pb-3 px-3">Judul Buku</th>
                    <th class="pb-3 px-3">Tgl Pinjam</th>
                    <th class="pb-3 px-3">Jatuh Tempo</th>
                    <th class="pb-3 px-3 text-center">Status</th>
                    <th class="pb-3 px-3 text-center">Aksi Cepat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs">
                @foreach ($peminjaman_terbaru as $row)
                <tr class="dashboard-loan-row hover:bg-slate-50/60 transition-colors">
                    <!-- Anggota -->
                    <td class="py-3.5 px-3">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset($row['avatar']) }}" 
                                 alt="{{ $row['anggota'] }}" 
                                 class="w-9 h-9 rounded-full object-cover ring-2 ring-gray-100">
                            <div>
                                <p class="font-bold text-[#1e293b] leading-tight loan-member-name">{{ $row['anggota'] }}</p>
                                <p class="text-[11px] text-[#94a3b8] mt-0.5">{{ $row['nim'] }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Judul Buku -->
                    <td class="py-3.5 px-3">
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-lg {{ $row['is_overdue'] ? 'bg-red-50 text-red-500' : 'bg-indigo-50 text-[#554fed]' }} flex items-center justify-center shrink-0">
                                <i class="bi bi-book"></i>
                            </div>
                            <div>
                                <p class="font-bold text-[#1e293b] leading-tight loan-book-title">{{ $row['judul_buku'] }}</p>
                                <p class="text-[11px] {{ $row['is_overdue'] ? 'text-red-500 font-semibold' : 'text-[#94a3b8]' }} mt-0.5">
                                    {{ $row['kode_rak'] }}
                                </p>
                            </div>
                        </div>
                    </td>

                    <!-- Tgl Pinjam -->
                    <td class="py-3.5 px-3 text-[#64748b] font-medium">
                        {{ $row['tgl_pinjam'] }}
                    </td>

                    <!-- Jatuh Tempo -->
                    <td class="py-3.5 px-3 font-semibold {{ $row['is_overdue'] ? 'text-red-500 font-bold' : 'text-[#1e293b]' }}">
                        {{ $row['jatuh_tempo'] }}
                    </td>

                    <!-- Status -->
                    <td class="py-3.5 px-3 text-center loan-status-cell">
                        @if ($row['status_type'] == 'success')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                {{ $row['status'] }}
                            </span>
                        @elseif ($row['status_type'] == 'warning')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                                {{ $row['status'] }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                                {{ $row['status'] }}
                            </span>
                        @endif
                    </td>

                    <!-- Aksi Cepat -->
                    <td class="py-3.5 px-3 text-center">
                        <div class="inline-flex items-center gap-2">
                            @if ($row['status'] == 'Dipinjam')
                                <button onclick="quickReturnLoan(this, '{{ $row['anggota'] }}', '{{ $row['judul_buku'] }}')" title="Kembalikan" class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-arrow-left-right text-xs"></i>
                                </button>
                                <button onclick="showLoanDetail('{{ $row['anggota'] }}', '{{ $row['nim'] }}', '{{ $row['judul_buku'] }}', '{{ $row['kode_rak'] }}', '{{ $row['tgl_pinjam'] }}', '{{ $row['jatuh_tempo'] }}', '{{ $row['status'] }}')" title="Detail" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:bg-gray-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-eye text-xs"></i>
                                </button>
                            @elseif ($row['status'] == 'Kembali')
                                <button onclick="printLoanReceipt('{{ $row['anggota'] }}', '{{ $row['nim'] }}', '{{ $row['judul_buku'] }}', '{{ $row['tgl_pinjam'] }}', '{{ $row['jatuh_tempo'] }}')" title="Cetak Bukti" class="w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:bg-gray-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-printer text-xs"></i>
                                </button>
                                <button onclick="showLoanDetail('{{ $row['anggota'] }}', '{{ $row['nim'] }}', '{{ $row['judul_buku'] }}', '{{ $row['kode_rak'] }}', '{{ $row['tgl_pinjam'] }}', '{{ $row['jatuh_tempo'] }}', '{{ $row['status'] }}')" title="Detail" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:bg-gray-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-eye text-xs"></i>
                                </button>
                            @else
                                <button onclick="sendReminderNotification('{{ $row['anggota'] }}', '{{ $row['judul_buku'] }}')" title="Kirim Pengingat" class="w-8 h-8 rounded-full bg-amber-50 text-amber-500 hover:bg-amber-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-send text-xs"></i>
                                </button>
                                <button onclick="recordLoanFine('{{ $row['anggota'] }}', '{{ $row['judul_buku'] }}', '6000')" title="Catat Denda" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-receipt text-xs"></i>
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Table Pagination Footer -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-5 mt-4 border-t border-gray-100 text-xs">
        <p class="text-[#64748b]">Menampilkan <span class="font-bold text-[#1e293b]" id="displayedRowCount">4</span> dari <span class="font-bold text-[#1e293b]">87</span> transaksi aktif hari ini</p>
        <div class="flex items-center gap-1.5">
            <button onclick="showToast('Halaman sebelumnya');" class="px-3 py-1.5 rounded-lg text-gray-400 hover:bg-gray-100 transition-colors font-medium">← Sebelumnya</button>
            <button class="w-7 h-7 rounded-lg bg-[#554fed] text-white font-bold flex items-center justify-center shadow-sm">1</button>
            <button onclick="showToast('Membuka halaman 2...');" class="px-3 py-1.5 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors font-medium">Selanjutnya →</button>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH TRANSAKSI -->
<div id="addTransactionModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-journal-plus"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Tambah Transaksi Peminjaman</h3>
                    <p class="text-xs text-[#64748b]">Catat sirkulasi peminjaman buku baru hari ini</p>
                </div>
            </div>
            <button onclick="closeAddTransactionModal()" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>

        <form id="newTransactionForm" onsubmit="submitNewTransaction(event)" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Nama Anggota / Mahasiswa</label>
                <input type="text" id="inputNamaAnggota" placeholder="Contoh: Sarah Azhari" required 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">NIM / No. Anggota</label>
                <input type="text" id="inputNimAnggota" placeholder="Contoh: MHS-2023-0881" required 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Judul Buku</label>
                <select id="inputJudulBuku" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                    <option value="Laskar Pelangi (Rak A1)">Laskar Pelangi (Rak A1)</option>
                    <option value="Bumi Manusia (Rak A2)">Bumi Manusia (Rak A2)</option>
                    <option value="Filosofi Teras (Rak B1)">Filosofi Teras (Rak B1)</option>
                    <option value="Laut Bercerita (Rak A3)">Laut Bercerita (Rak A3)</option>
                    <option value="Sapiens (Rak C2)">Sapiens (Rak C2)</option>
                    <option value="Atomic Habits (Rak B2)">Atomic Habits (Rak B2)</option>
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Tanggal Pinjam</label>
                    <input type="text" id="inputTglPinjam" value="21 Nov 2026" required 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Jatuh Tempo (7 Hari)</label>
                    <input type="text" id="inputJatuhTempo" value="28 Nov 2026" required 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="closeAddTransactionModal()" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
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

<!-- MODAL DETAIL PEMINJAMAN -->
<div id="loanDetailModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h4 class="font-bold text-[#1e293b] text-sm flex items-center gap-2">
                <i class="bi bi-info-circle text-[#554fed]"></i> Detail Transaksi Peminjaman
            </h4>
            <button onclick="document.getElementById('loanDetailModal').classList.add('hidden')" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <div class="space-y-3 text-xs">
            <div class="p-3 bg-[#f8fafc] rounded-2xl border border-gray-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#554fed] text-white flex items-center justify-center font-bold text-sm">
                    <i class="bi bi-person"></i>
                </div>
                <div>
                    <h5 id="detailMemberName" class="font-bold text-[#1e293b] text-sm">-</h5>
                    <p id="detailMemberNim" class="text-[11px] text-gray-400 font-mono">-</p>
                </div>
            </div>
            <div class="space-y-2 border-b border-gray-100 pb-3">
                <div class="flex justify-between"><span class="text-gray-500">Judul Buku:</span><span id="detailBookTitle" class="font-bold text-[#1e293b] text-right">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Lokasi / Rak:</span><span id="detailBookRack" class="font-medium text-gray-700">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Tgl Pinjam:</span><span id="detailLoanDate" class="font-medium text-gray-700">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Jatuh Tempo:</span><span id="detailDueDate" class="font-bold text-gray-700">-</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status Sirkulasi:</span><span id="detailStatus" class="font-bold text-[#554fed]">-</span></div>
            </div>
        </div>
        <div class="pt-4 flex justify-end">
            <button onclick="document.getElementById('loanDetailModal').classList.add('hidden')" class="bg-[#554fed] text-white text-xs font-bold px-5 py-2 rounded-full">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL CETAK BUKTI -->
<div id="receiptModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm p-6 shadow-2xl printable-content">
        <div class="text-center border-b border-dashed border-gray-200 pb-4 mb-4">
            <div class="w-10 h-10 rounded-2xl bg-[#554fed] text-white flex items-center justify-center mx-auto mb-2 text-lg">
                <i class="bi bi-book"></i>
            </div>
            <h4 class="font-bold text-[#1e293b] text-sm">PERPUSTAKAAN PUSAT</h4>
            <p class="text-[10px] text-gray-400">Bukti Pengembalian / Sirkulasi Buku</p>
        </div>
        <div class="space-y-2 text-xs mb-4">
            <div class="flex justify-between"><span class="text-gray-400">Peminjam:</span><span id="receiptMember" class="font-bold text-[#1e293b]">-</span></div>
            <div class="flex justify-between"><span class="text-gray-400">NIM:</span><span id="receiptNim" class="font-mono text-gray-600">-</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Buku:</span><span id="receiptBook" class="font-bold text-[#1e293b] text-right">-</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Tgl Kembali:</span><span class="font-medium text-gray-700">Hari ini, 09:30 WIB</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Status Denda:</span><span class="font-bold text-[#10b981]">Lunas (Rp 0)</span></div>
        </div>
        <div class="pt-3 border-t border-dashed border-gray-200 flex items-center justify-between no-print">
            <button onclick="document.getElementById('receiptModal').classList.add('hidden')" class="px-4 py-2 rounded-full border border-gray-200 text-xs font-semibold text-gray-600">Tutup</button>
            <button onclick="window.print()" class="bg-[#554fed] text-white text-xs font-bold px-5 py-2 rounded-full flex items-center gap-1.5 shadow-sm">
                <i class="bi bi-printer"></i>
                <span>Cetak Struk</span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    let myBorrowChart = null;

    const chartDatasets = {
        '2024': {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            data: [80, 102, 115, 120, 155, 138, 145, 170, 160, 210, 165, 185],
            peak: '210 Buku',
            rata: '148 buku',
            puncak: '210 buku (Okt)',
            tingkat: '94.8% tepat waktu'
        },
        '2023': {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            data: [65, 88, 95, 110, 120, 130, 125, 140, 150, 175, 160, 170],
            peak: '175 Buku',
            rata: '127 buku',
            puncak: '175 buku (Okt)',
            tingkat: '92.1% tepat waktu'
        },
        'sem1': {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            data: [80, 102, 115, 120, 155, 138],
            peak: '155 Buku',
            rata: '118 buku',
            puncak: '155 buku (Mei)',
            tingkat: '95.2% tepat waktu'
        },
        'sem2': {
            labels: ['Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            data: [145, 170, 160, 210, 165, 185],
            peak: '210 Buku',
            rata: '172 buku',
            puncak: '210 buku (Okt)',
            tingkat: '94.4% tepat waktu'
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        initBorrowChart('2024');
    });

    function initBorrowChart(period) {
        const ctx = document.getElementById('borrowChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 260);
        gradient.addColorStop(0, 'rgba(85, 79, 237, 0.28)');
        gradient.addColorStop(1, 'rgba(85, 79, 237, 0.00)');

        const cfg = chartDatasets[period];

        myBorrowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: cfg.labels,
                datasets: [{
                    label: 'Peminjaman',
                    data: cfg.data,
                    borderColor: '#554fed',
                    borderWidth: 3.5,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#554fed',
                    pointBorderWidth: 3,
                    pointRadius: 4,
                    tension: 0.45,
                    fill: true,
                    backgroundColor: gradient
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        enabled: true,
                        backgroundColor: '#1e293b',
                        titleFont: { family: 'Plus Jakarta Sans', size: 12 },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' Buku';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { family: 'Plus Jakarta Sans', size: 11 },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        display: false,
                        min: 40,
                        max: 240
                    }
                }
            }
        });
    }

    function updateBorrowChart(period) {
        const cfg = chartDatasets[period];
        if (!cfg || !myBorrowChart) return;

        myBorrowChart.data.labels = cfg.labels;
        myBorrowChart.data.datasets[0].data = cfg.data;
        myBorrowChart.update();

        document.getElementById('chartStatRata').textContent = cfg.rata;
        document.getElementById('chartStatPuncak').textContent = cfg.puncak;
        document.getElementById('chartStatTingkat').textContent = cfg.tingkat;
        document.getElementById('chartPeakBadge').textContent = cfg.peak;

        showToast(`Grafik diperbarui untuk periode ${period}!`, 'info');
    }

    function exportChartData() {
        const csvContent = "data:text/csv;charset=utf-8,Bulan,Jumlah Peminjaman\n" + 
            chartDatasets['2024'].labels.map((m, i) => `${m},${chartDatasets['2024'].data[i]}`).join("\n");
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "tren_peminjaman_2024.csv");
        document.body.appendChild(link);
        link.click();
        link.remove();
        showToast('Data peminjaman per bulan berhasil diekspor ke CSV!');
    }

    function togglePopularSort() {
        const list = document.getElementById('popularBooksList');
        const items = Array.from(list.children);
        items.reverse();
        items.forEach((item, index) => {
            list.appendChild(item);
            const badge = item.querySelector('.rank-badge');
            if (badge) {
                badge.textContent = index + 1;
                badge.className = index === 0 
                    ? 'rank-badge w-6 h-6 rounded-full bg-[#554fed] text-white text-xs font-bold flex items-center justify-center shrink-0'
                    : 'rank-badge w-6 h-6 rounded-full bg-gray-100 text-gray-500 text-xs font-bold flex items-center justify-center shrink-0';
            }
        });
        showToast('Urutan buku terpopuler dibalik / diperbarui.', 'info');
    }

    function filterDashboardTable() {
        const query = document.getElementById('dashboardSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.dashboard-loan-row');
        let count = 0;
        rows.forEach(row => {
            const member = row.querySelector('.loan-member-name')?.textContent.toLowerCase() || '';
            const book = row.querySelector('.loan-book-title')?.textContent.toLowerCase() || '';
            if (member.includes(query) || book.includes(query)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        document.getElementById('displayedRowCount').textContent = count;
    }

    // Modal Add Transaction
    function openAddTransactionModal() {
        document.getElementById('addTransactionModal').classList.remove('hidden');
    }
    function closeAddTransactionModal() {
        document.getElementById('addTransactionModal').classList.add('hidden');
    }
    function submitNewTransaction(e) {
        e.preventDefault();
        const nama = document.getElementById('inputNamaAnggota').value;
        const nim = document.getElementById('inputNimAnggota').value;
        const buku = document.getElementById('inputJudulBuku').value;
        const pinjam = document.getElementById('inputTglPinjam').value;
        const tempo = document.getElementById('inputJatuhTempo').value;

        const tableBody = document.querySelector('#dashboardLoansTable tbody');
        const newRow = document.createElement('tr');
        newRow.className = 'dashboard-loan-row hover:bg-slate-50/60 transition-colors animate-in fade-in';
        newRow.innerHTML = `
            <td class="py-3.5 px-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-[#554fed] text-white flex items-center justify-center font-bold text-xs ring-2 ring-gray-100">
                        ${nama.charAt(0)}
                    </div>
                    <div>
                        <p class="font-bold text-[#1e293b] leading-tight loan-member-name">${nama}</p>
                        <p class="text-[11px] text-[#94a3b8] mt-0.5">${nim}</p>
                    </div>
                </div>
            </td>
            <td class="py-3.5 px-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 text-[#554fed] flex items-center justify-center shrink-0">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <p class="font-bold text-[#1e293b] leading-tight loan-book-title">${buku}</p>
                        <p class="text-[11px] text-[#94a3b8] mt-0.5">Sirkulasi Baru</p>
                    </div>
                </div>
            </td>
            <td class="py-3.5 px-3 text-[#64748b] font-medium">${pinjam}</td>
            <td class="py-3.5 px-3 font-semibold text-[#1e293b]">${tempo}</td>
            <td class="py-3.5 px-3 text-center loan-status-cell">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                    Dipinjam
                </span>
            </td>
            <td class="py-3.5 px-3 text-center">
                <div class="inline-flex items-center gap-2">
                    <button onclick="quickReturnLoan(this, '${nama}', '${buku}')" title="Kembalikan" class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center transition-colors">
                        <i class="bi bi-arrow-left-right text-xs"></i>
                    </button>
                    <button onclick="showLoanDetail('${nama}', '${nim}', '${buku}', 'Rak Baru', '${pinjam}', '${tempo}', 'Dipinjam')" title="Detail" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:bg-gray-100 flex items-center justify-center transition-colors">
                        <i class="bi bi-eye text-xs"></i>
                    </button>
                </div>
            </td>
        `;

        tableBody.insertBefore(newRow, tableBody.firstChild);
        closeAddTransactionModal();
        document.getElementById('newTransactionForm').reset();
        showToast('Transaksi peminjaman berhasil ditambahkan!');
    }

    function quickReturnLoan(btn, member, book) {
        const row = btn.closest('tr');
        const statusCell = row.querySelector('.loan-status-cell');
        statusCell.innerHTML = `
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5]">
                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                Kembali
            </span>
        `;
        btn.outerHTML = `
            <button onclick="printLoanReceipt('${member}', 'MHS', '${book}', 'Hari ini', 'Hari ini')" title="Cetak Bukti" class="w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:bg-gray-100 flex items-center justify-center transition-colors">
                <i class="bi bi-printer text-xs"></i>
            </button>
        `;
        showToast(`Buku "${book}" untuk ${member} berhasil diproses kembali!`);
    }

    function showLoanDetail(member, nim, book, rack, loanDate, dueDate, status) {
        document.getElementById('detailMemberName').textContent = member;
        document.getElementById('detailMemberNim').textContent = nim;
        document.getElementById('detailBookTitle').textContent = book;
        document.getElementById('detailBookRack').textContent = rack;
        document.getElementById('detailLoanDate').textContent = loanDate;
        document.getElementById('detailDueDate').textContent = dueDate;
        document.getElementById('detailStatus').textContent = status;
        document.getElementById('loanDetailModal').classList.remove('hidden');
    }

    function printLoanReceipt(member, nim, book, loanDate, dueDate) {
        document.getElementById('receiptMember').textContent = member;
        document.getElementById('receiptNim').textContent = nim;
        document.getElementById('receiptBook').textContent = book;
        document.getElementById('receiptModal').classList.remove('hidden');
    }

    function sendReminderNotification(member, book) {
        showToast(`Pengingat WhatsApp berhasil dikirimkan ke ${member} untuk buku "${book}"!`, 'info');
    }

    function recordLoanFine(member, book, fine) {
        showToast(`Denda Rp ${parseInt(fine).toLocaleString('id-ID')} berhasil dicatat untuk ${member}!`, 'warning');
    }
</script>
@endpush
