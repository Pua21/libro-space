@extends('layouts.app')

@section('title', 'Pengaturan Sistem')

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

<!-- PAGE TITLE & STATUS BADGE -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Pengaturan Sistem</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Atur aturan sirkulasi peminjaman, batasan buku, dan ketentuan denda perpustakaan</p>
    </div>

    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
        <span class="w-2 h-2 rounded-full bg-[#10b981]"></span>
        Status Konfigurasi: Aktif & Tersinkronisasi
    </span>
</div>

<!-- NOTIFICATION ALERT BANNER -->
<div class="bg-[#ecfdf5] border border-[#a7f3d0] rounded-3xl p-4 flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <div class="w-8 h-8 rounded-full bg-[#10b981] text-white flex items-center justify-center text-sm shadow-sm">
            <i class="bi bi-check-lg"></i>
        </div>
        <div>
            <h4 class="text-xs font-bold text-[#065f46]">Pembaruan Berhasil Diaktivasi</h4>
            <p class="text-[11px] text-[#047857]">Pengaturan berhasil disimpan dan langsung diterapkan ke seluruh sistem peminjaman aktif.</p>
        </div>
    </div>
    <button class="text-xs font-semibold text-[#065f46] hover:underline">Tutup</button>
</div>

<!-- SETTINGS CARDS (2 COLUMNS) -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    
    <!-- LEFT CARD: Aturan Peminjaman & Sirkulasi -->
    <div class="bg-white rounded-3xl p-6 glass-card space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-book"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#1e293b]">Aturan Peminjaman & Sirkulasi</h3>
                    <p class="text-[11px] text-[#64748b]">Konfigurasi batas sirkulasi fisik buku koleksi</p>
                </div>
            </div>
            <span class="text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2.5 py-1 rounded-full">4 Parameter</span>
        </div>

        <!-- Param 1: Lama Pinjam Default -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Lama Pinjam Default</span>
                <span class="text-[10px] font-semibold text-[#554fed] bg-[#eef2ff] px-2.5 py-0.5 rounded-full">Standar</span>
            </div>
            <div class="flex items-center gap-3 mb-1.5">
                <div class="flex items-center bg-[#f8fafc] border border-gray-200 rounded-xl p-1">
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">-</button>
                    <span class="w-12 text-center text-sm font-bold text-[#1e293b]">{{ $settings['lama_pinjam'] }}</span>
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">+</button>
                </div>
                <span class="text-xs font-bold text-[#554fed] bg-[#eff1fe] px-3 py-1.5 rounded-xl">7 Hari</span>
            </div>
            <p class="text-[11px] text-[#64748b]">Durasi standar peminjaman buku sebelum terhitung masa denda</p>
        </div>

        <!-- Param 2: Batas Maksimal Buku per Anggota -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Batas Maksimal Buku per Anggota</span>
                <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full">Per Akun</span>
            </div>
            <div class="flex items-center gap-3 mb-1.5">
                <div class="flex items-center bg-[#f8fafc] border border-gray-200 rounded-xl p-1">
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">-</button>
                    <span class="w-12 text-center text-sm font-bold text-[#1e293b]">{{ $settings['max_buku'] }}</span>
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">+</button>
                </div>
                <span class="text-xs font-bold text-[#554fed] bg-[#eff1fe] px-3 py-1.5 rounded-xl">3 Buku</span>
            </div>
            <p class="text-[11px] text-[#64748b]">Jumlah maksimal buku aktif yang dapat dipinjam secara bersamaan</p>
        </div>

        <!-- Param 3: Batas Perpanjangan Mandiri -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Batas Perpanjangan Mandiri</span>
                <span class="text-[10px] font-semibold text-gray-500 bg-gray-100 px-2.5 py-0.5 rounded-full">Online / OPAC</span>
            </div>
            <div class="flex items-center gap-3 mb-1.5">
                <div class="flex items-center bg-[#f8fafc] border border-gray-200 rounded-xl p-1">
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">-</button>
                    <span class="w-12 text-center text-sm font-bold text-[#1e293b]">{{ $settings['max_perpanjangan'] }}</span>
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">+</button>
                </div>
                <span class="text-xs font-bold text-[#554fed] bg-[#eff1fe] px-3 py-1.5 rounded-xl">2 Kali</span>
            </div>
            <p class="text-[11px] text-[#64748b]">Jumlah toleransi perpanjangan waktu sebelum buku wajib dikembalikan ke perpustakaan</p>
        </div>

        <!-- Param 4: Masa Tenggang (Grace Period) -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Masa Tenggang Pengembalian (Grace Period)</span>
                <span class="text-[10px] font-semibold text-[#f59e0b] bg-[#fffbeb] px-2.5 py-0.5 rounded-full">Toleransi</span>
            </div>
            <div class="flex items-center gap-3 mb-1.5">
                <div class="flex items-center bg-[#f8fafc] border border-gray-200 rounded-xl p-1">
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">-</button>
                    <span class="w-12 text-center text-sm font-bold text-[#1e293b]">{{ $settings['grace_period'] }}</span>
                    <button class="w-8 h-8 rounded-lg bg-white shadow-sm flex items-center justify-center text-gray-600 hover:bg-gray-50 text-xs font-bold">+</button>
                </div>
                <span class="text-xs font-bold text-[#554fed] bg-[#eff1fe] px-3 py-1.5 rounded-xl">1 Hari</span>
            </div>
            <p class="text-[11px] text-[#64748b]">Toleransi keterlambatan tanpa dikenakan denda keterlambatan</p>
        </div>

        <!-- Toggle: Allow loan with outstanding fine -->
        <div class="p-4 rounded-2xl bg-[#f8fafc] border border-gray-100 flex items-center justify-between">
            <div>
                <h4 class="text-xs font-bold text-[#1e293b]">Izinkan Peminjaman Saat Masih Ada Tunggakan Denda</h4>
                <p class="text-[11px] text-[#64748b] mt-0.5">Status: Nonaktif/Off</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#554fed]"></div>
            </label>
        </div>
    </div>

    <!-- RIGHT CARD: Aturan & Tarif Denda -->
    <div class="bg-white rounded-3xl p-6 glass-card space-y-6">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#fef2f2] text-[#ef4444] flex items-center justify-center text-lg">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-[#1e293b]">Aturan & Tarif Denda</h3>
                    <p class="text-[11px] text-[#64748b]">Ketentuan sanksi keuangan dan kompensasi koleksi</p>
                </div>
            </div>
            <span class="text-[10px] font-bold text-[#ef4444] bg-[#fef2f2] px-2.5 py-1 rounded-full">Keuangan</span>
        </div>

        <!-- Denda Keterlambatan -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Tarif Denda Keterlambatan</span>
                <span class="text-[11px] text-gray-500 font-medium">Per Hari / Judul</span>
            </div>
            <div class="relative mb-1.5">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-500">Rp</span>
                <input type="text" value="{{ $settings['denda_harian'] }}" 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-10 pr-24 py-2.5 text-xs font-bold text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs text-gray-400">/ Hari / Buku</span>
            </div>
            <p class="text-[11px] text-[#64748b]">Dihitung otomatis per hari kalender setelah batas jatuh tempo terlewati</p>
        </div>

        <!-- Denda Rusak Ringan/Sedang -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Denda Kerusakan Buku Ringan / Sedang</span>
                <span class="text-[10px] font-semibold text-[#f59e0b] bg-[#fffbeb] px-2.5 py-0.5 rounded-full">Perbaikan</span>
            </div>
            <div class="relative mb-1.5">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-500">Rp</span>
                <input type="text" value="{{ $settings['denda_rusak_ringan'] }}" 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-bold text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <p class="text-[11px] text-[#64748b]">Kompensasi perbaikan fisik halaman, jilid, atau sampul buku yang rusak</p>
        </div>

        <!-- Denda Hilang / Rusak Berat -->
        <div class="pb-5 border-b border-gray-100">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#1e293b]">Denda Buku Hilang / Rusak Berat</span>
                <label class="flex items-center gap-1.5 text-[11px] text-gray-500 cursor-pointer">
                    <input type="radio" name="denda_hilang_type" class="text-[#554fed]">
                    <span>Atau 100% Harga Buku Asli</span>
                </label>
            </div>
            <div class="relative mb-1.5">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-500">Rp</span>
                <input type="text" value="{{ $settings['denda_hilang'] }}" 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-xs font-bold text-[#1e293b] focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <p class="text-[11px] text-[#64748b]">Penggantian biaya cetak ulang dan pengadaan kembali koleksi perpustakaan</p>
        </div>

        <!-- Notification WA/Email Toggle Card -->
        <div class="p-4 rounded-2xl bg-[#f0fdfa] border border-[#ccfbf1] flex items-center justify-between">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-[#0d9488] text-white flex items-center justify-center text-sm shadow-sm mt-0.5">
                    <i class="bi bi-bell-fill"></i>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-[#134e4a]">Kirim Notifikasi Pengingat Denda via WhatsApp/Email Otomatis</h4>
                    <p class="text-[11px] text-[#0d9488] font-semibold mt-0.5">Status: Aktif/On (Terkoneksi Gateway)</p>
                </div>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" checked class="sr-only peer">
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0d9488]"></div>
            </label>
        </div>
    </div>

</div>

<!-- BOTTOM STICKY ACTION BAR -->
<div class="bg-white rounded-3xl p-4 lg:px-6 glass-card flex flex-wrap items-center justify-between gap-4">
    <div class="flex items-center gap-3 text-xs text-[#64748b]">
        <div class="w-8 h-8 rounded-xl bg-gray-100 flex items-center justify-center text-gray-500">
            <i class="bi bi-arrow-repeat"></i>
        </div>
        <div>
            <p class="font-bold text-[#1e293b]">Perubahan Konfigurasi Global</p>
            <p class="text-[11px]">Terakhir diperbarui: {{ $settings['terakhir_update'] }}</p>
        </div>
    </div>

    <div class="flex items-center gap-2">
        <button class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all">
            Batalkan
        </button>
        <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2.5 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-floppy"></i>
            <span>Simpan Perubahan</span>
        </button>
    </div>
</div>
@endsection
