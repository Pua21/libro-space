<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Portal Autentikasi - Libro Space Perpustakaan Digital</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(18px);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }
        .role-badge-active {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 14px -2px rgba(79, 70, 229, 0.35);
        }
        .role-badge-active i {
            color: #ffffff !important;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-3 sm:p-6 lg:p-10 bg-gradient-to-br from-[#ffffff] via-[#f8fafc] to-[#f1f5f9] relative overflow-x-hidden">

    <!-- Decorative Glow Blobs -->
    <div class="absolute -top-28 -left-28 w-96 h-96 bg-indigo-200/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-28 -right-28 w-96 h-96 bg-purple-200/25 rounded-full blur-3xl pointer-events-none"></div>

    <!-- MAIN WRAPPER CONTAINER -->
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl shadow-indigo-950/5 border border-slate-100 overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10">
        
        <!-- LEFT PANEL: BRAND HIGHLIGHT & IDENTITY (5 cols on lg) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#554fed] via-[#4f46e5] to-[#3730a3] p-8 lg:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute top-10 right-5 w-32 h-32 bg-indigo-400/20 rounded-full blur-xl pointer-events-none"></div>

            <!-- Top Header Brand -->
            <div class="relative z-10">
                <div class="flex items-center gap-3.5 mb-7">
                    <div class="w-12 h-12 rounded-2xl bg-white/10 backdrop-blur-md flex items-center justify-center text-white text-2xl shadow-inner border border-white/20">
                        <i class="bi bi-book-half"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight">Libro Space</h1>
                        <p class="text-[11px] text-indigo-200 font-medium">Sistem Informasi Perpustakaan Digital</p>
                    </div>
                </div>

                <div class="space-y-3.5">
                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-bold text-indigo-200 bg-white/10 border border-white/20">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Multi-Role Authentication System
                    </span>
                    <h2 class="text-2xl lg:text-3xl font-extrabold tracking-tight leading-snug">
                        Portal Layanan Perpustakaan Terpadu
                    </h2>
                    <p class="text-xs text-indigo-100/85 leading-relaxed">
                        Akses tunggal yang aman untuk seluruh civitas: Super Administrator, Staf Petugas Sirkulasi, serta Anggota Pemustaka.
                    </p>
                </div>
            </div>

            <!-- Features Highlights -->
            <div class="my-8 space-y-3 relative z-10">
                <div class="flex items-center gap-3.5 bg-white/10 backdrop-blur-sm p-3.5 rounded-2xl border border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0 text-sm">
                        <i class="bi bi-shield-lock-fill text-indigo-200"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold leading-tight">Admin & Manajemen Eksekutif</h4>
                        <p class="text-[11px] text-indigo-200 mt-0.5">Kontrol sistem, data master, audit trail, & laporan</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 bg-white/10 backdrop-blur-sm p-3.5 rounded-2xl border border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0 text-sm">
                        <i class="bi bi-person-gear text-indigo-200"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold leading-tight">Meja Layanan Sirkulasi</h4>
                        <p class="text-[11px] text-indigo-200 mt-0.5">Layanan peminjaman, pengembalian, & denda</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 bg-white/10 backdrop-blur-sm p-3.5 rounded-2xl border border-white/10">
                    <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0 text-sm">
                        <i class="bi bi-person-vcard text-indigo-200"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold leading-tight">Portal Pemustaka Mandiri</h4>
                        <p class="text-[11px] text-indigo-200 mt-0.5">Katalog OPAC, kartu anggota, & perpanjangan online</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Note -->
            <div class="pt-4 border-t border-white/15 text-[11px] text-indigo-200 flex items-center justify-between relative z-10">
                <span>Libro Space v2.0</span>
                <span class="flex items-center gap-1.5 text-emerald-300 font-semibold">
                    <i class="bi bi-lock-fill text-xs"></i> SSL 256-Bit Encrypted
                </span>
            </div>
        </div>

        <!-- RIGHT PANEL: AUTHENTICATION & REGISTRATION (7 cols on lg) -->
        <div class="lg:col-span-7 p-7 sm:p-10 lg:p-12 flex flex-col justify-between bg-white">
            <div>
                <!-- Top Tabs Switcher: LOGIN vs DAFTAR -->
                <div class="flex items-center justify-between pb-5 mb-6 border-b border-gray-100">
                    <div>
                        <h3 id="panelTitle" class="text-2xl font-extrabold text-[#0f172a] tracking-tight">Login</h3>
                        <p id="panelSubtitle" class="text-xs text-[#64748b] mt-1">Pilih peran dan masukkan kredensial akun Anda</p>
                    </div>

                    <!-- Auth Mode Toggle Buttons -->
                    <div class="flex p-1 bg-[#f1f5f9] rounded-xl text-xs font-bold" id="authModeTabs">
                        <button type="button" 
                                onclick="switchAuthMode('login')" 
                                id="btnModeLogin"
                                class="px-3.5 py-1.5 rounded-lg transition-all bg-white text-[#4338ca] shadow-xs">
                            Masuk
                        </button>
                        <button type="button" 
                                onclick="switchAuthMode('register')" 
                                id="btnModeRegister"
                                class="px-3.5 py-1.5 rounded-lg transition-all text-[#64748b] hover:text-[#0f172a]">
                            Daftar Baru
                        </button>
                    </div>
                </div>

                <!-- ================= SECTION 1: LOGIN FORM ================= -->
                <div id="sectionLogin">
                    <!-- ROLE SELECTOR TABS (3 ROLES) -->
                    <div class="mb-6">
                        <label class="block text-[11px] font-bold text-[#475569] mb-2 uppercase tracking-wider">Peran Akses Masuk:</label>
                        <div class="grid grid-cols-3 gap-2 p-1.5 bg-[#f8fafc] border border-gray-100 rounded-2xl" id="loginRoleTabsGroup">
                            <!-- Role: Admin -->
                            <button type="button" 
                                    onclick="selectLoginRole('admin')" 
                                    id="btnRoleAdmin"
                                    class="role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all role-badge-active">
                                <i class="bi bi-shield-lock text-sm"></i>
                                <span>Admin</span>
                            </button>

                            <!-- Role: Petugas -->
                            <button type="button" 
                                    onclick="selectLoginRole('petugas')" 
                                    id="btnRolePetugas"
                                    class="role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-[#64748b] hover:text-[#0f172a] hover:bg-white/80">
                                <i class="bi bi-person-gear text-sm"></i>
                                <span>Petugas</span>
                            </button>

                            <!-- Role: Anggota -->
                            <button type="button" 
                                    onclick="selectLoginRole('anggota')" 
                                    id="btnRoleAnggota"
                                    class="role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-[#64748b] hover:text-[#0f172a] hover:bg-white/80">
                                <i class="bi bi-people text-sm"></i>
                                <span>Anggota</span>
                            </button>
                        </div>
                    </div>

                    <!-- LOGIN FORM -->
                    <form id="formLogin" onsubmit="handleLoginSubmit(event)" class="space-y-4">
                        @csrf
                        <input type="hidden" name="role" id="loginRoleInput" value="admin">

                        <!-- Field: Username -->
                        <div>
                            <label class="block text-[11px] font-bold text-[#334155] mb-1.5" id="labelUsername">
                                Username
                            </label>
                            <div class="relative">
                                <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm" id="iconUsername"></i>
                                <input type="text" 
                                       id="loginUsername"
                                       name="username" 
                                       placeholder="Masukkan username Anda..." 
                                       required
                                       autocomplete="username"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-2xl pl-11 pr-4 py-3 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                            <p class="text-[10px] text-gray-400 mt-1" id="helperUsername">
                                Masukkan username akun Anda yang terdaftar
                            </p>
                        </div>

                        <!-- Field: Password -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-[11px] font-bold text-[#334155]">Kata Sandi</label>
                                <a href="javascript:void(0)" onclick="openForgotPasswordModal()" class="text-[10px] font-bold text-[#4f46e5] hover:underline">
                                    Lupa Password?
                                </a>
                            </div>
                            <div class="relative">
                                <i class="bi bi-shield-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                                <input type="password" 
                                       id="loginPassword"
                                       name="password" 
                                       placeholder="••••••••" 
                                       required
                                       autocomplete="current-password"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-2xl pl-11 pr-11 py-3 text-xs text-[#0f172a] font-mono placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                                <button type="button" onclick="togglePasswordVisibility('loginPassword', 'iconToggleLoginPassword')" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                    <i class="bi bi-eye" id="iconToggleLoginPassword"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center gap-2 cursor-pointer text-xs text-gray-600">
                                <input type="checkbox" name="remember" class="rounded border-gray-300 text-[#4f46e5] focus:ring-[#4f46e5]/20">
                                <span class="text-[11px] text-[#334155] font-medium">Ingat Sesi di Perangkat Ini</span>
                            </label>
                            <span class="text-[10px] text-gray-400">Keamanan terenkripsi</span>
                        </div>

                        <!-- Submit Button: Login -->
                        <button type="submit" 
                                id="btnSubmitLogin"
                                class="w-full mt-3 bg-[#4338ca] hover:bg-[#3730a3] text-white text-xs font-bold py-3.5 px-5 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/25 transition-all cursor-pointer">
                            <i class="bi bi-box-arrow-in-right text-base" id="iconLoginSubmit"></i>
                            <span id="textLoginSubmit">Login</span>
                        </button>
                    </form>

                    <!-- Switch to Register Callout -->
                    <div class="mt-6 p-3.5 bg-[#f8fafc] border border-gray-100 rounded-2xl flex items-center justify-between gap-3 text-xs">
                        <span class="text-[#64748b] text-[11px]">Belum memiliki akun Petugas atau Anggota?</span>
                        <button type="button" onclick="switchAuthMode('register')" class="text-[#4338ca] font-bold text-[11px] hover:underline whitespace-nowrap">
                            Daftar Sekarang &rarr;
                        </button>
                    </div>
                </div>


                <!-- ================= SECTION 2: REGISTER FORM ================= -->
                <div id="sectionRegister" class="hidden">
                    <!-- ROLE SELECTOR TABS FOR REGISTRATION (PETUGAS & ANGGOTA) -->
                    <div class="mb-5">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-[11px] font-bold text-[#475569] uppercase tracking-wider">Pilih Jenis Akun Pendaftaran:</label>
                            <span class="text-[10px] text-gray-400">Admin dibuat oleh Super Admin</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 p-1.5 bg-[#f8fafc] border border-gray-100 rounded-2xl">
                            <!-- Option 1: Petugas Baru -->
                            <button type="button" 
                                    onclick="selectRegisterRole('petugas')" 
                                    id="btnRegRolePetugas"
                                    class="py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all role-badge-active">
                                <i class="bi bi-person-gear text-sm"></i>
                                <span>Petugas Baru</span>
                            </button>

                            <!-- Option 2: Anggota Baru -->
                            <button type="button" 
                                    onclick="selectRegisterRole('anggota')" 
                                    id="btnRegRoleAnggota"
                                    class="py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all text-[#64748b] hover:text-[#0f172a] hover:bg-white/80">
                                <i class="bi bi-person-vcard text-sm"></i>
                                <span>Anggota Baru</span>
                            </button>
                        </div>
                    </div>

                    <!-- REGISTRATION FORM -->
                    <form id="formRegister" onsubmit="handleRegisterSubmit(event)" class="space-y-3.5">
                        @csrf
                        <input type="hidden" name="role" id="registerRoleInput" value="petugas">

                        <!-- Field 1: Nama Lengkap & Username (2 Cols) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">Nama Lengkap *</label>
                                <input type="text" 
                                       name="name" 
                                       id="regName"
                                       required
                                       placeholder="cth: Siti Rahmawati"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">Username *</label>
                                <input type="text" 
                                       name="username" 
                                       id="regUsername"
                                       required
                                       placeholder="cth: siti.r"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                        </div>

                        <!-- Field 2: Email & Nomor Telepon (2 Cols) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">Email Aktif *</label>
                                <input type="email" 
                                       name="email" 
                                       id="regEmail"
                                       required
                                       placeholder="cth: siti@perpustakaan.go.id"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">No. WhatsApp / HP *</label>
                                <input type="tel" 
                                       name="no_telepon" 
                                       id="regPhone"
                                       required
                                       placeholder="cth: 081234567890"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                        </div>

                        <!-- DYNAMIC FIELDS: PETUGAS ONLY -->
                        <div id="fieldsPetugas" class="space-y-3">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-[#334155] mb-1">NIP / ID Staf (Opsional)</label>
                                    <input type="text" 
                                           name="nip" 
                                           id="regNip"
                                           placeholder="cth: STF-2026-009"
                                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#334155] mb-1">Jabatan *</label>
                                    <select name="jabatan" id="regJabatan" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-[#0f172a] font-medium focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5]">
                                        <option value="Petugas Sirkulasi">Petugas Sirkulasi</option>
                                        <option value="Staf Inventaris & Katalog">Staf Inventaris & Katalog</option>
                                        <option value="Staf Pengembalian & Denda">Staf Pengembalian & Denda</option>
                                        <option value="Staf Layanan Referensi">Staf Layanan Referensi</option>
                                        <option value="Petugas Arsip">Petugas Arsip</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#334155] mb-1">Divisi Kerja *</label>
                                    <select name="divisi" id="regDivisi" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-[#0f172a] font-medium focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5]">
                                        <option value="Divisi Layanan Pemustaka">Divisi Layanan Pemustaka</option>
                                        <option value="Divisi Pengolahan Koleksi">Divisi Pengolahan Koleksi</option>
                                        <option value="Divisi Arsip & Pemeliharaan">Divisi Arsip & Pemeliharaan</option>
                                        <option value="UPT Perpustakaan Pusat">UPT Perpustakaan Pusat</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- DYNAMIC FIELDS: ANGGOTA ONLY -->
                        <div id="fieldsAnggota" class="space-y-3 hidden">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-[#334155] mb-1">Jenis Keanggotaan *</label>
                                    <select name="tipe_anggota" id="regTipeAnggota" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 text-xs text-[#0f172a] font-medium focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5]">
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="dosen">Dosen / Pengajar</option>
                                        <option value="staf">Staf Akademik</option>
                                        <option value="umum">Masyarakat Umum</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-[#334155] mb-1">Jurusan / Program Studi / Unit</label>
                                    <input type="text" 
                                           name="jurusan_unit" 
                                           id="regJurusan"
                                           placeholder="cth: Sistem Informasi / Akuntansi"
                                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">Alamat Domisili</label>
                                <input type="text" 
                                       name="alamat" 
                                       id="regAlamat"
                                       placeholder="cth: Jl. Melati No. 14, Jakarta"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                        </div>

                        <!-- Field: Password & Konfirmasi Password (2 Cols) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">Kata Sandi Baru *</label>
                                <div class="relative">
                                    <input type="password" 
                                           name="password" 
                                           id="regPassword"
                                           required
                                           minlength="4"
                                           placeholder="Minimal 4 karakter"
                                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl pl-3.5 pr-9 py-2.5 text-xs text-[#0f172a] font-mono focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                                    <button type="button" onclick="togglePasswordVisibility('regPassword', 'iconToggleRegPassword')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                        <i class="bi bi-eye text-xs" id="iconToggleRegPassword"></i>
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-[#334155] mb-1">Konfirmasi Kata Sandi *</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       id="regPasswordConfirm"
                                       required
                                       minlength="4"
                                       placeholder="Ulangi kata sandi"
                                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#0f172a] font-mono focus:outline-none focus:ring-2 focus:ring-[#4f46e5]/20 focus:border-[#4f46e5] transition-all">
                            </div>
                        </div>

                        <!-- Submit Button: Register -->
                        <button type="submit" 
                                id="btnSubmitRegister"
                                class="w-full mt-3 bg-[#4338ca] hover:bg-[#3730a3] text-white text-xs font-bold py-3.5 px-5 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-indigo-600/25 transition-all cursor-pointer">
                            <i class="bi bi-person-check-fill text-base" id="iconRegisterSubmit"></i>
                            <span id="textRegisterSubmit">Daftar Sebagai Petugas</span>
                        </button>
                    </form>

                    <!-- Switch to Login Callout -->
                    <div class="mt-5 p-3 bg-[#f8fafc] border border-gray-100 rounded-2xl flex items-center justify-between gap-3 text-xs">
                        <span class="text-[#64748b] text-[11px]">Sudah terdaftar memiliki akun?</span>
                        <button type="button" onclick="switchAuthMode('login')" class="text-[#4338ca] font-bold text-[11px] hover:underline whitespace-nowrap">
                            &larr; Masuk ke Akun
                        </button>
                    </div>
                </div>

            </div>

            <!-- Bottom Help Footer -->
            <div class="mt-8 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between text-[11px] text-gray-400 gap-2">
                <p>Mengalami kendala akun? <a href="javascript:void(0)" onclick="openForgotPasswordModal()" class="text-[#4338ca] font-bold hover:underline">Bantuan Pemulihan</a></p>
                <span class="text-[10px] text-gray-400">Libro Space &copy; 2026</span>
            </div>
        </div>

    </div>

    <!-- MODAL LUPA PASSWORD / BANTUAN PEMULIHAN -->
    <div id="modalForgotPassword" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-[#4338ca] flex items-center justify-center text-lg">
                        <i class="bi bi-shield-question"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-[#0f172a]">Bantuan Pemulihan Akun</h3>
                        <p class="text-[10px] text-[#64748b]">Panduan reset kredensial pengguna</p>
                    </div>
                </div>
                <button onclick="closeForgotPasswordModal()" class="w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 flex items-center justify-center">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>

            <div class="space-y-3 text-xs text-gray-600 mb-5 leading-relaxed">
                <div class="p-3 bg-[#f8fafc] border border-gray-100 rounded-2xl space-y-1">
                    <p class="font-bold text-[#0f172a]">🛡️ Administrator & Petugas:</p>
                    <p class="text-[11px]">Silakan hubungi Super Administrator sistem di ruang pengelola server atau email ke <strong class="text-[#4338ca]">admin@perpustakaan.go.id</strong>.</p>
                </div>

                <div class="p-3 bg-[#f8fafc] border border-gray-100 rounded-2xl space-y-1">
                    <p class="font-bold text-[#0f172a]">🎓 Anggota Pemustaka:</p>
                    <p class="text-[11px]">Silakan datang langsung ke Meja Layanan Sirkulasi dengan membawa Kartu Tanda Mahasiswa (KTM) atau KTP asli untuk reset kata sandi.</p>
                </div>
            </div>

            <button onclick="closeForgotPasswordModal()" class="w-full bg-[#4338ca] hover:bg-[#3730a3] text-white text-xs font-bold py-2.5 rounded-full transition-all">
                Tutup Panduan
            </button>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        let currentAuthMode = 'login';
        let currentLoginRole = 'admin';
        let currentRegisterRole = 'petugas';

        // Switch between Login and Register Mode
        function switchAuthMode(mode) {
            currentAuthMode = mode;
            const btnLogin = document.getElementById('btnModeLogin');
            const btnRegister = document.getElementById('btnModeRegister');
            const secLogin = document.getElementById('sectionLogin');
            const secRegister = document.getElementById('sectionRegister');
            const title = document.getElementById('panelTitle');
            const subtitle = document.getElementById('panelSubtitle');

            if (mode === 'login') {
                btnLogin.className = "px-3.5 py-1.5 rounded-lg transition-all bg-white text-[#4338ca] shadow-xs";
                btnRegister.className = "px-3.5 py-1.5 rounded-lg transition-all text-[#64748b] hover:text-[#0f172a]";
                secLogin.classList.remove('hidden');
                secRegister.classList.add('hidden');
                title.innerText = "Login";
                subtitle.innerText = "Pilih peran dan masukkan kredensial akun Anda";
            } else {
                btnRegister.className = "px-3.5 py-1.5 rounded-lg transition-all bg-white text-[#4338ca] shadow-xs";
                btnLogin.className = "px-3.5 py-1.5 rounded-lg transition-all text-[#64748b] hover:text-[#0f172a]";
                secLogin.classList.add('hidden');
                secRegister.classList.remove('hidden');
                title.innerText = "Pendaftaran Akun Baru";
                subtitle.innerText = "Daftarkan diri Anda sebagai staf Petugas atau Anggota pemustaka";
            }
        }

        // Select Role for Login
        function selectLoginRole(role) {
            currentLoginRole = role;
            document.getElementById('loginRoleInput').value = role;

            const roles = ['admin', 'petugas', 'anggota'];
            roles.forEach(r => {
                const btn = document.getElementById(`btnRole${r.charAt(0).toUpperCase() + r.slice(1)}`);
                if (r === role) {
                    btn.className = "role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all role-badge-active";
                } else {
                    btn.className = "role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-[#64748b] hover:text-[#0f172a] hover:bg-white/80";
                }
            });

            const helper = document.getElementById('helperUsername');
            const placeholder = document.getElementById('loginUsername');

            if (role === 'admin') {
                helper.innerText = "Gunakan username administrator sistem perpustakaan";
                placeholder.placeholder = "Masukkan username admin...";
            } else if (role === 'petugas') {
                helper.innerText = "Gunakan username staf sirkulasi atau staf perpustakaan";
                placeholder.placeholder = "Masukkan username petugas...";
            } else {
                helper.innerText = "Gunakan username akun atau nomor anggota Anda";
                placeholder.placeholder = "Masukkan username anggota...";
            }
        }

        // Select Role for Registration
        function selectRegisterRole(role) {
            currentRegisterRole = role;
            document.getElementById('registerRoleInput').value = role;

            const btnPetugas = document.getElementById('btnRegRolePetugas');
            const btnAnggota = document.getElementById('btnRegRoleAnggota');
            const fieldsPetugas = document.getElementById('fieldsPetugas');
            const fieldsAnggota = document.getElementById('fieldsAnggota');
            const btnSubmit = document.getElementById('textRegisterSubmit');

            if (role === 'petugas') {
                btnPetugas.className = "py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all role-badge-active";
                btnAnggota.className = "py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all text-[#64748b] hover:text-[#0f172a] hover:bg-white/80";
                fieldsPetugas.classList.remove('hidden');
                fieldsAnggota.classList.add('hidden');
                btnSubmit.innerText = "Daftar Sebagai Petugas";
                document.getElementById('regJabatan').required = true;
                document.getElementById('regDivisi').required = true;
                document.getElementById('regTipeAnggota').required = false;
            } else {
                btnAnggota.className = "py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all role-badge-active";
                btnPetugas.className = "py-2.5 px-3 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all text-[#64748b] hover:text-[#0f172a] hover:bg-white/80";
                fieldsPetugas.classList.add('hidden');
                fieldsAnggota.classList.remove('hidden');
                btnSubmit.innerText = "Daftar Sebagai Anggota";
                document.getElementById('regJabatan').required = false;
                document.getElementById('regDivisi').required = false;
                document.getElementById('regTipeAnggota').required = true;
            }
        }

        // Toggle Password Visibility Helper
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Handle Login Submission
        async function handleLoginSubmit(e) {
            e.preventDefault();

            const form = document.getElementById('formLogin');
            const username = document.getElementById('loginUsername').value.trim();
            const password = document.getElementById('loginPassword').value;
            const role = document.getElementById('loginRoleInput').value;

            if (!username || !password) {
                showToast('Harap isi username dan kata sandi.', 'error');
                return;
            }

            const btn = document.getElementById('btnSubmitLogin');
            const icon = document.getElementById('iconLoginSubmit');
            const text = document.getElementById('textLoginSubmit');

            btn.disabled = true;
            icon.className = 'bi bi-arrow-repeat animate-spin text-base';
            text.innerText = 'Memverifikasi...';

            try {
                const response = await fetch("{{ route('login.post') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        username: username,
                        password: password,
                        role: role
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message || 'Login berhasil! Mengalihkan...', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect_url || "{{ route('dashboard') }}";
                    }, 700);
                } else {
                    btn.disabled = false;
                    icon.className = 'bi bi-box-arrow-in-right text-base';
                    text.innerText = 'Login';
                    showToast(data.message || 'Username atau kata sandi tidak valid.', 'error');
                }
            } catch (err) {
                // If network/json fails, fallback to traditional submit
                form.submit();
            }
        }

        // Handle Register Submission
        async function handleRegisterSubmit(e) {
            e.preventDefault();

            const name = document.getElementById('regName').value.trim();
            const username = document.getElementById('regUsername').value.trim();
            const email = document.getElementById('regEmail').value.trim();
            const phone = document.getElementById('regPhone').value.trim();
            const password = document.getElementById('regPassword').value;
            const passwordConfirm = document.getElementById('regPasswordConfirm').value;
            const role = document.getElementById('registerRoleInput').value;

            if (!name || !username || !email || !phone || !password) {
                showToast('Harap lengkapi semua data wajib bertanda bintang (*).', 'error');
                return;
            }

            if (password !== passwordConfirm) {
                showToast('Konfirmasi kata sandi tidak cocok.', 'error');
                return;
            }

            const btn = document.getElementById('btnSubmitRegister');
            const icon = document.getElementById('iconRegisterSubmit');
            const text = document.getElementById('textRegisterSubmit');
            const prevText = text.innerText;

            btn.disabled = true;
            icon.className = 'bi bi-arrow-repeat animate-spin text-base';
            text.innerText = 'Memproses Pendaftaran...';

            const payload = {
                role: role,
                name: name,
                username: username,
                email: email,
                no_telepon: phone,
                password: password,
                password_confirmation: passwordConfirm,
            };

            if (role === 'petugas') {
                payload.nip = document.getElementById('regNip').value.trim();
                payload.jabatan = document.getElementById('regJabatan').value;
                payload.divisi = document.getElementById('regDivisi').value;
            } else {
                payload.tipe_anggota = document.getElementById('regTipeAnggota').value;
                payload.jurusan_unit = document.getElementById('regJurusan').value.trim();
                payload.alamat = document.getElementById('regAlamat').value.trim();
            }

            try {
                const response = await fetch("{{ route('register.post') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showToast(data.message || 'Pendaftaran berhasil! Mengalihkan...', 'success');
                    setTimeout(() => {
                        window.location.href = data.redirect_url || (role === 'petugas' ? "{{ route('petugas.portal') }}" : "{{ route('anggota.portal') }}");
                    }, 800);
                } else {
                    btn.disabled = false;
                    icon.className = 'bi bi-person-check-fill text-base';
                    text.innerText = prevText;
                    
                    let errMsg = data.message || 'Pendaftaran gagal. Periksa kembali isian form Anda.';
                    if (data.errors) {
                        errMsg = Object.values(data.errors).flat().join('<br>');
                    }
                    showToast(errMsg, 'error');
                }
            } catch (err) {
                btn.disabled = false;
                icon.className = 'bi bi-person-check-fill text-base';
                text.innerText = prevText;
                document.getElementById('formRegister').submit();
            }
        }

        // Modal Handlers
        function openForgotPasswordModal() {
            document.getElementById('modalForgotPassword').classList.remove('hidden');
            document.getElementById('modalForgotPassword').classList.add('flex');
        }

        function closeForgotPasswordModal() {
            document.getElementById('modalForgotPassword').classList.add('hidden');
            document.getElementById('modalForgotPassword').classList.remove('flex');
        }

        // Toast Helper
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            
            let bg = 'bg-slate-900 text-white';
            let icon = 'bi-info-circle';
            if (type === 'success') {
                bg = 'bg-[#10b981] text-white';
                icon = 'bi-check-circle-fill';
            } else if (type === 'error') {
                bg = 'bg-[#ef4444] text-white';
                icon = 'bi-exclamation-octagon-fill';
            } else if (type === 'info') {
                bg = 'bg-[#4338ca] text-white';
                icon = 'bi-shield-check';
            }

            toast.className = `${bg} px-4 py-3 rounded-2xl shadow-xl flex items-center gap-3 text-xs font-semibold transform transition-all duration-300 pointer-events-auto border border-white/10 max-w-sm`;
            toast.innerHTML = `<i class="bi ${icon} text-base shrink-0"></i><span>${message}</span>`;
            
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }
    </script>
</body>
</html>
