@extends('layouts.app')

@section('title', 'Profil Pengguna')

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
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Profil Pengguna</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Kelola informasi identitas, foto profil, dan keamanan kredensial akun administrator</p>
    </div>

    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
        <span class="w-2 h-2 rounded-full bg-[#10b981]"></span>
        Sesi Aktif Terverifikasi
    </span>
</div>

<!-- MAIN GRID (4 cols left, 8 cols right) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    
    <!-- LEFT COLUMN (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- Profile Card -->
        <div class="bg-white rounded-3xl p-6 glass-card text-center">
            <!-- Big Avatar with Camera Button -->
            <div class="relative inline-block mx-auto mb-4">
                <img src="{{ asset($profil['avatar']) }}" 
                     alt="{{ $profil['nama'] }}" 
                     class="w-28 h-28 rounded-full object-cover ring-4 ring-indigo-50 shadow-md">
                <button class="absolute bottom-0 right-0 bg-[#554fed] hover:bg-[#4338ca] text-white text-[11px] font-semibold px-3 py-1 rounded-full flex items-center gap-1 shadow-md transition-all">
                    <i class="bi bi-camera"></i>
                    <span>Ubah Foto</span>
                </button>
            </div>

            <h3 class="text-base font-bold text-[#1e293b]">{{ $profil['nama'] }}</h3>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] mt-2 mb-2">
                <i class="bi bi-shield-check"></i>
                <span>{{ $profil['role'] }}</span>
            </div>
            <p class="text-xs text-[#64748b] font-mono">{{ $profil['username'] }}</p>
            <p class="text-xs text-[#64748b]">{{ $profil['email'] }}</p>

            <!-- Details List -->
            <div class="text-left text-xs space-y-2.5 pt-5 mt-5 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b] flex items-center gap-1.5">
                        <i class="bi bi-person-vcard text-gray-400"></i> NIP / ID Staf
                    </span>
                    <span class="font-bold text-[#1e293b] font-mono">{{ $profil['nip'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b] flex items-center gap-1.5">
                        <i class="bi bi-calendar text-gray-400"></i> Bergabung sejak
                    </span>
                    <span class="font-medium text-[#1e293b]">{{ $profil['bergabung'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b] flex items-center gap-1.5">
                        <i class="bi bi-clock-history text-gray-400"></i> Terakhir login
                    </span>
                    <span class="font-medium text-[#1e293b]">{{ $profil['terakhir_login'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b] flex items-center gap-1.5">
                        <i class="bi bi-key text-gray-400"></i> Hak Akses
                    </span>
                    <a href="javascript:void(0)" class="font-semibold text-[#554fed] hover:underline">{{ $profil['hak_akses'] }}</a>
                </div>
            </div>

            <!-- Status Pill Bottom -->
            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="w-full py-2 rounded-xl bg-[#ecfdf5] border border-[#d1fae5] text-xs font-semibold text-[#10b981] flex items-center justify-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-[#10b981]"></span>
                    {{ $profil['status'] }}
                </div>
            </div>
        </div>

        <!-- Keamanan & Sesi Card -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-sm">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div>
                    <h3 class="text-xs font-bold text-[#1e293b]">Aktivitas Keamanan</h3>
                    <p class="text-[10px] text-[#64748b]">Status proteksi multi-faktor</p>
                </div>
            </div>

            <!-- 2FA Box -->
            <div class="p-3.5 rounded-2xl bg-[#f8fafc] border border-gray-100 flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-xs font-bold text-[#1e293b]">Autentikasi Dua Langkah (2FA)</h4>
                    <p class="text-[11px] text-[#64748b] mt-0.5">WhatsApp OTP / Authenticator</p>
                </div>
                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-[#10b981] bg-[#ecfdf5] px-2 py-0.5 rounded-full border border-[#d1fae5]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Aktif
                </span>
            </div>

            <!-- Active Sessions List -->
            <div class="space-y-3">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Perangkat & Sesi Masuk</p>

                <!-- Session 1 -->
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#f8fafc] border border-gray-100">
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-laptop text-base text-gray-500"></i>
                        <div>
                            <p class="text-xs font-bold text-[#1e293b]">Desktop Windows • Chrome</p>
                            <p class="text-[10px] text-[#64748b]">Sesi ini • IP 192.168.1.10</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-semibold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Aktif</span>
                </div>

                <!-- Session 2 -->
                <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#f8fafc] border border-gray-100">
                    <div class="flex items-center gap-2.5">
                        <i class="bi bi-phone text-base text-gray-500"></i>
                        <div>
                            <p class="text-xs font-bold text-[#1e293b]">Mobile Android • Edge</p>
                            <p class="text-[10px] text-[#64748b]">2 hari lalu • Jakarta</p>
                        </div>
                    </div>
                    <i class="bi bi-clock-history text-xs text-gray-400"></i>
                </div>
            </div>

            <!-- Logout button -->
            <button class="w-full mt-4 bg-[#fef2f2] hover:bg-rose-100 border border-[#fee2e2] text-[#ef4444] text-xs font-bold py-2.5 rounded-xl flex items-center justify-center gap-1.5 transition-colors">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluarkan Sesi Lain</span>
            </button>
        </div>

    </div>

    <!-- RIGHT COLUMN (8 cols) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Informasi Pribadi Card -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-bold text-[#1e293b]">Informasi Pribadi</h3>
                    <p class="text-xs text-[#64748b] mt-0.5">Perbarui informasi dasar profil akun Anda</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-[#f8fafc] text-gray-500 flex items-center justify-center text-sm">
                    <i class="bi bi-pencil-square"></i>
                </div>
            </div>

            <!-- Form fields -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs mb-5">
                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Nama Lengkap</label>
                    <input type="text" value="{{ $profil['nama'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="text-[11px] font-bold text-[#1e293b]">Username</label>
                        <span class="text-[10px] text-gray-400 flex items-center gap-1"><i class="bi bi-lock"></i> Permanen</span>
                    </div>
                    <div class="relative">
                        <input type="text" value="{{ $profil['username'] }}" readonly 
                               class="w-full bg-[#f1f5f9] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-gray-500 font-mono pr-9 cursor-not-allowed">
                        <i class="bi bi-lock absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Alamat Email Kedinasan</label>
                    <input type="email" value="{{ $profil['email'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Nomor WhatsApp / Kontak</label>
                    <input type="text" value="{{ $profil['kontak'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Jabatan Struktural</label>
                    <input type="text" value="{{ $profil['jabatan'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Divisi / Unit Kerja</label>
                    <input type="text" value="{{ $profil['divisi'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                <button class="px-5 py-2 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-floppy"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </div>

        <!-- Keamanan Password Card -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-bold text-[#1e293b]">Keamanan Password</h3>
                    <p class="text-xs text-[#64748b] mt-0.5">Pastikan menggunakan kata sandi kombinasi kuat minimal 8 karakter</p>
                </div>
                <div class="w-8 h-8 rounded-xl bg-[#f8fafc] text-gray-500 flex items-center justify-center text-sm">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>

            <!-- Password form -->
            <div class="space-y-4 text-xs mb-5">
                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" value="AdminSecretLibrary2024!" 
                               class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-mono pr-10 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                        <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" value="Perpustakaan2025#Utama" 
                                   class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-mono pr-10 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" value="Perpustakaan2025#Utama" 
                                   class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-mono pr-10 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password strength indicator -->
                <div class="bg-[#f8fafc] rounded-2xl p-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-[#1e293b]">Kekuatan Sandi:</span>
                        <span class="text-[11px] font-bold text-[#10b981] flex items-center gap-1">
                            <i class="bi bi-shield-check"></i> Sangat Kuat
                        </span>
                    </div>

                    <!-- 4 strength bars -->
                    <div class="grid grid-cols-4 gap-2 mb-3">
                        <div class="h-1.5 rounded-full bg-[#10b981]"></div>
                        <div class="h-1.5 rounded-full bg-[#10b981]"></div>
                        <div class="h-1.5 rounded-full bg-[#10b981]"></div>
                        <div class="h-1.5 rounded-full bg-[#10b981]"></div>
                    </div>

                    <!-- Requirements checklist -->
                    <div class="flex flex-wrap items-center gap-4 text-[10px] text-gray-600 font-medium">
                        <span class="flex items-center gap-1 text-[#10b981]">
                            <i class="bi bi-check-circle-fill"></i> Minimal 8 karakter
                        </span>
                        <span class="flex items-center gap-1 text-[#10b981]">
                            <i class="bi bi-check-circle-fill"></i> Huruf besar & kecil
                        </span>
                        <span class="flex items-center gap-1 text-[#10b981]">
                            <i class="bi bi-check-circle-fill"></i> Angka & karakter khusus
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <button class="border border-gray-200 hover:bg-gray-50 text-[#64748b] text-xs font-semibold px-4 py-2 rounded-full flex items-center gap-1.5 transition-colors">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Reset Kunci 2FA</span>
                </button>
                <button class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-shield-lock"></i>
                    <span>Perbarui Password</span>
                </button>
            </div>
        </div>

    </div>

</div>
@endsection
