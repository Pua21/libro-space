@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="topSearchInput"
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

    <button onclick="exportAuditLogCSV()" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
        <i class="bi bi-download"></i>
        <span>Ekspor Audit Log</span>
    </button>
</div>

<!-- FILTER BAR -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center gap-3 mb-6">
    <div class="relative flex-1 min-w-[240px]">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        <input type="text" 
               id="logSearchInput"
               oninput="filterLogs()"
               placeholder="Cari catatan aktivitas, nama pengguna..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
    </div>

    <select id="userFilterSelect" onchange="filterLogs()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option value="">Semua Pengguna</option>
        <option value="Budi Santoso">Budi Santoso</option>
        <option value="Siti Rahmawati">Siti Rahmawati</option>
        <option value="Ahmad Fauzi">Ahmad Fauzi</option>
        <option value="Maya Indriani">Maya Indriani</option>
        <option value="Admin Perpustakaan">Admin Perpustakaan</option>
        <option value="Dewi Kartika">Dewi Kartika</option>
    </select>

    <select id="modulFilterSelect" onchange="filterLogs()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option value="">Semua Modul</option>
        <option value="Data Buku">Data Buku</option>
        <option value="Peminjaman">Peminjaman</option>
        <option value="Data Master">Data Master</option>
        <option value="Pengaturan">Pengaturan</option>
        <option value="Data Anggota">Data Anggota</option>
        <option value="Autentikasi">Autentikasi</option>
        <option value="Petugas">Petugas</option>
        <option value="Laporan">Laporan</option>
    </select>

    <select id="aksiFilterSelect" onchange="filterLogs()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option value="">Semua Aksi</option>
        <option value="Tambah">Tambah</option>
        <option value="Ubah">Ubah</option>
        <option value="Hapus">Hapus</option>
        <option value="Login / Keamanan">Login / Keamanan</option>
    </select>

    <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2 text-xs text-gray-700">
        <i class="bi bi-calendar text-gray-400"></i>
        <span>01 Okt – 31 Okt 2026</span>
    </div>

    <button onclick="resetLogFilters()" title="Reset Filter" class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 hover:text-[#554fed] transition-colors">
        <i class="bi bi-arrow-clockwise text-sm" id="refreshIcon"></i>
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

        <div class="space-y-6" id="timelineContainer">
            @foreach($timeline as $dateGroup => $items)
            <div class="date-group-block" data-date="{{ $dateGroup }}">
                <!-- Group Header -->
                <div class="flex items-center gap-2 mb-3">
                    <span class="w-2 h-2 rounded-full bg-[#554fed]"></span>
                    <h4 class="text-xs font-bold text-[#1e293b] tracking-wider uppercase">{{ $dateGroup }}</h4>
                </div>

                <!-- Timeline items in this date -->
                <div class="space-y-3 pl-3 border-l-2 border-indigo-100/60 ml-1 timeline-items-wrapper">
                    @foreach($items as $idx => $log)
                    <div class="log-item-card p-3.5 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-indigo-100 transition-all flex flex-wrap items-center justify-between gap-3"
                         data-user="{{ $log['user'] }}"
                         data-modul="{{ $log['modul'] }}"
                         data-aksi="{{ $log['aksi'] }}"
                         data-text="{{ strtolower($log['user'] . ' ' . $log['deskripsi'] . ' ' . $log['target'] . ' ' . $log['modul']) }}">
                        <div class="flex items-start gap-3">
                            @include('partials.avatar', [
                                'name' => $log['user'],
                                'avatar' => $log['avatar'] ?? null,
                                'size' => 'w-9 h-9',
                                'textSize' => 'text-xs',
                                'classExtra' => 'mt-0.5'
                            ])
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

                        <button onclick="openPayloadModal('{{ addslashes($log['user']) }}', '{{ $log['modul'] }}', '{{ $log['aksi'] }}', '{{ $log['waktu'] }}', '{{ addslashes($log['device']) }}', '{{ addslashes($log['deskripsi'] . ' ' . $log['target']) }}')" class="text-[11px] font-semibold text-[#554fed] hover:underline flex items-center gap-1 shrink-0 bg-transparent border-0 cursor-pointer">
                            <span>Detail Payload</span>
                            <i class="bi bi-chevron-right text-[9px]"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- No Results Found Message -->
        <div id="noLogsFound" class="hidden text-center py-10">
            <i class="bi bi-search text-3xl text-gray-300 mb-2 block"></i>
            <p class="text-xs font-semibold text-gray-500">Tidak ada log aktivitas yang cocok dengan kriteria filter.</p>
            <button onclick="resetLogFilters()" class="mt-2 text-xs text-[#554fed] font-bold hover:underline">Reset Filter</button>
        </div>

        <!-- Load More Button -->
        <div class="mt-6 text-center" id="loadMoreSection">
            <button onclick="loadMoreLogs()" id="btnLoadMore" class="bg-[#f8fafc] hover:bg-gray-100 border border-gray-200 text-xs font-semibold text-[#1e293b] px-6 py-2.5 rounded-full inline-flex items-center gap-2 transition-all cursor-pointer">
                <i class="bi bi-chevron-down text-xs" id="loadMoreIcon"></i>
                <span id="loadMoreText">Muat Lebih Banyak Aktivitas</span>
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
                    <h4 class="text-2xl font-extrabold text-[#1e293b] tracking-tight mt-0.5" id="totalLogsCounter">{{ $stats['total'] }}</h4>
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
                <div class="flex items-center justify-between p-2.5 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-indigo-100 transition-colors">
                    <div class="flex items-center gap-2.5">
                        <div class="relative">
                            @include('partials.avatar', [
                                'name' => $user['nama'],
                                'avatar' => $user['avatar'] ?? null,
                                'size' => 'w-8 h-8',
                                'textSize' => 'text-[11px]'
                            ])
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

<!-- MODAL DETAIL PAYLOAD -->
<div id="modalPayload" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-code-square"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#1e293b]">Detail Payload Transaksi Audit</h3>
                    <p class="text-[11px] text-[#64748b]">Rekaman metadata request & perubahan database</p>
                </div>
            </div>
            <button onclick="closePayloadModal()" class="w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 flex items-center justify-center">
                <i class="bi bi-x text-lg"></i>
            </button>
        </div>

        <div class="space-y-3 mb-4 text-xs">
            <div class="flex items-center justify-between p-3 rounded-2xl bg-[#f8fafc] border border-gray-100">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-semibold">User Pelaksana</p>
                    <p class="font-bold text-[#1e293b]" id="payloadModalUser">-</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-gray-400 uppercase font-semibold">Modul & Aksi</p>
                    <span id="payloadModalBadge" class="inline-block font-semibold px-2 py-0.5 rounded-full text-[10px] bg-indigo-50 text-[#554fed]">-</span>
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <span class="text-[11px] font-bold text-[#1e293b]">Struktur JSON Payload (RAW):</span>
                    <button onclick="copyPayloadJSON()" class="text-[10px] font-bold text-[#554fed] hover:underline flex items-center gap-1">
                        <i class="bi bi-clipboard"></i>
                        <span>Salin JSON</span>
                    </button>
                </div>
                <div class="bg-[#1e293b] text-emerald-400 p-4 rounded-2xl font-mono text-[11px] max-h-56 overflow-y-auto leading-relaxed border border-slate-700">
                    <pre id="payloadModalJson" class="whitespace-pre-wrap"></pre>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
            <span class="text-[10px] text-emerald-600 flex items-center gap-1">
                <i class="bi bi-shield-check"></i> Hash Terverifikasi
            </span>
            <button onclick="closePayloadModal()" class="px-5 py-2 rounded-full bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold transition-all">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
// Filter Logs Real-Time
function filterLogs() {
    const query = document.getElementById('logSearchInput').value.toLowerCase().trim();
    const user = document.getElementById('userFilterSelect').value;
    const modul = document.getElementById('modulFilterSelect').value;
    const aksi = document.getElementById('aksiFilterSelect').value;

    const cards = document.querySelectorAll('.log-item-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const cText = card.dataset.text || '';
        const cUser = card.dataset.user || '';
        const cModul = card.dataset.modul || '';
        const cAksi = card.dataset.aksi || '';

        const matchQuery = !query || cText.includes(query);
        const matchUser = !user || cUser === user;
        const matchModul = !modul || cModul === modul;
        const matchAksi = !aksi || cAksi === aksi;

        if (matchQuery && matchUser && matchModul && matchAksi) {
            card.classList.remove('hidden');
            visibleCount++;
        } else {
            card.classList.add('hidden');
        }
    });

    // Check visibility for date group blocks
    document.querySelectorAll('.date-group-block').forEach(group => {
        const visibleCardsInGroup = group.querySelectorAll('.log-item-card:not(.hidden)');
        if (visibleCardsInGroup.length === 0) {
            group.classList.add('hidden');
        } else {
            group.classList.remove('hidden');
        }
    });

    // Toggle No Results message
    const noResults = document.getElementById('noLogsFound');
    if (visibleCount === 0) {
        noResults.classList.remove('hidden');
    } else {
        noResults.classList.add('hidden');
    }
}

// Reset all filters
function resetLogFilters() {
    document.getElementById('logSearchInput').value = '';
    document.getElementById('userFilterSelect').value = '';
    document.getElementById('modulFilterSelect').value = '';
    document.getElementById('aksiFilterSelect').value = '';

    const icon = document.getElementById('refreshIcon');
    if (icon) icon.classList.add('animate-spin');

    setTimeout(() => {
        if (icon) icon.classList.remove('animate-spin');
        filterLogs();
        if (window.showToast) {
            window.showToast('Filter log aktivitas telah direset.', 'info');
        }
    }, 300);
}

// Load more logs simulation
let moreLoaded = false;
function loadMoreLogs() {
    if (moreLoaded) {
        if (window.showToast) {
            window.showToast('Semua riwayat aktivitas bulan ini sudah ditampilkan.', 'info');
        }
        return;
    }

    const btn = document.getElementById('btnLoadMore');
    const txt = document.getElementById('loadMoreText');
    const icon = document.getElementById('loadMoreIcon');

    btn.disabled = true;
    txt.innerText = 'Memuat aktivitas terdahulu...';
    icon.className = 'bi bi-arrow-repeat animate-spin text-xs';

    setTimeout(() => {
        const container = document.getElementById('timelineContainer');
        const newGroup = document.createElement('div');
        newGroup.className = 'date-group-block animate-in fade-in duration-300';
        newGroup.dataset.date = '29 OKT 2026';
        newGroup.innerHTML = `
            <div class="flex items-center gap-2 mb-3 mt-6">
                <span class="w-2 h-2 rounded-full bg-[#554fed]"></span>
                <h4 class="text-xs font-bold text-[#1e293b] tracking-wider uppercase">29 OKT 2026</h4>
            </div>
            <div class="space-y-3 pl-3 border-l-2 border-indigo-100/60 ml-1 timeline-items-wrapper">
                <div class="log-item-card p-3.5 rounded-2xl bg-[#f8fafc] border border-gray-100 hover:border-indigo-100 transition-all flex flex-wrap items-center justify-between gap-3"
                     data-user="Ahmad Fauzi" data-modul="Data Master" data-aksi="Tambah" data-text="ahmad fauzi menambahkan kategori baru sastra kontemporer">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 font-bold text-xs flex items-center justify-center shrink-0 border border-emerald-200 mt-0.5">
                            AF
                        </div>
                        <div>
                            <div class="flex flex-wrap items-center gap-2 mb-1">
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5] px-2 py-0.5 rounded-full">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Tambah
                                </span>
                                <span class="text-[10px] font-medium text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">Data Master</span>
                                <span class="text-[10px] text-gray-400">14:15 WIB • Chrome (192.168.1.33)</span>
                            </div>
                            <p class="text-xs text-[#1e293b] leading-relaxed">
                                <span class="font-bold text-[#554fed]">Ahmad Fauzi</span> menambahkan kategori baru <span class="font-bold text-[#1e293b]">"Sastra Kontemporer"</span>
                            </p>
                        </div>
                    </div>
                    <button onclick="openPayloadModal('Ahmad Fauzi', 'Data Master', 'Tambah', '14:15 WIB', 'Chrome (192.168.1.33)', 'menambahkan kategori baru Sastra Kontemporer')" class="text-[11px] font-semibold text-[#554fed] hover:underline flex items-center gap-1 shrink-0 bg-transparent border-0 cursor-pointer">
                        <span>Detail Payload</span>
                        <i class="bi bi-chevron-right text-[9px]"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(newGroup);
        moreLoaded = true;

        btn.disabled = false;
        txt.innerText = 'Semua Log Ditampilkan';
        icon.className = 'bi bi-check2 text-xs text-emerald-500';

        // Update counter
        const counter = document.getElementById('totalLogsCounter');
        if (counter) counter.innerText = '1.485';

        if (window.showToast) {
            window.showToast('3 catatan log tambahan berhasil dimuat.', 'success');
        }
    }, 500);
}

// Payload Modal
let currentPayloadText = '';
function openPayloadModal(user, modul, aksi, waktu, device, deskripsi) {
    document.getElementById('payloadModalUser').innerText = user;
    const badge = document.getElementById('payloadModalBadge');
    badge.innerText = `${modul} • ${aksi}`;
    
    const payloadObject = {
        meta: {
            request_id: "req_" + Math.random().toString(36).substring(2, 10),
            timestamp: `2026-10-31T${waktu.replace(' WIB', '')}:00+07:00`,
            user_ip: device.match(/\d+\.\d+\.\d+\.\d+/) ? device.match(/\d+\.\d+\.\d+\.\d+/)[0] : "192.168.1.10",
            client: device
        },
        action: {
            module: modul,
            operation: aksi.toUpperCase(),
            performed_by: user,
            summary: deskripsi
        },
        security: {
            auth_token_hash: "sha256:7f83b1657ff1fc53b92dc18148a1d65dfc2d4b1fa3d677284addd200126d9069",
            integrity_block: "#8942",
            status: "COMMITTED"
        }
    };

    currentPayloadText = JSON.stringify(payloadObject, null, 2);
    document.getElementById('payloadModalJson').innerText = currentPayloadText;

    const modal = document.getElementById('modalPayload');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closePayloadModal() {
    const modal = document.getElementById('modalPayload');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function copyPayloadJSON() {
    if (navigator.clipboard && currentPayloadText) {
        navigator.clipboard.writeText(currentPayloadText);
        if (window.showToast) {
            window.showToast('JSON Payload berhasil disalin ke papan klip!', 'success');
        }
    }
}

// Export Audit Log CSV
function exportAuditLogCSV() {
    const cards = document.querySelectorAll('.log-item-card:not(.hidden)');
    let csv = 'User,Modul,Aksi,Waktu,Deskripsi\n';

    cards.forEach(card => {
        const user = card.dataset.user || '';
        const modul = card.dataset.modul || '';
        const aksi = card.dataset.aksi || '';
        const text = card.querySelector('p.text-xs') ? card.querySelector('p.text-xs').innerText.replace(/\n/g, ' ') : '';
        const time = card.querySelector('span.text-gray-400') ? card.querySelector('span.text-gray-400').innerText : '';

        csv += `"${user}","${modul}","${aksi}","${time}","${text.replace(/"/g, '""')}"\n`;
    });

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.setAttribute('download', `Audit_Log_Perpustakaan_${new Date().toISOString().slice(0, 10)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    if (window.showToast) {
        window.showToast('Audit Log berhasil diekspor ke berkas CSV!', 'success');
    }
}
</script>
@endsection