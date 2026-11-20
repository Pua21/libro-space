@extends('layouts.app')

@section('title', 'Pengembalian & Denda')

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
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Pengembalian & Denda</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Pencatatan buku kembali, penghitungan denda keterlambatan, dan status pembayaran denda</p>
    </div>

    <div class="flex items-center gap-3">
        <button class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-download text-gray-600"></i>
            <span>Ekspor Laporan Denda</span>
        </button>

        <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
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
            <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight mt-1">{{ $stats['total_denda'] }}</h3>
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
            <h3 class="text-2xl font-extrabold text-[#ef4444] tracking-tight mt-1">{{ $stats['belum_bayar'] }}</h3>
            <p class="text-[11px] text-[#ef4444] font-semibold mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                {{ $stats['menunggak'] }}
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
            <h3 class="text-2xl font-extrabold text-[#10b981] tracking-tight mt-1">{{ $stats['denda_lunas'] }}</h3>
            <p class="text-[11px] text-[#10b981] font-semibold mt-1 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                {{ $stats['lunas_transaksi'] }}
            </p>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#ecfdf5] text-[#10b981] flex items-center justify-center text-xl">
            <i class="bi bi-patch-check"></i>
        </div>
    </div>
</div>

<!-- FILTERS & TABS -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-2">
        <button class="bg-[#554fed] text-white text-xs font-semibold px-4 py-2 rounded-full shadow-sm">
            Riwayat Pengembalian
        </button>
        <button class="bg-[#f8fafc] hover:bg-gray-100 text-[#64748b] text-xs font-medium px-4 py-2 rounded-full transition-colors">
            Rincian Denda & Pembayaran
        </button>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <div class="flex items-center gap-1.5 bg-[#f8fafc] border border-gray-100 rounded-full px-3 py-1.5 text-xs text-gray-700">
            <span class="text-gray-400">Status:</span>
            <span class="font-bold text-[#554fed] px-1.5 py-0.5 rounded cursor-pointer">Semua</span>
            <span class="text-[#10b981] font-semibold px-1.5 py-0.5 rounded cursor-pointer flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Lunas
            </span>
            <span class="text-[#ef4444] font-semibold px-1.5 py-0.5 rounded cursor-pointer flex items-center gap-1">
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
                <h3 class="text-sm font-bold text-[#1e293b]">Catatan Pengembalian Terbaru</h3>
                <span class="text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] px-2.5 py-0.5 rounded-full">52 Total</span>
            </div>
            <button class="text-xs font-semibold text-[#64748b] hover:text-[#1e293b] flex items-center gap-1.5">
                <i class="bi bi-sliders text-xs"></i>
                <span>Filter Lanjutan</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
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
                    <tr class="hover:bg-slate-50/70 transition-colors {{ $item['kode'] == 'PG-001' ? 'bg-[#fcfaff]' : '' }}">
                        <!-- Kode -->
                        <td class="py-4 pl-2 font-bold text-[#554fed]">
                            {{ $item['kode'] }}
                        </td>

                        <!-- Anggota -->
                        <td class="py-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ asset($item['avatar']) }}" 
                                     alt="{{ $item['anggota'] }}" 
                                     class="w-7 h-7 rounded-full object-cover border border-gray-100">
                                <div>
                                    <p class="font-bold text-[#1e293b] leading-tight">{{ $item['anggota'] }}</p>
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
                                <span class="font-medium text-[#1e293b] truncate max-w-[120px]">{{ $item['buku'] }}</span>
                            </div>
                        </td>

                        <!-- Tgl Kembali -->
                        <td class="py-4 text-[#64748b]">
                            {{ $item['tgl_kembali'] }}
                        </td>

                        <!-- Keterlambatan -->
                        <td class="py-4">
                            @if(str_contains($item['keterlambatan'], 'terlambat'))
                            <span class="text-[#ef4444] font-medium">{{ $item['keterlambatan'] }}</span>
                            @else
                            <span class="text-[#0d9488] font-medium">{{ $item['keterlambatan'] }}</span>
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
                            <p class="font-bold text-[#1e293b]">{{ $item['nominal'] }}</p>
                            @if($item['keterangan_biaya'])
                            <p class="text-[10px] text-gray-400">{{ $item['keterangan_biaya'] }}</p>
                            @endif
                        </td>

                        <!-- Status Bayar -->
                        <td class="py-4 text-center">
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
                        <td class="py-4 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                @if($item['action'] == 'lunasi')
                                <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1">
                                    <i class="bi bi-wallet2 text-[10px]"></i> Lunasi
                                </button>
                                @elseif($item['action'] == 'kuitansi')
                                <button class="border border-gray-200 hover:bg-gray-50 text-[#1e293b] text-[11px] font-semibold px-2.5 py-1 rounded-lg flex items-center gap-1">
                                    <i class="bi bi-receipt text-[10px]"></i> Kuitansi
                                </button>
                                @endif
                                <button class="w-7 h-7 rounded-lg text-gray-400 hover:text-[#554fed] hover:bg-gray-100 flex items-center justify-center transition-colors">
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
            <p>Menampilkan <span class="font-semibold text-[#1e293b]">1–6</span> dari <span class="font-semibold text-[#1e293b]">52</span> catatan sirkulasi</p>
            <div class="flex items-center gap-1.5">
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
                <span class="px-1 text-gray-400">...</span>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">9</button>
                <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
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
                    <span class="font-bold text-[#554fed]">{{ $paymentQuick['kode'] }}</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-full bg-[#554fed] text-white flex items-center justify-center font-bold text-xs">
                        {{ $paymentQuick['inisial'] }}
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-[#1e293b] leading-tight">{{ $paymentQuick['anggota'] }}</h4>
                        <p class="text-[10px] text-[#ef4444] font-medium">{{ $paymentQuick['keterangan'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Cost items -->
            <div class="space-y-2 text-xs pb-3 border-b border-gray-100 mb-3">
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Tarif Denda (@Rp 1.000/hr)</span>
                    <span class="font-bold text-[#1e293b]">{{ $paymentQuick['tarif_denda'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Biaya Administrasi</span>
                    <span class="font-bold text-[#10b981]">{{ $paymentQuick['biaya_admin'] }}</span>
                </div>
                <div class="flex items-center justify-between pt-1">
                    <span class="font-bold text-[#1e293b]">Total Pembayaran</span>
                    <span class="text-lg font-extrabold text-[#554fed]">{{ $paymentQuick['total'] }}</span>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-4">
                <label class="block text-[11px] font-bold text-[#1e293b] mb-2">Metode Pembayaran</label>
                <div class="grid grid-cols-2 gap-2">
                    <button class="border-2 border-[#554fed] bg-[#eff1fe] text-[#554fed] text-xs font-bold py-2 rounded-xl flex items-center justify-center gap-1.5 shadow-sm">
                        <i class="bi bi-cash"></i>
                        <span>Tunai (Cash)</span>
                    </button>
                    <button class="border border-gray-200 text-[#64748b] text-xs font-medium py-2 rounded-xl flex items-center justify-center gap-1.5 hover:bg-gray-50 transition-colors">
                        <i class="bi bi-qr-code"></i>
                        <span>QRIS Dinamis</span>
                    </button>
                </div>
            </div>

            <!-- Received & Change -->
            <div class="space-y-3 mb-5">
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="text-[11px] font-bold text-[#1e293b]">Uang Diterima</label>
                        <a href="javascript:void(0)" class="text-[10px] font-bold text-[#554fed] hover:underline">Uang Pas</a>
                    </div>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-500">Rp</span>
                        <input type="text" value="{{ $paymentQuick['uang_diterima'] }}" 
                               class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-10 pr-3.5 py-2 text-xs font-bold text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <span class="text-[#64748b] font-medium">Kembalian:</span>
                    <span class="font-extrabold text-[#10b981] text-sm">{{ $paymentQuick['kembalian'] }}</span>
                </div>
            </div>

            <!-- Submit -->
            <button class="w-full bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-3 rounded-full flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
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
@endsection
