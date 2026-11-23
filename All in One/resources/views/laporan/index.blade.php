@extends('layouts.app')

@section('title', 'Laporan')

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

<!-- PAGE TITLE & DESCRIPTION -->
<div class="mb-6">
    <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Laporan</h2>
    <p class="text-xs text-[#64748b] font-medium mt-0.5">Buat, tinjau, dan ekspor laporan rekapitulasi data perpustakaan</p>
</div>

<!-- 5 REPORT TYPE CARDS -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6" id="reportTabsContainer">
    <!-- 1. Laporan Buku -->
    <div onclick="switchReportTab('buku')" 
         data-tab="buku"
         class="report-tab-card bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer border-2 border-transparent">
        <div class="card-icon w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-book"></i>
        </div>
        <div>
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold text-[#1e293b]">Laporan Buku</h4>
                <span class="active-badge hidden text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <p class="text-[11px] text-[#64748b] mt-0.5">Koleksi & Eksemplar</p>
        </div>
    </div>

    <!-- 2. Laporan Anggota -->
    <div onclick="switchReportTab('anggota')" 
         data-tab="anggota"
         class="report-tab-card bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer border-2 border-transparent">
        <div class="card-icon w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-people"></i>
        </div>
        <div>
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold text-[#1e293b]">Laporan Anggota</h4>
                <span class="active-badge hidden text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <p class="text-[11px] text-[#64748b] mt-0.5">Keanggotaan & Status</p>
        </div>
    </div>

    <!-- 3. Laporan Peminjaman (Default Active) -->
    <div onclick="switchReportTab('peminjaman')" 
         data-tab="peminjaman"
         class="report-tab-card bg-white rounded-3xl p-5 glass-card transition-all flex flex-col justify-between relative cursor-pointer border-2 border-[#554fed] shadow-md shadow-indigo-500/10">
        <div class="flex items-center justify-between mb-3">
            <div class="card-icon w-10 h-10 rounded-2xl bg-[#554fed] text-white flex items-center justify-center text-lg">
                <i class="bi bi-journal-text"></i>
            </div>
            <span class="active-badge text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#1e293b]">Laporan Peminjaman</h4>
            <p class="text-[11px] text-[#64748b] mt-0.5">Riwayat Sirkulasi & Jatuh Tempo</p>
        </div>
    </div>

    <!-- 4. Laporan Pengembalian -->
    <div onclick="switchReportTab('pengembalian')" 
         data-tab="pengembalian"
         class="report-tab-card bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer border-2 border-transparent">
        <div class="card-icon w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-box-arrow-in-down-left"></i>
        </div>
        <div>
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold text-[#1e293b]">Laporan Pengembalian</h4>
                <span class="active-badge hidden text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <p class="text-[11px] text-[#64748b] mt-0.5">Pengembalian & Kondisi</p>
        </div>
    </div>

    <!-- 5. Laporan Denda -->
    <div onclick="switchReportTab('denda')" 
         data-tab="denda"
         class="report-tab-card bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer border-2 border-transparent">
        <div class="card-icon w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3">
            <i class="bi bi-cash-coin"></i>
        </div>
        <div>
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold text-[#1e293b]">Laporan Denda</h4>
                <span class="active-badge hidden text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
            </div>
            <p class="text-[11px] text-[#64748b] mt-0.5">Kas & Rekap Pembayaran</p>
        </div>
    </div>
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
            <div class="flex flex-wrap items-center gap-2" id="periodContainer">
                <button onclick="setPeriod('hari_ini', this)" class="period-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100 transition-all">Hari Ini</button>
                <button onclick="setPeriod('bulan_ini', this)" class="period-btn px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#554fed] text-white shadow-sm transition-all">Bulan Ini</button>
                <button onclick="setPeriod('3_bulan', this)" class="period-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100 transition-all">3 Bulan</button>
                <button onclick="setPeriod('tahun_ini', this)" class="period-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100 transition-all">Tahun Ini</button>
                <button onclick="setPeriod('kustom', this)" class="period-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100 transition-all">Kustom</button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
            <div class="md:col-span-4">
                <div class="flex items-center gap-2 bg-[#f8fafc] border border-gray-100 rounded-full px-4 py-2.5 text-xs text-gray-700">
                    <i class="bi bi-calendar text-gray-400"></i>
                    <span id="dateRangeDisplay">01 Okt 2026 – 31 Okt 2026</span>
                </div>
            </div>

            <div class="md:col-span-3">
                <label class="block text-[10px] text-gray-400 mb-1" id="filterStatusLabel">Status Peminjaman</label>
                <select id="filterStatusSelect" class="w-full bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                    <option value="all">Semua Status</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dipinjam">Dipinjam</option>
                    <option value="Terlambat">Terlambat</option>
                </select>
            </div>

            <div class="md:col-span-3">
                <label class="block text-[10px] text-gray-400 mb-1" id="filterKategoriLabel">Kategori Buku</label>
                <select id="filterKategoriSelect" class="w-full bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2.5 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                    <option value="all">Semua Kategori</option>
                    <option value="Novel">Novel</option>
                    <option value="Sastra">Sastra</option>
                    <option value="Pengembangan Diri">Pengembangan Diri</option>
                    <option value="Fiksi Sejarah">Fiksi Sejarah</option>
                    <option value="Sejarah & Sains">Sejarah & Sains</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <button onclick="applyReportFilter()" id="btnApplyFilter" class="w-full bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 px-4 rounded-full flex items-center justify-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-funnel"></i>
                    <span id="applyFilterText">Tampilkan Laporan</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- REPORT PREVIEW CARD -->
<div class="bg-white rounded-3xl p-6 glass-card">
    <div class="flex flex-wrap items-center justify-between gap-4 pb-4 mb-5 border-b border-gray-100">
        <div>
            <h3 class="text-base font-bold text-[#1e293b]" id="previewTitle">Pratinjau: Rekapitulasi Peminjaman Buku (Oktober 2026)</h3>
            <p class="text-xs text-[#64748b] mt-0.5" id="previewSubtitle">Menampilkan seluruh catatan riwayat transaksi aktif dan terselesaikan</p>
        </div>

        <div class="flex items-center gap-2">
            <button onclick="exportReportPDF()" class="bg-[#fef2f2] hover:bg-rose-100 border border-[#fee2e2] text-[#ef4444] text-xs font-bold px-4 py-2 rounded-full flex items-center gap-1.5 transition-colors">
                <i class="bi bi-file-earmark-pdf"></i>
                <span>Ekspor PDF</span>
            </button>
            <button onclick="exportReportExcel()" class="bg-[#ecfdf5] hover:bg-emerald-100 border border-[#d1fae5] text-[#10b981] text-xs font-bold px-4 py-2 rounded-full flex items-center gap-1.5 transition-colors">
                <i class="bi bi-file-earmark-excel"></i>
                <span>Ekspor Excel</span>
            </button>
        </div>
    </div>

    <!-- 4 SUMMARY STATS -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6" id="metricsContainer">
        <!-- Metric 1 -->
        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div id="metricIcon1" class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                <i class="bi bi-journal-check"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]" id="metricLabel1">Total Transaksi</p>
                <h4 class="text-xl font-extrabold text-[#1e293b]" id="metricVal1">214</h4>
            </div>
        </div>

        <!-- Metric 2 -->
        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div id="metricIcon2" class="w-10 h-10 rounded-xl bg-amber-100 text-[#f59e0b] flex items-center justify-center text-lg">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]" id="metricLabel2">Dipinjam</p>
                <h4 class="text-xl font-extrabold text-[#f59e0b]" id="metricVal2">87</h4>
            </div>
        </div>

        <!-- Metric 3 -->
        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div id="metricIcon3" class="w-10 h-10 rounded-xl bg-emerald-100 text-[#10b981] flex items-center justify-center text-lg">
                <i class="bi bi-check-circle"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]" id="metricLabel3">Kembali Tepat Waktu</p>
                <h4 class="text-xl font-extrabold text-[#10b981]" id="metricVal3">115</h4>
            </div>
        </div>

        <!-- Metric 4 -->
        <div class="bg-[#f8fafc] rounded-2xl p-4 flex items-center gap-3 border border-gray-100">
            <div id="metricIcon4" class="w-10 h-10 rounded-xl bg-rose-100 text-[#ef4444] flex items-center justify-center text-lg">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div>
                <p class="text-[11px] text-[#64748b]" id="metricLabel4">Terlambat</p>
                <h4 class="text-xl font-extrabold text-[#ef4444]" id="metricVal4">12</h4>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto min-h-[300px]">
        <table class="w-full text-left text-xs" id="reportTable">
            <thead id="reportTableHead">
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
            <tbody class="divide-y divide-gray-50" id="reportTableBody">
                <!-- Dynamically populated -->
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 text-xs text-[#64748b]">
        <p id="paginationInfo">Menampilkan <span class="font-semibold text-[#1e293b]">1–6</span> dari <span class="font-semibold text-[#1e293b]">214</span> baris data</p>
        <div class="flex items-center gap-1.5" id="paginationButtons">
            <button onclick="changePage(1)" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                <i class="bi bi-chevron-left text-[10px]"></i>
            </button>
            <button onclick="changePage(1)" class="page-num-btn w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
            <button onclick="changePage(2)" class="page-num-btn w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
            <button onclick="changePage(3)" class="page-num-btn w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
            <span class="px-1 text-gray-400">...</span>
            <button onclick="changePage(12)" class="page-num-btn w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">12</button>
            <button onclick="changePage(2)" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                <i class="bi bi-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>
</div>

<!-- MODAL SIMULASI EKSPOR PDF -->
<div id="modalExportPDF" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-rose-100 text-[#ef4444] flex items-center justify-center text-lg">
                    <i class="bi bi-file-earmark-pdf"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#1e293b]">Pratinjau Cetak / Ekspor PDF</h3>
                    <p class="text-[11px] text-[#64748b]">Format dokumen laporan resmi perpustakaan</p>
                </div>
            </div>
            <button onclick="closeExportPDFModal()" class="w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 flex items-center justify-center">
                <i class="bi bi-x text-lg"></i>
            </button>
        </div>

        <div class="bg-[#f8fafc] border border-gray-200 rounded-2xl p-4 text-xs space-y-3 mb-5 font-mono">
            <div class="text-center pb-2 border-b border-gray-200">
                <h4 class="font-bold text-sm text-[#1e293b]">PERPUSTAKAAN DIGITAL TERPADU</h4>
                <p class="text-[10px] text-gray-500 font-sans">Jl. Pendidikan No. 45, Jakarta Pusat • Telp: (021) 7890123</p>
            </div>
            <div class="flex justify-between text-[11px] font-sans">
                <span class="text-gray-500">Jenis Dokumen:</span>
                <span class="font-bold text-[#1e293b]" id="pdfDocType">Rekapitulasi Peminjaman</span>
            </div>
            <div class="flex justify-between text-[11px] font-sans">
                <span class="text-gray-500">Rentang Waktu:</span>
                <span class="font-bold text-[#1e293b]" id="pdfDocPeriod">01 Okt 2026 – 31 Okt 2026</span>
            </div>
            <div class="flex justify-between text-[11px] font-sans">
                <span class="text-gray-500">Dicetak Oleh:</span>
                <span class="font-bold text-[#554fed]">Admin Perpustakaan</span>
            </div>
            <div class="flex justify-between text-[11px] font-sans">
                <span class="text-gray-500">Format Output:</span>
                <span class="font-bold text-[#10b981]">A4 Landscape (PDF Terenkripsi)</span>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <button onclick="closeExportPDFModal()" class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50">
                Tutup
            </button>
            <button onclick="doPrintPDF()" class="bg-[#ef4444] hover:bg-rose-600 text-white text-xs font-bold px-6 py-2.5 rounded-full flex items-center gap-2 shadow-md shadow-rose-500/20">
                <i class="bi bi-printer"></i>
                <span>Unduh / Cetak Dokumen</span>
            </button>
        </div>
    </div>
</div>

<script>
// Master Data for the 5 Report Types
const reportDatabase = {
    peminjaman: {
        title: "Pratinjau: Rekapitulasi Peminjaman Buku",
        subtitle: "Menampilkan seluruh catatan riwayat transaksi aktif dan terselesaikan",
        statusLabel: "Status Peminjaman",
        statusOptions: ["Semua Status", "Selesai", "Dipinjam", "Terlambat"],
        kategoriLabel: "Kategori Buku",
        kategoriOptions: ["Semua Kategori", "Novel", "Sastra", "Pengembangan Diri", "Fiksi Sejarah", "Sejarah & Sains"],
        metrics: [
            { label: "Total Transaksi", val: "214", icon: "bi-journal-check", bg: "bg-blue-100", text: "text-blue-600" },
            { label: "Dipinjam", val: "87", icon: "bi-book", bg: "bg-amber-100", text: "text-[#f59e0b]" },
            { label: "Kembali Tepat Waktu", val: "115", icon: "bi-check-circle", bg: "bg-emerald-100", text: "text-[#10b981]" },
            { label: "Terlambat", val: "12", icon: "bi-exclamation-triangle", bg: "bg-rose-100", text: "text-[#ef4444]" }
        ],
        headers: ["Kode Transaksi", "Anggota", "Buku Dipinjam", "Tgl Pinjam", "Tgl Kembali / Jatuh Tempo", "Status Sirkulasi", "Petugas"],
        rows: [
            { kode: "PJ-001", inisial: "PA", anggota: "Putri Ayu Lestari", no: "AGT-0001", buku: "Laskar Pelangi", tgl_p: "02 Okt 2026", tgl_k: "09 Okt 2026", is_late: false, status: "Selesai", petugas: "Budi Santoso", cat: "Novel" },
            { kode: "PJ-002", inisial: "DP", anggota: "Dimas Pratama", no: "AGT-0002", buku: "Bumi Manusia", tgl_p: "05 Okt 2026", tgl_k: "12 Okt 2026", is_late: true, status: "Terlambat", petugas: "Siti Rahma", cat: "Sastra" },
            { kode: "PJ-003", inisial: "RW", anggota: "Rina Wulandari", no: "AGT-0003", buku: "Filosofi Teras", tgl_p: "10 Okt 2026", tgl_k: "17 Okt 2026", is_late: false, status: "Selesai", petugas: "Ahmad Fauzi", cat: "Pengembangan Diri" },
            { kode: "PJ-004", inisial: "FR", anggota: "Fajar Ramadhan", no: "AGT-0004", buku: "Laut Bercerita", tgl_p: "14 Okt 2026", tgl_k: "21 Okt 2026", is_late: false, status: "Dipinjam", petugas: "Budi Santoso", cat: "Fiksi Sejarah" },
            { kode: "PJ-005", inisial: "SN", anggota: "Siti Nurhaliza", no: "AGT-0005", buku: "Sapiens", tgl_p: "18 Okt 2026", tgl_k: "25 Okt 2026", is_late: false, status: "Dipinjam", petugas: "Maya Indriani", cat: "Sejarah & Sains" },
            { kode: "PJ-006", inisial: "BS", anggota: "Bima Sakti", no: "AGT-0006", buku: "Atomic Habits", tgl_p: "20 Okt 2026", tgl_k: "27 Okt 2026", is_late: false, status: "Selesai", petugas: "Siti Rahma", cat: "Pengembangan Diri" }
        ]
    },
    buku: {
        title: "Pratinjau: Rekapitulasi Koleksi Buku & Eksemplar",
        subtitle: "Menampilkan data katalog buku, total eksemplar fisik, dan ketersediaan di rak",
        statusLabel: "Status Ketersediaan",
        statusOptions: ["Semua Status", "Tersedia", "Dipinjam Penuh", "Dalam Perbaikan"],
        kategoriLabel: "Kategori Koleksi",
        kategoriOptions: ["Semua Kategori", "Novel", "Sains", "Filsafat", "Sejarah", "Teknologi"],
        metrics: [
            { label: "Total Judul Buku", val: "1.420", icon: "bi-book", bg: "bg-blue-100", text: "text-blue-600" },
            { label: "Total Eksemplar", val: "3.850", icon: "bi-collection", bg: "bg-purple-100", text: "text-[#554fed]" },
            { label: "Tersedia di Rak", val: "3.210", icon: "bi-check2-circle", bg: "bg-emerald-100", text: "text-[#10b981]" },
            { label: "Sedang Dipinjam", val: "640", icon: "bi-arrow-repeat", bg: "bg-amber-100", text: "text-[#f59e0b]" }
        ],
        headers: ["Kode ISBN", "Judul Buku", "Penulis & Penerbit", "Kategori", "Lokasi Rak", "Stok / Total", "Status Koleksi"],
        rows: [
            { col1: "978-602-06-3317-6", col2: "Atomic Habits", col3: "James Clear • Gramedia", col4: "Pengembangan Diri", col5: "Rak B-04", col6: "8 / 10 Eksemplar", status: "Tersedia" },
            { col1: "978-979-1227-89-6", col2: "Laskar Pelangi", col3: "Andrea Hirata • Bentang Pustaka", col4: "Novel", col5: "Rak A-01", col6: "5 / 5 Eksemplar", status: "Tersedia" },
            { col1: "978-979-973-12-3", col2: "Bumi Manusia", col3: "Pramoedya Ananta Toer • Hasta Mitra", col4: "Sastra", col5: "Rak A-03", col6: "0 / 4 Eksemplar", status: "Dipinjam Penuh" },
            { col1: "978-602-424-694-5", col2: "Laut Bercerita", col3: "Leila S. Chudori • KPG", col4: "Fiksi Sejarah", col5: "Rak A-02", col6: "3 / 6 Eksemplar", status: "Tersedia" },
            { col1: "978-602-03-3158-4", col2: "Filosofi Teras", col3: "Henry Manampiring • Kompas", col4: "Pengembangan Diri", col5: "Rak B-02", col6: "12 / 12 Eksemplar", status: "Tersedia" },
            { col1: "978-0-06-231609-7", col2: "Sapiens: Riwayat Singkat Umat Manusia", col3: "Yuval Noah Harari • KPG", col4: "Sejarah & Sains", col5: "Rak C-01", col6: "1 / 4 Eksemplar", status: "Tersedia" }
        ]
    },
    anggota: {
        title: "Pratinjau: Rekapitulasi Data Anggota Perpustakaan",
        subtitle: "Menampilkan data keanggotaan mahasiswa, dosen, staf, dan masa aktif kartu",
        statusLabel: "Status Keanggotaan",
        statusOptions: ["Semua Status", "Aktif", "Perlu Perpanjangan", "Nonaktif"],
        kategoriLabel: "Tipe Anggota",
        kategoriOptions: ["Semua Tipe", "Mahasiswa", "Dosen", "Karyawan / Staf", "Umum"],
        metrics: [
            { label: "Total Anggota", val: "854", icon: "bi-people", bg: "bg-blue-100", text: "text-blue-600" },
            { label: "Anggota Aktif", val: "780", icon: "bi-person-check", bg: "bg-emerald-100", text: "text-[#10b981]" },
            { label: "Anggota Baru (Bulan ini)", val: "45", icon: "bi-person-plus", bg: "bg-purple-100", text: "text-[#554fed]" },
            { label: "Masa Kartu Habis", val: "29", icon: "bi-person-x", bg: "bg-rose-100", text: "text-[#ef4444]" }
        ],
        headers: ["Nomor Anggota", "Nama Lengkap", "Tipe Keanggotaan", "Kontak WhatsApp", "Tgl Registrasi", "Buku Dipinjam", "Status"],
        rows: [
            { col1: "AGT-0001", col2: "Putri Ayu Lestari", col3: "Mahasiswa (S1 Teknik)", col4: "0812-3456-7890", col5: "12 Jan 2026", col6: "1 Buku Aktif", status: "Aktif" },
            { col1: "AGT-0002", col2: "Dimas Pratama", col3: "Mahasiswa (S1 Ekonomi)", col4: "0813-9876-5432", col5: "15 Jan 2026", col6: "2 Buku Aktif", status: "Aktif" },
            { col1: "AGT-0003", col2: "Rina Wulandari", col3: "Dosen Pengajar", col4: "0857-1122-3344", col5: "02 Feb 2026", col6: "0 Buku", status: "Aktif" },
            { col1: "AGT-0004", col2: "Fajar Ramadhan", col3: "Mahasiswa (S1 Hukum)", col4: "0819-5566-7788", col5: "20 Feb 2026", col6: "1 Buku Aktif", status: "Aktif" },
            { col1: "AGT-0005", col2: "Siti Nurhaliza", col3: "Mahasiswa (S1 Sastra)", col4: "0821-4433-2211", col5: "10 Mar 2026", col6: "1 Buku Aktif", status: "Aktif" },
            { col1: "AGT-0006", col2: "Bima Sakti", col3: "Staf Karyawan", col4: "0812-7788-9900", col5: "01 Apr 2026", col6: "0 Buku", status: "Aktif" }
        ]
    },
    pengembalian: {
        title: "Pratinjau: Rekapitulasi Pengembalian Buku",
        subtitle: "Menampilkan transaksi pengembalian, pengecekan fisik buku, dan ketepatan waktu",
        statusLabel: "Kondisi Fisik Buku",
        statusOptions: ["Semua Kondisi", "Baik", "Rusak Ringan", "Hilang"],
        kategoriLabel: "Status Keterlambatan",
        kategoriOptions: ["Semua Status", "Tepat Waktu", "Terlambat", "Dengan Denda"],
        metrics: [
            { label: "Total Pengembalian", val: "127", icon: "bi-box-arrow-in-down-left", bg: "bg-blue-100", text: "text-blue-600" },
            { label: "Kondisi Baik", val: "118", icon: "bi-shield-check", bg: "bg-emerald-100", text: "text-[#10b981]" },
            { label: "Rusak Ringan", val: "7", icon: "bi-wrench-adjustable", bg: "bg-amber-100", text: "text-[#f59e0b]" },
            { label: "Buku Hilang / Ganti", val: "2", icon: "bi-exclamation-octagon", bg: "bg-rose-100", text: "text-[#ef4444]" }
        ],
        headers: ["Kode Kembali", "Peminjam", "Judul Buku", "Tgl Dikembalikan", "Kondisi Fisik", "Denda Terbit", "Petugas Pemeriksa"],
        rows: [
            { col1: "KB-089", col2: "Putri Ayu Lestari", col3: "Laskar Pelangi", col4: "09 Okt 2026", col5: "Sempurna / Baik", col6: "Rp 0 (Nihil)", status: "Baik" },
            { col1: "KB-090", col2: "Rina Wulandari", col3: "Filosofi Teras", col4: "17 Okt 2026", col5: "Sempurna / Baik", col6: "Rp 0 (Nihil)", status: "Baik" },
            { col1: "KB-091", col2: "Dimas Pratama", col3: "Bumi Manusia", col4: "19 Okt 2026", col5: "Halaman Robek", col6: "Rp 55.000", status: "Rusak Ringan" },
            { col1: "KB-092", col2: "Bima Sakti", col3: "Atomic Habits", col4: "27 Okt 2026", col5: "Sempurna / Baik", col6: "Rp 0 (Nihil)", status: "Baik" },
            { col1: "KB-093", col2: "Hendra Wijaya", col3: "Cantik Itu Luka", col4: "28 Okt 2026", col5: "Sempurna / Baik", col6: "Rp 0 (Nihil)", status: "Baik" },
            { col1: "KB-094", col2: "Nabila Zahra", col3: "Gadis Kretek", col4: "30 Okt 2026", col5: "Hilang Total", col6: "Rp 100.000", status: "Hilang" }
        ]
    },
    denda: {
        title: "Pratinjau: Rekapitulasi Kas & Pembayaran Denda",
        subtitle: "Menampilkan buku kas penerimaan denda keterlambatan, kerusakan, dan penggantian buku",
        statusLabel: "Status Pelunasan",
        statusOptions: ["Semua Status", "Lunas", "Belum Lunas / Tertunggak"],
        kategoriLabel: "Metode Pembayaran",
        kategoriOptions: ["Semua Metode", "Tunai / Cash", "QRIS Dinamis"],
        metrics: [
            { label: "Total Kas Denda", val: "Rp 485.000", icon: "bi-wallet2", bg: "bg-purple-100", text: "text-[#554fed]" },
            { label: "Denda Terbayar", val: "Rp 390.000", icon: "bi-cash-coin", bg: "bg-emerald-100", text: "text-[#10b981]" },
            { label: "Denda Tertunggak", val: "Rp 95.000", icon: "bi-hourglass-split", bg: "bg-amber-100", text: "text-[#f59e0b]" },
            { label: "Total Pelanggaran", val: "34 Kasus", icon: "bi-receipt", bg: "bg-rose-100", text: "text-[#ef4444]" }
        ],
        headers: ["No Kuitansi", "Anggota", "Jenis Pelanggaran", "Nominal Denda", "Metode Bayar", "Status Pelunasan", "Petugas Kasir"],
        rows: [
            { col1: "DND-2026-081", col2: "Dimas Pratama", col3: "Keterlambatan 5 Hari + Kerusakan", col4: "Rp 55.000", col5: "QRIS Dinamis", col6: "Lunas", status: "Lunas" },
            { col1: "DND-2026-082", col2: "Nabila Zahra", col3: "Penggantian Buku Hilang", col4: "Rp 100.000", col5: "Tunai / Cash", col6: "Lunas", status: "Lunas" },
            { col1: "DND-2026-083", col2: "Fajar Ramadhan", col3: "Keterlambatan 3 Hari", col4: "Rp 3.000", col5: "Tunai / Cash", col6: "Lunas", status: "Lunas" },
            { col1: "DND-2026-084", col2: "Aldi Taher", col3: "Keterlambatan 7 Hari", col4: "Rp 7.000", col5: "Belum Bayar", col6: "Tertunggak", status: "Tertunggak" },
            { col1: "DND-2026-085", col2: "Eko Prasetyo", col3: "Kerusakan Sampul Buku", col4: "Rp 50.000", col5: "QRIS Dinamis", col6: "Lunas", status: "Lunas" },
            { col1: "DND-2026-086", col2: "Rahmat Hidayat", col3: "Keterlambatan 15 Hari", col4: "Rp 15.000", col5: "Belum Bayar", col6: "Tertunggak", status: "Tertunggak" }
        ]
    }
};

let currentTab = 'peminjaman';
let currentPeriod = 'bulan_ini';

// Initial render
document.addEventListener('DOMContentLoaded', () => {
    renderReportView('peminjaman');
});

// Switch Report Tab
function switchReportTab(tabKey) {
    currentTab = tabKey;

    // Update active tab card UI
    document.querySelectorAll('.report-tab-card').forEach(card => {
        const isTarget = card.dataset.tab === tabKey;
        const icon = card.querySelector('.card-icon');
        const badge = card.querySelector('.active-badge');

        if (isTarget) {
            card.className = "report-tab-card bg-white rounded-3xl p-5 glass-card transition-all flex flex-col justify-between relative cursor-pointer border-2 border-[#554fed] shadow-md shadow-indigo-500/10";
            if (icon) {
                icon.className = "card-icon w-10 h-10 rounded-2xl bg-[#554fed] text-white flex items-center justify-center text-lg";
            }
            if (badge) badge.classList.remove('hidden');
        } else {
            card.className = "report-tab-card bg-white rounded-3xl p-5 glass-card hover:shadow-md transition-all flex flex-col justify-between group cursor-pointer border-2 border-transparent";
            if (icon) {
                icon.className = "card-icon w-10 h-10 rounded-2xl bg-gray-50 text-gray-500 group-hover:bg-[#eff1fe] group-hover:text-[#554fed] flex items-center justify-center text-lg transition-colors mb-3";
            }
            if (badge) badge.classList.add('hidden');
        }
    });

    renderReportView(tabKey);
    if (window.showToast) {
        window.showToast(`Laporan dialihkan ke ${tabKey.toUpperCase()}`, 'info');
    }
}

// Render report data into table and stats
function renderReportView(tabKey) {
    const data = reportDatabase[tabKey];
    if (!data) return;

    // Update Header
    document.getElementById('previewTitle').innerText = `${data.title} (${getPeriodString()})`;
    document.getElementById('previewSubtitle').innerText = data.subtitle;

    // Update Filter labels and dropdown options
    document.getElementById('filterStatusLabel').innerText = data.statusLabel;
    const statusSelect = document.getElementById('filterStatusSelect');
    statusSelect.innerHTML = data.statusOptions.map((opt, i) => `<option value="${i === 0 ? 'all' : opt}">${opt}</option>`).join('');

    document.getElementById('filterKategoriLabel').innerText = data.kategoriLabel;
    const kategoriSelect = document.getElementById('filterKategoriSelect');
    kategoriSelect.innerHTML = data.kategoriOptions.map((opt, i) => `<option value="${i === 0 ? 'all' : opt}">${opt}</option>`).join('');

    // Update Metrics
    data.metrics.forEach((m, idx) => {
        const i = idx + 1;
        document.getElementById(`metricLabel${i}`).innerText = m.label;
        document.getElementById(`metricVal${i}`).innerText = m.val;
        document.getElementById(`metricVal${i}`).className = `text-xl font-extrabold ${m.text.includes('blue') ? 'text-[#1e293b]' : m.text}`;
        
        const iconDiv = document.getElementById(`metricIcon${i}`);
        iconDiv.className = `w-10 h-10 rounded-xl ${m.bg} ${m.text} flex items-center justify-center text-lg`;
        iconDiv.innerHTML = `<i class="bi ${m.icon}"></i>`;
    });

    // Update Table Headers
    const thead = document.getElementById('reportTableHead');
    thead.innerHTML = `
        <tr class="text-[#64748b] font-semibold border-b border-gray-100 uppercase text-[11px]">
            ${data.headers.map((h, i) => `<th class="pb-3.5 ${i === 0 ? 'pl-2' : ''} ${i === data.headers.length - 2 ? 'text-center' : ''}">${h}</th>`).join('')}
        </tr>
    `;

    // Update Table Rows
    renderTableRows(data.rows, tabKey);

    // Update Pagination info
    document.getElementById('paginationInfo').innerHTML = `Menampilkan <span class="font-semibold text-[#1e293b]">1–${data.rows.length}</span> dari <span class="font-semibold text-[#1e293b]">${data.metrics[0].val.replace(/\D/g, '') || '100+'}</span> baris data`;
}

function renderTableRows(rows, tabKey) {
    const tbody = document.getElementById('reportTableBody');
    tbody.innerHTML = '';

    if (tabKey === 'peminjaman') {
        rows.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50/70 transition-colors";
            tr.innerHTML = `
                <td class="py-4 pl-2 font-bold text-[#554fed] font-mono">${r.kode}</td>
                <td class="py-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-slate-200 text-slate-700 flex items-center justify-center font-bold text-[10px]">
                            ${r.inisial}
                        </div>
                        <div>
                            <p class="font-bold text-[#1e293b] leading-tight">${r.anggota}</p>
                            <p class="text-[10px] text-[#64748b] font-mono">${r.no}</p>
                        </div>
                    </div>
                </td>
                <td class="py-4">
                    <div class="flex items-center gap-2">
                        <i class="bi bi-book text-[#554fed]"></i>
                        <span class="font-medium text-[#1e293b]">${r.buku}</span>
                    </div>
                </td>
                <td class="py-4 text-[#64748b]">${r.tgl_p}</td>
                <td class="py-4">
                    <span class="${r.is_late ? 'text-[#ef4444] font-bold' : 'text-[#1e293b] font-medium'}">${r.tgl_k}</span>
                </td>
                <td class="py-4 text-center">
                    ${getStatusBadge(r.status)}
                </td>
                <td class="py-4 text-[#64748b] font-medium">${r.petugas}</td>
            `;
            tbody.appendChild(tr);
        });
    } else {
        rows.forEach(r => {
            const tr = document.createElement('tr');
            tr.className = "hover:bg-slate-50/70 transition-colors";
            tr.innerHTML = `
                <td class="py-4 pl-2 font-bold text-[#554fed] font-mono">${r.col1}</td>
                <td class="py-4 font-bold text-[#1e293b]">${r.col2}</td>
                <td class="py-4 text-[#64748b] font-medium">${r.col3}</td>
                <td class="py-4 text-[#64748b]">${r.col4}</td>
                <td class="py-4 font-medium text-[#1e293b]">${r.col5}</td>
                <td class="py-4 text-center">${getStatusBadge(r.status, r.col6)}</td>
                <td class="py-4 text-[#64748b] font-medium">Petugas Terdaftar</td>
            `;
            tbody.appendChild(tr);
        });
    }
}

function getStatusBadge(status, extraText) {
    if (status === 'Selesai' || status === 'Tersedia' || status === 'Aktif' || status === 'Baik' || status === 'Lunas') {
        return `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> ${extraText || status}
        </span>`;
    } else if (status === 'Dipinjam' || status === 'Rusak Ringan' || status === 'Perlu Perpanjangan') {
        return `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span> ${extraText || status}
        </span>`;
    } else {
        return `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span> ${extraText || status}
        </span>`;
    }
}

// Period handling
function setPeriod(key, btn) {
    currentPeriod = key;
    document.querySelectorAll('.period-btn').forEach(b => {
        b.className = "period-btn px-3.5 py-1.5 rounded-full text-xs font-medium bg-[#f8fafc] text-gray-600 hover:bg-gray-100 transition-all";
    });
    btn.className = "period-btn px-3.5 py-1.5 rounded-full text-xs font-bold bg-[#554fed] text-white shadow-sm transition-all";

    const display = document.getElementById('dateRangeDisplay');
    if (key === 'hari_ini') {
        display.innerText = "21 Nov 2026 (Hari ini)";
    } else if (key === 'bulan_ini') {
        display.innerText = "01 Okt 2026 – 31 Okt 2026";
    } else if (key === '3_bulan') {
        display.innerText = "01 Agu 2026 – 31 Okt 2026";
    } else if (key === 'tahun_ini') {
        display.innerText = "01 Jan 2026 – 31 Des 2026";
    } else {
        const custom = prompt("Masukkan rentang tanggal kustom (cth: 01 Sep 2026 - 15 Okt 2026):", "01 Sep 2026 – 15 Okt 2026");
        if (custom) display.innerText = custom;
    }

    // Refresh view title
    renderReportView(currentTab);
    if (window.showToast) {
        window.showToast(`Periode laporan diset ke: ${display.innerText}`, 'info');
    }
}

function getPeriodString() {
    return document.getElementById('dateRangeDisplay') ? document.getElementById('dateRangeDisplay').innerText : 'Oktober 2026';
}

// Filter button with loading simulation
function applyReportFilter() {
    const btn = document.getElementById('btnApplyFilter');
    const txt = document.getElementById('applyFilterText');
    const originalText = txt.innerText;

    btn.disabled = true;
    txt.innerText = 'Memuat...';

    setTimeout(() => {
        btn.disabled = false;
        txt.innerText = originalText;
        renderReportView(currentTab);
        if (window.showToast) {
            window.showToast('Laporan berhasil disaring berdasarkan parameter pilihan.', 'success');
        }
    }, 400);
}

// PDF Export Modal
function exportReportPDF() {
    document.getElementById('pdfDocType').innerText = reportDatabase[currentTab].title.replace('Pratinjau: ', '');
    document.getElementById('pdfDocPeriod').innerText = getPeriodString();
    const modal = document.getElementById('modalExportPDF');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeExportPDFModal() {
    const modal = document.getElementById('modalExportPDF');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function doPrintPDF() {
    closeExportPDFModal();
    if (window.showToast) {
        window.showToast('Menghasilkan berkas PDF & membuka jendela cetak...', 'info');
    }
    setTimeout(() => {
        window.print();
    }, 500);
}

// Excel Export (Real CSV Download simulation)
function exportReportExcel() {
    const data = reportDatabase[currentTab];
    let csv = data.headers.join(',') + '\n';
    
    if (currentTab === 'peminjaman') {
        data.rows.forEach(r => {
            csv += `"${r.kode}","${r.anggota}","${r.buku}","${r.tgl_p}","${r.tgl_k}","${r.status}","${r.petugas}"\n`;
        });
    } else {
        data.rows.forEach(r => {
            csv += `"${r.col1}","${r.col2}","${r.col3}","${r.col4}","${r.col5}","${r.status}","Petugas Terdaftar"\n`;
        });
    }

    const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.setAttribute('download', `Laporan_${currentTab}_${new Date().toISOString().slice(0, 10)}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    if (window.showToast) {
        window.showToast(`Laporan ${currentTab.toUpperCase()} berhasil diekspor ke Excel / CSV!`, 'success');
    }
}

// Interactive Pagination
function changePage(num) {
    document.querySelectorAll('.page-num-btn').forEach(btn => {
        if (btn.innerText == num) {
            btn.className = "page-num-btn w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm";
        } else {
            btn.className = "page-num-btn w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium";
        }
    });
    if (window.showToast) {
        window.showToast(`Menampilkan halaman ${num}`, 'info');
    }
}
</script>
@endsection