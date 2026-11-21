@extends('layouts.app')

@section('title', 'Pengembalian & Denda')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="globalPengembalianSearch"
               onkeyup="liveFilterPengembalian()"
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
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Pengembalian & Denda</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Pencatatan buku kembali, penghitungan denda keterlambatan, dan status pembayaran denda</p>
    </div>

    <div class="flex items-center gap-3">
        <button onclick="exportDendaData()" class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-download text-gray-600"></i>
            <span>Ekspor Laporan Denda</span>
        </button>

        <button onclick="document.getElementById('returnProcessModal').classList.remove('hidden')" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-plus-lg"></i>
            <span>+ Proses Pengembalian</span>
        </button>
    </div>
</div>

<!-- 3 METRIC CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <!-- Total Denda Bulan Ini -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div>
            <p class="text-xs text-[#64748b] font-medium">Total Denda Bulan Ini</p>
            <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight mt-1" id="statTotalDenda">{{ $stats['total_denda'] }}</h3>
            <p class="text-[11px] text-[#10b981] font-semibold mt-1">
                <i class="bi bi-arrow-up-right"></i> {{ $stats['total_change'] }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-xl">
            <i class="bi bi-cash-stack"></i>
        </div>
    </div>

    <!-- Denda Belum Dibayar -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div>
            <p class="text-xs text-[#64748b] font-medium">Denda Belum Dibayar</p>
            <h3 class="text-2xl font-extrabold text-[#ef4444] tracking-tight mt-1" id="statBelumBayar">{{ $stats['belum_bayar'] }}</h3>
            <p class="text-[11px] text-[#ef4444] font-semibold mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                <span id="statMenunggakText">{{ $stats['menunggak'] }}</span>
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#fef2f2] text-[#ef4444] flex items-center justify-center text-xl">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
    </div>

    <!-- Denda Lunas -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div>
            <p class="text-xs text-[#64748b] font-medium">Denda Lunas</p>
            <h3 class="text-2xl font-extrabold text-[#10b981] tracking-tight mt-1" id="statDendaLunas">{{ $stats['denda_lunas'] }}</h3>
            <p class="text-[11px] text-[#10b981] font-semibold mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                <span id="statLunasText">{{ $stats['lunas_transaksi'] }}</span>
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#ecfdf5] text-[#10b981] flex items-center justify-center text-xl">
            <i class="bi bi-patch-check"></i>
        </div>
    </div>
</div>

<!-- FILTERS & TABS -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-2" id="returnMainTabs">
        <button onclick="setReturnMainTab('riwayat', this)" class="main-tab-btn bg-[#554fed] text-white text-xs font-semibold px-4 py-2 rounded-full shadow-sm transition-all">
            Riwayat Pengembalian
        </button>
        <button onclick="setReturnMainTab('rincian', this)" class="main-tab-btn bg-[#f8fafc] hover:bg-gray-100 text-[#64748b] text-xs font-medium px-4 py-2 rounded-full transition-colors">
            Rincian Denda & Pembayaran
        </button>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <div class="flex items-center gap-1.5 bg-[#f8fafc] border border-gray-100 rounded-full px-3 py-1.5 text-xs text-gray-700">
            <span class="text-gray-400">Status:</span>
            <span onclick="setStatusFilter('', this)" class="status-chip font-bold text-[#554fed] px-1.5 py-0.5 rounded cursor-pointer">Semua</span>
            <span onclick="setStatusFilter('Lunas', this)" class="status-chip text-[#10b981] font-semibold px-1.5 py-0.5 rounded cursor-pointer flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Lunas
            </span>
            <span onclick="setStatusFilter('Belum Bayar', this)" class="status-chip text-[#ef4444] font-semibold px-1.5 py-0.5 rounded cursor-pointer flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span> Belum Bayar
            </span>
        </div>

        <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2 text-xs text-gray-700">
            <i class="bi bi-calendar text-gray-400"></i>
            <span>01 Okt 2026 – 31 Okt 2026</span>
        </div>

        <div class="relative min-w-[200px]">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   id="returnSearchInput"
                   onkeyup="liveFilterPengembalian()"
                   placeholder="Cari nama anggota, kode, atau judul buku..." 
                   class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
        </div>
    </div>
</div>

<!-- MAIN GRID (Table & Payment Box) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    
    <!-- LEFT: Table (8 cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <h3 id="returnTableTitle" class="text-sm font-bold text-[#1e293b]">Catatan Pengembalian Terbaru</h3>
                <span class="text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] px-2.5 py-0.5 rounded-full" id="returnBadgeCount">52 Total</span>
            </div>
            <button onclick="toggleAdvancedFilter()" class="text-xs font-semibold text-[#64748b] hover:text-[#1e293b] flex items-center gap-1.5">
                <i class="bi bi-sliders text-xs"></i>
                <span>Filter Lanjutan</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table id="pengembalianTable" class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[#64748b] font-semibold border-b border-gray-100">
                        <th class="pb-3.5 pl-2">Kode Kembali</th>
                        <th class="pb-3.5">Anggota</th>
                        <th class="pb-3.5">Buku</th>
                        <th class="pb-3.5">Tgl Kembali</th>
                        <th class="pb-3.5">Keterlambatan</th>
                        <th class="pb-3.5">Kondisi Buku</th>
                        <th class="pb-3.5">Nominal Denda</th>
                        <th class="pb-3.5 text-center">Status Bayar</th>
                        <th class="pb-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($pengembalianList as $item)
                    <tr class="pengembalian-row hover:bg-slate-50/70 transition-colors {{ $item['kode'] == 'PG-001' ? 'bg-[#fcfaff]' : '' }}"
                        data-kode="{{ $item['kode'] }}"
                        data-anggota="{{ $item['anggota'] }}"
                        data-no-anggota="{{ $item['no_anggota'] }}"
                        data-buku="{{ $item['buku'] }}"
                        data-tgl="{{ $item['tgl_kembali'] }}"
                        data-telat="{{ $item['keterlambatan'] }}"
                        data-kondisi="{{ $item['kondisi'] }}"
                        data-nominal="{{ $item['nominal'] }}"
                        data-status="{{ $item['status_bayar'] }}">
                        <!-- Kode -->
                        <td class="py-4 pl-2 font-bold text-[#554fed] row-kode">
                            {{ $item['kode'] }}
                        </td>

                        <!-- Anggota -->
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset($item['avatar']) }}" 
                                     alt="{{ $item['anggota'] }}" 
                                     class="w-7 h-7 rounded-full object-cover border border-gray-100">
                                <div>
                                    <p class="font-bold text-[#1e293b] leading-tight row-anggota">{{ $item['anggota'] }}</p>
                                    <p class="text-[10px] text-[#64748b] font-mono">{{ $item['no_anggota'] }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Buku -->
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset($item['cover']) }}" 
                                     alt="{{ $item['buku'] }}" 
                                     class="w-6 h-8 object-cover rounded shadow-sm border border-gray-100">
                                <span class="font-medium text-[#1e293b] truncate max-w-[120px] row-buku">{{ $item['buku'] }}</span>
                            </div>
                        </td>

                        <!-- Tgl Kembali -->
                        <td class="py-4 text-[#64748b]">
                            {{ $item['tgl_kembali'] }}
                        </td>

                        <!-- Keterlambatan -->
                        <td class="py-4">
                            @if(str_contains($item['keterlambatan'], 'terlambat'))
                            <span class="text-[#ef4444] font-medium row-telat">{{ $item['keterlambatan'] }}</span>
                            @else
                            <span class="text-[#0d9488] font-medium row-telat">{{ $item['keterlambatan'] }}</span>
                            @endif
                        </td>

                        <!-- Kondisi -->
                        <td class="py-4">
                            @if($item['kondisi'] == 'Baik')
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#10b981]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Baik
                            </span>
                            @elseif($item['kondisi'] == 'Rusak')
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#f59e0b]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span> Rusak
                            </span>
                            @elseif($item['kondisi'] == 'Hilang')
                            <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#ef4444]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span> Hilang
                            </span>
                            @endif
                        </td>

                        <!-- Nominal Denda -->
                        <td class="py-4">
                            <p class="font-bold text-[#1e293b] row-nominal">{{ $item['nominal'] }}</p>
                            @if($item['keterangan_biaya'])
                            <p class="text-[10px] text-gray-400">{{ $item['keterangan_biaya'] }}</p>
                            @endif
                        </td>

                        <!-- Status Bayar -->
                        <td class="py-4 text-center row-status-cell">
                            @if($item['status_bayar'] == 'Lunas')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Lunas
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span> Belum Bayar
                            </span>
                            @endif
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 text-center row-action-cell">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($item['action'] == 'lunasi')
                                <button onclick="selectRowForPayment(this)" class="btn-lunasi bg-[#554fed] hover:bg-[#4338ca] text-white text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1 transition-all">
                                    <i class="bi bi-wallet2 text-[10px]"></i> Lunasi
                                </button>
                                @elseif($item['action'] == 'kuitansi')
                                <button onclick="openReceiptModal('{{ $item['kode'] }}', '{{ $item['anggota'] }}', '{{ $item['buku'] }}', '{{ $item['nominal'] }}', '{{ $item['tgl_kembali'] }}')" class="border border-gray-200 hover:bg-gray-50 text-[#1e293b] text-[11px] font-semibold px-2.5 py-1 rounded-lg flex items-center gap-1 transition-colors">
                                    <i class="bi bi-receipt text-[10px]"></i> Kuitansi
                                </button>
                                @endif
                                <button onclick="openReturnDetail('{{ $item['kode'] }}', '{{ $item['anggota'] }}', '{{ $item['buku'] }}', '{{ $item['keterlambatan'] }}', '{{ $item['kondisi'] }}', '{{ $item['nominal'] }}', '{{ $item['status_bayar'] }}')" class="w-7 h-7 rounded-lg text-gray-400 hover:text-[#554fed] hover:bg-gray-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-eye text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 text-xs text-[#64748b]">
            <p>Menampilkan <span class="font-semibold text-[#1e293b]" id="returnVisibleRange">1–6</span> dari <span class="font-semibold text-[#1e293b]">52</span> catatan sirkulasi</p>
            <div class="flex items-center gap-1.5">
                <button onclick="showToast('Halaman sebelumnya.');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                <button onclick="showToast('Membuka halaman 2...');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
                <button onclick="showToast('Membuka halaman 3...');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
                <span class="px-1 text-gray-400">...</span>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">9</button>
                <button onclick="showToast('Halaman berikutnya.');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- RIGHT: Quick Payment Panel (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- Quick Settlement Card -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center gap-2 mb-1">
                <div class="w-7 h-7 rounded-lg bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-sm">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <h3 class="text-sm font-bold text-[#1e293b]">Ringkasan Pembayaran Denda Cepat</h3>
            </div>
            <p class="text-[11px] text-[#64748b] mb-4">Penyelesaian denda instan untuk pengembalian aktif.</p>

            <!-- Selected Borrower Box -->
            <div class="p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4">
                <div class="flex items-center justify-between text-[10px] text-[#64748b] mb-1.5">
                    <span>Peminjam Terpilih</span>
                    <span class="font-bold text-[#554fed]" id="payTargetKode">{{ $paymentQuick['kode'] }}</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div id="payAvatarInitial" class="w-8 h-8 rounded-full bg-[#554fed] text-white flex items-center justify-center font-bold text-xs">
                        {{ $paymentQuick['inisial'] }}
                    </div>
                    <div>
                        <h4 id="payMemberName" class="text-xs font-bold text-[#1e293b] leading-tight">{{ $paymentQuick['anggota'] }}</h4>
                        <p id="payOverdueDesc" class="text-[10px] text-[#ef4444] font-medium">{{ $paymentQuick['keterangan'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Cost items -->
            <div class="space-y-2 text-xs pb-3 border-b border-gray-100 mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Tarif Denda (@Rp 1.000/hr)</span>
                    <span id="payTarifDenda" class="font-bold text-[#1e293b]">{{ $paymentQuick['tarif_denda'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Biaya Administrasi</span>
                    <span class="font-bold text-[#10b981]">{{ $paymentQuick['biaya_admin'] }}</span>
                </div>
                <div class="flex items-center justify-between pt-1">
                    <span class="font-bold text-[#1e293b]">Total Pembayaran</span>
                    <span id="payTotalAmount" class="text-lg font-extrabold text-[#554fed]" data-raw="3000">{{ $paymentQuick['total'] }}</span>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-4">
                <label class="block text-[11px] font-bold text-[#1e293b] mb-2">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-2" id="paymentMethodButtons">
                    <button type="button" onclick="setPaymentMethod('cash')" id="btnMethodCash" class="border-2 border-[#554fed] bg-[#eff1fe] text-[#554fed] text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 shadow-sm transition-all">
                        <i class="bi bi-cash"></i>
                        <span>Tunai (Cash)</span>
                    </button>
                    <button type="button" onclick="setPaymentMethod('qris')" id="btnMethodQris" class="border border-gray-200 text-[#64748b] text-xs font-medium py-2 rounded-xl flex items-center justify-center gap-1.5 hover:bg-gray-50 transition-colors">
                        <i class="bi bi-qr-code"></i>
                        <span>QRIS Dinamis</span>
                    </button>
                </div>
            </div>

            <!-- QRIS View (Hidden by default) -->
            <div id="qrisContainer" class="hidden mb-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center animate-in fade-in">
                <div class="w-36 h-36 mx-auto bg-white p-2 rounded-xl border shadow-inner flex items-center justify-center mb-2">
                    <i class="bi bi-qr-code text-7xl text-slate-800"></i>
                </div>
                <p class="text-[11px] font-bold text-gray-700">Scan QRIS Nasional</p>
                <p class="text-[10px] text-gray-400">Berlaku selama: <span class="font-bold text-[#554fed]" id="qrisTimer">04:59</span></p>
            </div>

            <!-- Received & Change (Cash View) -->
            <div id="cashContainer" class="space-y-3 mb-5">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="text-[11px] font-bold text-[#1e293b]">Uang Diterima</label>
                        <a href="javascript:void(0)" onclick="setExactAmount()" class="text-[10px] font-bold text-[#554fed] hover:underline">Uang Pas</a>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-500">Rp</span>
                        <input type="number" 
                               id="inputUangDiterima" 
                               value="5000" 
                               oninput="calculateChange()"
                               class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-10 pr-3.5 py-2 text-xs font-bold text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-[#64748b] font-medium">Kembalian:</span>
                    <span id="kembalianAmountText" class="font-extrabold text-[#10b981] text-sm">Rp 2.000</span>
                </div>
            </div>

            <!-- Submit -->
            <button onclick="handleConfirmFinePayment()" id="btnConfirmPayment" class="w-full bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-3 rounded-full flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
                <i class="bi bi-check2-circle text-base"></i>
                <span>Konfirmasi Pembayaran</span>
            </button>
        </div>

        <!-- Aturan Denda Otomatis -->
        <div class="bg-[#f8fafc] rounded-3xl p-5 border border-gray-100 flex items-start gap-3">
            <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                <i class="bi bi-info-circle-fill text-sm"></i>
            </div>
            <div>
                <h4 class="text-xs font-bold text-[#1e293b]">Aturan Denda Otomatis</h4>
                <p class="text-[11px] text-[#64748b] leading-relaxed mt-1">
                    Keterlambatan dihitung Rp 1.000/hari per judul. Buku rusak dikenakan 50% harga buku, dan hilang 100% harga buku pengganti.
                </p>
            </div>
        </div>

    </div>

</div>

<!-- MODAL PROSES PENGEMBALIAN -->
<div id="returnProcessModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-box-arrow-in-down-left"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Proses Pengembalian Buku</h3>
                    <p class="text-xs text-[#64748b]">Hitung denda keterlambatan dan periksa kondisi fisik buku</p>
                </div>
            </div>
            <button onclick="document.getElementById('returnProcessModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>

        <form onsubmit="handleSubmitReturnProcess(event)" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Nama Peminjam</label>
                <input type="text" id="newRetMember" placeholder="Contoh: Maya Indriani" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Judul Buku</label>
                    <input type="text" id="newRetBook" placeholder="Judul buku..." required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Kondisi Fisik Buku</label>
                    <select id="newRetCondition" onchange="autoCalculateFineInModal()" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option value="Baik">Baik (Tidak Rusak)</option>
                        <option value="Rusak">Rusak (+Rp 50.000)</option>
                        <option value="Hilang">Hilang (+Rp 100.000)</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Keterlambatan (Hari)</label>
                    <input type="number" id="newRetLateDays" value="0" min="0" oninput="autoCalculateFineInModal()" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Total Denda Dihitung</label>
                    <input type="text" id="newRetTotalFine" value="Rp 0" readonly class="w-full bg-[#eff1fe] border border-indigo-100 font-bold text-[#554fed] rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('returnProcessModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                    <i class="bi bi-check-lg"></i>
                    <span>Catat Pengembalian</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL KUITANSI PEMBAYARAN -->
<div id="receiptModalDenda" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm p-6 shadow-2xl printable-content animate-in fade-in zoom-in duration-150">
        <div class="text-center border-b border-dashed border-gray-200 pb-4 mb-4">
            <div class="w-10 h-10 rounded-2xl bg-[#10b981] text-white flex items-center justify-center mx-auto mb-2 text-lg shadow-sm">
                <i class="bi bi-receipt"></i>
            </div>
            <h4 class="font-bold text-[#1e293b] text-sm">KUITANSI PEMBAYARAN DENDA</h4>
            <p class="text-[10px] text-gray-400">Sistem Perpustakaan Terpadu</p>
        </div>
        <div class="space-y-2 text-xs mb-4">
            <div class="flex justify-between"><span class="text-gray-400">Nomor Transaksi:</span><span id="recNo" class="font-bold text-[#554fed] font-mono">PG-001</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Peminjam:</span><span id="recMember" class="font-bold text-[#1e293b]">-</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Buku:</span><span id="recBook" class="font-bold text-[#1e293b] text-right">-</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Tanggal:</span><span id="recDate" class="text-gray-600">-</span></div>
            <div class="flex justify-between pt-2 border-t border-gray-100"><span class="font-bold text-[#1e293b]">Nominal Dibayar:</span><span id="recTotal" class="font-extrabold text-[#10b981] text-sm">-</span></div>
            <div class="flex justify-between"><span class="text-gray-400">Status:</span><span class="font-bold text-[#10b981]">LUNAS (Verified)</span></div>
        </div>
        <div class="pt-3 border-t border-dashed border-gray-200 flex items-center justify-between no-print">
            <button onclick="document.getElementById('receiptModalDenda').classList.add('hidden')" class="px-4 py-2 rounded-full border border-gray-200 text-xs font-semibold text-gray-600">Tutup</button>
            <button onclick="window.print()" class="bg-[#554fed] text-white text-xs font-bold px-5 py-2 rounded-full flex items-center gap-1.5 shadow-sm">
                <i class="bi bi-printer"></i>
                <span>Cetak Kuitansi</span>
            </button>
        </div>
    </div>
</div>

<!-- MODAL DETAIL PENGEMBALIAN -->
<div id="returnDetailModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h4 class="font-bold text-[#1e293b] text-sm flex items-center gap-2">
                <i class="bi bi-info-circle text-[#554fed]"></i> Detail Pengembalian & Denda
            </h4>
            <button onclick="document.getElementById('returnDetailModal').classList.add('hidden')" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <div class="space-y-3 text-xs mb-4">
            <div class="flex justify-between"><span class="text-gray-500">Kode Pengembalian:</span><span id="dtlKode" class="font-bold text-[#554fed] font-mono">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Nama Peminjam:</span><span id="dtlAnggota" class="font-bold text-[#1e293b]">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Judul Buku:</span><span id="dtlBuku" class="font-bold text-gray-800 text-right">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Keterlambatan:</span><span id="dtlTelat" class="font-medium text-gray-700">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Kondisi Buku:</span><span id="dtlKondisi" class="font-bold text-gray-800">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Nominal Denda:</span><span id="dtlNominal" class="font-extrabold text-[#ef4444]">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Status Pembayaran:</span><span id="dtlStatus" class="font-bold text-[#10b981]">-</span></div>
        </div>
        <div class="flex justify-end">
            <button onclick="document.getElementById('returnDetailModal').classList.add('hidden')" class="bg-[#554fed] text-white text-xs font-bold px-5 py-2 rounded-full">Tutup</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activePaymentRow = document.querySelector('.pengembalian-row[data-kode="PG-001"]') || document.querySelector('.pengembalian-row');
    let activeStatusFilter = '';
    let currentPaymentMethod = 'cash';
    let currentFineAmount = 3000;

    function setReturnMainTab(tab, btn) {
        document.querySelectorAll('#returnMainTabs button').forEach(b => {
            b.classList.remove('bg-[#554fed]', 'text-white');
            b.classList.add('bg-[#f8fafc]', 'text-[#64748b]');
        });
        btn.classList.remove('bg-[#f8fafc]', 'text-[#64748b]');
        btn.classList.add('bg-[#554fed]', 'text-white');

        if (tab === 'rincian') {
            document.getElementById('returnTableTitle').textContent = 'Rincian Denda & Rekap Pembayaran';
            showToast('Menampilkan rincian denda perpustakaan.', 'info');
        } else {
            document.getElementById('returnTableTitle').textContent = 'Catatan Pengembalian Terbaru';
            showToast('Menampilkan riwayat pengembalian bahan pustaka.', 'info');
        }
    }

    function setStatusFilter(status, chip) {
        activeStatusFilter = status.toLowerCase();
        document.querySelectorAll('.status-chip').forEach(c => {
            c.classList.remove('bg-gray-100', 'font-bold');
        });
        chip.classList.add('bg-gray-100', 'font-bold');
        liveFilterPengembalian();
        showToast(status ? `Filter status: ${status}` : 'Menampilkan semua transaksi pengembalian.', 'info');
    }

    function liveFilterPengembalian() {
        const query = (document.getElementById('returnSearchInput')?.value || document.getElementById('globalPengembalianSearch')?.value || '').toLowerCase();
        const rows = document.querySelectorAll('.pengembalian-row');
        let count = 0;

        rows.forEach(row => {
            const kode = (row.getAttribute('data-kode') || '').toLowerCase();
            const anggota = (row.getAttribute('data-anggota') || '').toLowerCase();
            const buku = (row.getAttribute('data-buku') || '').toLowerCase();
            const status = (row.getAttribute('data-status') || '').toLowerCase();

            const matchQuery = kode.includes(query) || anggota.includes(query) || buku.includes(query);
            const matchStatus = !activeStatusFilter || status.includes(activeStatusFilter);

            if (matchQuery && matchStatus) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('returnVisibleRange').textContent = `1–${count}`;
    }

    function selectRowForPayment(btn) {
        const row = btn.closest('tr');
        document.querySelectorAll('.pengembalian-row').forEach(r => r.classList.remove('bg-[#fcfaff]'));
        row.classList.add('bg-[#fcfaff]');
        activePaymentRow = row;

        const kode = row.getAttribute('data-kode');
        const anggota = row.getAttribute('data-anggota');
        const buku = row.getAttribute('data-buku');
        const telat = row.getAttribute('data-telat');
        const nominalStr = row.getAttribute('data-nominal');

        // Extract numbers from Rp string
        const nominalVal = parseInt(nominalStr.replace(/[^0-9]/g, '')) || 0;
        currentFineAmount = nominalVal;

        document.getElementById('payTargetKode').textContent = kode;
        document.getElementById('payMemberName').textContent = anggota;
        document.getElementById('payAvatarInitial').textContent = anggota.charAt(0);
        document.getElementById('payOverdueDesc').textContent = `${telat} (${buku})`;
        document.getElementById('payTarifDenda').textContent = nominalStr;
        document.getElementById('payTotalAmount').textContent = nominalStr;
        document.getElementById('payTotalAmount').setAttribute('data-raw', nominalVal);

        document.getElementById('inputUangDiterima').value = nominalVal > 0 ? (nominalVal + 2000) : 0;
        calculateChange();

        showToast(`Memuat ${kode} (${anggota}) ke Ringkasan Pembayaran.`);
    }

    function setPaymentMethod(method) {
        currentPaymentMethod = method;
        const btnCash = document.getElementById('btnMethodCash');
        const btnQris = document.getElementById('btnMethodQris');
        const qrisBox = document.getElementById('qrisContainer');
        const cashBox = document.getElementById('cashContainer');

        if (method === 'qris') {
            btnQris.className = 'border-2 border-[#554fed] bg-[#eff1fe] text-[#554fed] text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 shadow-sm transition-all';
            btnCash.className = 'border border-gray-200 text-[#64748b] text-xs font-medium py-2 rounded-xl flex items-center justify-center gap-1.5 hover:bg-gray-50 transition-colors';
            qrisBox.classList.remove('hidden');
            cashBox.classList.add('hidden');
            showToast('Metode pembayaran QRIS diaktifkan.');
        } else {
            btnCash.className = 'border-2 border-[#554fed] bg-[#eff1fe] text-[#554fed] text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 shadow-sm transition-all';
            btnQris.className = 'border border-gray-200 text-[#64748b] text-xs font-medium py-2 rounded-xl flex items-center justify-center gap-1.5 hover:bg-gray-50 transition-colors';
            qrisBox.classList.add('hidden');
            cashBox.classList.remove('hidden');
            showToast('Metode pembayaran Tunai diaktifkan.');
        }
    }

    function setExactAmount() {
        document.getElementById('inputUangDiterima').value = currentFineAmount;
        calculateChange();
        showToast('Uang diterima diset ke nominal pas.');
    }

    function calculateChange() {
        const received = parseInt(document.getElementById('inputUangDiterima').value) || 0;
        const change = received - currentFineAmount;
        const changeEl = document.getElementById('kembalianAmountText');

        if (change >= 0) {
            changeEl.textContent = `Rp ${change.toLocaleString('id-ID')}`;
            changeEl.className = 'font-extrabold text-[#10b981] text-sm';
        } else {
            changeEl.textContent = `Kurang Rp ${Math.abs(change).toLocaleString('id-ID')}`;
            changeEl.className = 'font-extrabold text-[#ef4444] text-sm';
        }
    }

    function handleConfirmFinePayment() {
        if (!activePaymentRow) return;

        const kode = activePaymentRow.getAttribute('data-kode');
        const anggota = activePaymentRow.getAttribute('data-anggota');
        const buku = activePaymentRow.getAttribute('data-buku');
        const nominal = activePaymentRow.getAttribute('data-nominal');

        if (currentPaymentMethod === 'cash') {
            const received = parseInt(document.getElementById('inputUangDiterima').value) || 0;
            if (received < currentFineAmount) {
                showToast('Nominal uang diterima kurang dari total denda!', 'error');
                return;
            }
        }

        // Update active row
        activePaymentRow.setAttribute('data-status', 'Lunas');
        const statusCell = activePaymentRow.querySelector('.row-status-cell');
        statusCell.innerHTML = `<span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]"><span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Lunas</span>`;

        const actionCell = activePaymentRow.querySelector('.row-action-cell');
        actionCell.innerHTML = `
            <div class="flex items-center justify-center gap-1.5">
                <button onclick="openReceiptModal('${kode}', '${anggota}', '${buku}', '${nominal}', 'Hari Ini')" class="border border-gray-200 hover:bg-gray-50 text-[#1e293b] text-[11px] font-semibold px-2.5 py-1 rounded-lg flex items-center gap-1 transition-colors">
                    <i class="bi bi-receipt text-[10px]"></i> Kuitansi
                </button>
                <button onclick="openReturnDetail('${kode}', '${anggota}', '${buku}', 'Tepat Waktu', 'Baik', '${nominal}', 'Lunas')" class="w-7 h-7 rounded-lg text-gray-400 hover:text-[#554fed] hover:bg-gray-100 flex items-center justify-center transition-colors">
                    <i class="bi bi-eye text-xs"></i>
                </button>
            </div>
        `;

        showToast(`Pembayaran denda ${kode} untuk ${anggota} berhasil dikonfirmasi!`);
    }

    function autoCalculateFineInModal() {
        const days = parseInt(document.getElementById('newRetLateDays').value) || 0;
        const condition = document.getElementById('newRetCondition').value;
        let fine = days * 1000;
        if (condition === 'Rusak') fine += 50000;
        if (condition === 'Hilang') fine += 100000;

        document.getElementById('newRetTotalFine').value = `Rp ${fine.toLocaleString('id-ID')}`;
    }

    function handleSubmitReturnProcess(e) {
        e.preventDefault();
        const member = document.getElementById('newRetMember').value;
        const book = document.getElementById('newRetBook').value;
        const cond = document.getElementById('newRetCondition').value;
        const days = document.getElementById('newRetLateDays').value;
        const fineStr = document.getElementById('newRetTotalFine').value;
        const kode = 'PG-' + String(Math.floor(Math.random() * 900) + 100);
        const isLate = parseInt(days) > 0;
        const isZero = fineStr === 'Rp 0';

        const tbody = document.querySelector('#pengembalianTable tbody');
        const tr = document.createElement('tr');
        tr.className = 'pengembalian-row hover:bg-slate-50/70 transition-colors animate-in fade-in';
        tr.setAttribute('data-kode', kode);
        tr.setAttribute('data-anggota', member);
        tr.setAttribute('data-no-anggota', 'AGT-0099');
        tr.setAttribute('data-buku', book);
        tr.setAttribute('data-tgl', 'Hari Ini');
        tr.setAttribute('data-telat', isLate ? `${days} hari terlambat` : 'Tepat Waktu');
        tr.setAttribute('data-kondisi', cond);
        tr.setAttribute('data-nominal', fineStr);
        tr.setAttribute('data-status', isZero ? 'Lunas' : 'Belum Bayar');

        tr.innerHTML = `
            <td class="py-4 pl-2 font-bold text-[#554fed] row-kode">${kode}</td>
            <td class="py-4">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-full bg-[#554fed] text-white flex items-center justify-center font-bold text-[10px]">
                        ${member.charAt(0)}
                    </div>
                    <div>
                        <p class="font-bold text-[#1e293b] leading-tight row-anggota">${member}</p>
                        <p class="text-[10px] text-[#64748b] font-mono">AGT-0099</p>
                    </div>
                </div>
            </td>
            <td class="py-4">
                <span class="font-medium text-[#1e293b] truncate max-w-[120px] row-buku">${book}</span>
            </td>
            <td class="py-4 text-[#64748b]">Hari Ini</td>
            <td class="py-4">
                <span class="${isLate ? 'text-[#ef4444]' : 'text-[#0d9488]'} font-medium row-telat">${isLate ? `${days} hari terlambat` : 'Tepat Waktu'}</span>
            </td>
            <td class="py-4">
                <span class="inline-flex items-center gap-1 text-[11px] font-semibold ${cond === 'Baik' ? 'text-[#10b981]' : (cond === 'Rusak' ? 'text-[#f59e0b]' : 'text-[#ef4444]')}">
                    <span class="w-1.5 h-1.5 rounded-full ${cond === 'Baik' ? 'bg-[#10b981]' : (cond === 'Rusak' ? 'bg-[#f59e0b]' : 'bg-[#ef4444]')}"></span> ${cond}
                </span>
            </td>
            <td class="py-4">
                <p class="font-bold text-[#1e293b] row-nominal">${fineStr}</p>
            </td>
            <td class="py-4 text-center row-status-cell">
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-semibold ${isZero ? 'text-[#10b981] bg-[#ecfdf5] border-[#d1fae5]' : 'text-[#ef4444] bg-[#fef2f2] border-[#fee2e2]'} border">
                    <span class="w-1.5 h-1.5 rounded-full ${isZero ? 'bg-[#10b981]' : 'bg-[#ef4444]'}"></span> ${isZero ? 'Lunas' : 'Belum Bayar'}
                </span>
            </td>
            <td class="py-4 text-center row-action-cell">
                <div class="flex items-center justify-center gap-1.5">
                    ${!isZero ? `<button onclick="selectRowForPayment(this)" class="btn-lunasi bg-[#554fed] hover:bg-[#4338ca] text-white text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1"><i class="bi bi-wallet2 text-[10px]"></i> Lunasi</button>` : ''}
                    <button onclick="openReturnDetail('${kode}', '${member}', '${book}', '${days} hari', '${cond}', '${fineStr}', '${isZero ? 'Lunas' : 'Belum Bayar'}')" class="w-7 h-7 rounded-lg text-gray-400 hover:text-[#554fed] hover:bg-gray-100 flex items-center justify-center">
                        <i class="bi bi-eye text-xs"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
        document.getElementById('returnProcessModal').classList.add('hidden');
        showToast(`Pengembalian ${kode} berhasil dicatat!`);
    }

    function openReceiptModal(kode, member, book, nominal, date) {
        document.getElementById('recNo').textContent = kode;
        document.getElementById('recMember').textContent = member;
        document.getElementById('recBook').textContent = book;
        document.getElementById('recTotal').textContent = nominal;
        document.getElementById('recDate').textContent = date;
        document.getElementById('receiptModalDenda').classList.remove('hidden');
    }

    function openReturnDetail(kode, member, book, telat, kondisi, nominal, status) {
        document.getElementById('dtlKode').textContent = kode;
        document.getElementById('dtlAnggota').textContent = member;
        document.getElementById('dtlBuku').textContent = book;
        document.getElementById('dtlTelat').textContent = telat;
        document.getElementById('dtlKondisi').textContent = kondisi;
        document.getElementById('dtlNominal').textContent = nominal;
        document.getElementById('dtlStatus').textContent = status;
        document.getElementById('returnDetailModal').classList.remove('hidden');
    }

    function exportDendaData() {
        const rows = document.querySelectorAll('.pengembalian-row');
        let csv = "Kode,Anggota,Buku,Tgl Kembali,Keterlambatan,Kondisi,Nominal,Status\n";
        rows.forEach(r => {
            csv += `"${r.getAttribute('data-kode')}","${r.getAttribute('data-anggota')}","${r.getAttribute('data-buku')}","${r.getAttribute('data-tgl')}","${r.getAttribute('data-telat')}","${r.getAttribute('data-kondisi')}","${r.getAttribute('data-nominal')}","${r.getAttribute('data-status')}"\n`;
        });
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = "laporan_pengembalian_denda.csv";
        a.click();
        window.URL.revokeObjectURL(url);
        showToast('Laporan denda berhasil diekspor ke format CSV!');
    }

    function toggleAdvancedFilter() {
        showToast('Filter lanjutan diaktifkan.', 'info');
    }
</script>
@endpush
