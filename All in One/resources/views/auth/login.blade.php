<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Libro Space Perpustakaan Digital</title>
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
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 md:p-8 bg-gradient-to-br from-[#f1f5f9] via-[#eef2ff] to-[#f8fafc] relative overflow-x-hidden">

    <!-- Decorative background glow blobs -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-indigo-300/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-purple-300/30 rounded-full blur-3xl pointer-events-none"></div>

    <!-- MAIN CONTAINER -->
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl shadow-indigo-500/5 border border-slate-100 overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10">
        
        <!-- LEFT PANEL: BRAND HIGHLIGHT & INFO (5 cols on lg) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#554fed] via-[#4f46e5] to-[#3730a3] p-8 lg:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Decorative circle overlay -->
            <div class="absolute -bottom-20 -right-20 w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute top-10 right-5 w-32 h-32 bg-indigo-400/20 rounded-full blur-xl pointer-events-none"></div>

            <!-- Top Brand Header -->
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-11 h-11 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-white text-xl shadow-inner border border-white/20">
                        <i class="bi bi-book-half"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-extrabold tracking-tight">Libro Space</h1>
                        <p class="text-[11px] text-indigo-100 font-medium">Sistem Informasi Manajemen Perpustakaan</p>
                    </div>
                </div>

                <div class="mt-8 space-y-3">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold text-indigo-200 bg-white/10 border border-white/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Multi-Role Authentication
                    </span>
                    <h2 class="text-2xl font-extrabold tracking-tight leading-snug">
                        Satu Portal Masuk untuk Seluruh Civitas Perpustakaan
                    </h2>
                    <p class="text-xs text-indigo-100/90 leading-relaxed font-normal">
                        Masuk ke akun terintegrasi Anda untuk mengelola sirkulasi buku, riwayat peminjaman, perpanjangan mandiri, serta pencatatan kas denda.
                    </p>
                </div>
            </div>

            <!-- Middle Features List -->
            <div class="my-8 space-y-3.5 relative z-10">
                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-2xl border border-white/10">
                    <div class="w-7 h-7 rounded-xl bg-white/20 flex items-center justify-center shrink-0 text-xs">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold">Admin & Staf Petugas</h4>
                        <p class="text-[11px] text-indigo-100">Kelola katalog, sirkulasi meja, audit log, dan laporan keuangan.</p>
                    </div>
                </div>

                <div class="flex items-start gap-3 bg-white/10 backdrop-blur-sm p-3 rounded-2xl border border-white/10">
                    <div class="w-7 h-7 rounded-xl bg-white/20 flex items-center justify-center shrink-0 text-xs">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold">Anggota & Mahasiswa</h4>
                        <p class="text-[11px] text-indigo-100">Katalog OPAC, kartu anggota digital, dan perpanjangan online.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Note -->
            <div class="pt-4 border-t border-white/15 text-[11px] text-indigo-200 flex items-center justify-between relative z-10">
                <span>Versi Sistem 2.0 (Build 2026)</span>
                <span class="flex items-center gap-1 text-emerald-300 font-semibold">
                    <i class="bi bi-lock-fill text-[10px]"></i> SSL 256-Bit
                </span>
            </div>
        </div>

        <!-- RIGHT PANEL: LOGIN FORM (7 cols on lg) -->
        <div class="lg:col-span-7 p-8 lg:p-12 flex flex-col justify-between">
            <div>
                <!-- Form Header -->
                <div class="mb-6">
                    <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight">Masuk ke Akun</h3>
                    <p class="text-xs text-[#64748b] mt-1">Pilih peran akun Anda dan masukkan kredensial yang terdaftar</p>
                </div>

                <!-- 3 ROLE SELECTOR TABS -->
                <div class="mb-6">
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-2 uppercase tracking-wider">Pilih Peran Masuk (Role):</label>
                    <div class="grid grid-cols-3 gap-2 p-1.5 bg-[#f1f5f9] rounded-2xl" id="roleTabsGroup">
                        <!-- Role 1: Admin -->
                        <button type="button" 
                                onclick="selectRole('admin')" 
                                id="btnRoleAdmin"
                                class="role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all bg-[#554fed] text-white shadow-sm">
                            <i class="bi bi-shield-lock text-sm"></i>
                            <span>Admin</span>
                        </button>

                        <!-- Role 2: Petugas -->
                        <button type="button" 
                                onclick="selectRole('petugas')" 
                                id="btnRolePetugas"
                                class="role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-[#64748b] hover:text-[#1e293b] hover:bg-white/60">
                            <i class="bi bi-person-gear text-sm"></i>
                            <span>Petugas</span>
                        </button>

                        <!-- Role 3: Anggota -->
                        <button type="button" 
                                onclick="selectRole('anggota')" 
                                id="btnRoleAnggota"
                                class="role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-[#64748b] hover:text-[#1e293b] hover:bg-white/60">
                            <i class="bi bi-people text-sm"></i>
                            <span>Anggota</span>
                        </button>
                    </div>
                </div>

                <!-- 1-CLICK DEMO TESTER PILLS -->
                <div class="p-3 bg-[#eff1fe] rounded-2xl mb-6 border border-indigo-100">
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-[11px] font-bold text-[#554fed] flex items-center gap-1">
                            <i class="bi bi-lightning-charge-fill"></i> Uji Coba Cepat (1-Click Demo)
                        </span>
                        <span class="text-[10px] text-gray-500">Klik untuk isi otomatis:</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <button type="button" onclick="fillDemo('admin')" class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-white text-[#554fed] border border-indigo-200 hover:bg-indigo-50 shadow-2xs transition-all">
                            👑 Admin: admin.utama
                        </button>
                        <button type="button" onclick="fillDemo('petugas')" class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-white text-[#554fed] border border-indigo-200 hover:bg-indigo-50 shadow-2xs transition-all">
                            📚 Petugas: budi.s
                        </button>
                        <button type="button" onclick="fillDemo('anggota')" class="px-2.5 py-1 rounded-lg text-[10px] font-semibold bg-white text-[#554fed] border border-indigo-200 hover:bg-indigo-50 shadow-2xs transition-all">
                            🎓 Anggota: AGT-0001
                        </button>
                    </div>
                </div>

                <!-- LOGIN FORM -->
                <form id="loginForm" onsubmit="handleFormSubmit(event)" class="space-y-4">
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="admin">

                    <!-- Field 1: Identifier -->
                    <div>
                        <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5" id="labelIdentifier">
                            Username / Email Kedinasan
                        </label>
                        <div class="relative">
                            <i class="bi bi-person absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm" id="iconIdentifier"></i>
                            <input type="text" 
                                   id="inputIdentifier"
                                   name="identifier" 
                                   value="admin.utama"
                                   placeholder="Masukkan username atau email..." 
                                   required
                                   class="w-full bg-[#f8fafc] border border-gray-200 rounded-2xl pl-11 pr-4 py-3 text-xs text-[#1e293b] font-medium placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all">
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1" id="helperIdentifier">
                            Gunakan kredensial akun administrator sistem perpustakaan
                        </p>
                    </div>

                    <!-- Field 2: Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-[11px] font-bold text-[#1e293b]">Kata Sandi</label>
                            <a href="javascript:void(0)" onclick="openForgotPasswordModal()" class="text-[10px] font-bold text-[#554fed] hover:underline">
                                Lupa Password?
                            </a>
                        </div>
                        <div class="relative">
                            <i class="bi bi-shield-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="password" 
                                   id="inputPassword"
                                   name="password" 
                                   value="AdminSecretLibrary2024!"
                                   placeholder="••••••••••••" 
                                   required
                                   class="w-full bg-[#f8fafc] border border-gray-200 rounded-2xl pl-11 pr-11 py-3 text-xs text-[#1e293b] font-mono placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all">
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                                <i class="bi bi-eye" id="togglePasswordIcon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer text-xs text-gray-600">
                            <input type="checkbox" name="remember" checked class="rounded border-gray-300 text-[#554fed] focus:ring-[#554fed]/20">
                            <span class="text-[11px] text-[#1e293b] font-medium">Ingat Sesi di Perangkat Ini</span>
                        </label>
                        <span class="text-[10px] text-gray-400">Masa aktif: 30 hari</span>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="btnSubmitLogin"
                            class="w-full mt-2 bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-3.5 px-5 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-indigo-500/25 transition-all cursor-pointer">
                        <i class="bi bi-box-arrow-in-right text-base" id="submitIcon"></i>
                        <span id="submitText">Masuk ke Sistem</span>
                    </button>
                </form>
            </div>

            <!-- Bottom Help Footer -->
            <div class="mt-8 pt-4 border-t border-gray-100 flex flex-wrap items-center justify-between text-[11px] text-gray-400 gap-2">
                <p>Butuh bantuan login? <a href="javascript:void(0)" onclick="openForgotPasswordModal()" class="text-[#554fed] font-bold hover:underline">Hubungi Bantuan TI</a></p>
                <div class="flex items-center gap-3">
                    <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-[#554fed]">Langsung ke Dashboard &gt;</a>
                </div>
            </div>
        </div>

    </div>

    <!-- MODAL LUPA PASSWORD / BANTUAN -->
    <div id="modalForgotPassword" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-xs hidden items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                        <i class="bi bi-question-circle"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-[#1e293b]">Pemulihan Akses Akun</h3>
                        <p class="text-[10px] text-[#64748b]">Bantuan reset kata sandi</p>
                    </div>
                </div>
                <button onclick="closeForgotPasswordModal()" class="w-8 h-8 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 flex items-center justify-center">
                    <i class="bi bi-x text-lg"></i>
                </button>
            </div>

            <div class="space-y-3 text-xs text-gray-600 mb-5 leading-relaxed">
                <div class="p-3 bg-[#f8fafc] border border-gray-100 rounded-2xl space-y-1.5">
                    <p class="font-bold text-[#1e293b]">🛡️ Untuk Akun Administrator & Petugas:</p>
                    <p class="text-[11px]">Silakan hubungi Super Administrator di meja UPT Perpustakaan Pusat atau kirimkan email ke <strong class="text-[#554fed]">admin@perpustakaan.go.id</strong> untuk reset kredensial.</p>
                </div>

                <div class="p-3 bg-[#f8fafc] border border-gray-100 rounded-2xl space-y-1.5">
                    <p class="font-bold text-[#1e293b]">🎓 Untuk Akun Anggota (Mahasiswa/Dosen):</p>
                    <p class="text-[11px]">Kunjungi Meja Layanan Sirkulasi dengan membawa Kartu Tanda Mahasiswa (KTM) atau KTP asli untuk verifikasi data.</p>
                </div>
            </div>

            <button onclick="closeForgotPasswordModal()" class="w-full bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 rounded-full transition-all">
                Mengerti & Tutup
            </button>
        </div>
    </div>

    <!-- TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed top-5 right-5 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        // Preset Demologin data based on database design
        const demoAccounts = {
            admin: {
                role: 'admin',
                identifier: 'admin.utama',
                password: 'AdminSecretLibrary2024!',
                label: 'Username / Email Kedinasan',
                placeholder: 'cth: admin.utama atau admin@perpustakaan.go.id',
                helper: 'Kredensial akses penuh Super Administrator',
                icon: 'bi-shield-lock'
            },
            petugas: {
                role: 'petugas',
                identifier: 'budi.s',
                password: 'Petugas2026!Sirkulasi',
                label: 'Username / NIP Petugas',
                placeholder: 'cth: budi.s atau STF-2024-008',
                helper: 'Kredensial staf sirkulasi dan operasional perpustakaan',
                icon: 'bi-person-gear'
            },
            anggota: {
                role: 'anggota',
                identifier: 'AGT-0001',
                password: 'Anggota2026#Putri',
                label: 'Nomor Anggota / Email Mahasiswa',
                placeholder: 'cth: AGT-0001 atau putri.ayu@univ.ac.id',
                helper: 'Kredensial peminjam buku dan anggota terdaftar',
                icon: 'bi-person-vcard'
            }
        };

        let currentRole = 'admin';

        // Select Role Function
        function selectRole(role) {
            currentRole = role;
            document.getElementById('roleInput').value = role;

            // Update Tab Buttons UI
            const roles = ['admin', 'petugas', 'anggota'];
            roles.forEach(r => {
                const btn = document.getElementById(`btnRole${r.charAt(0).toUpperCase() + r.slice(1)}`);
                if (r === role) {
                    btn.className = "role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all bg-[#554fed] text-white shadow-sm";
                } else {
                    btn.className = "role-tab-btn py-2.5 px-3 rounded-xl text-xs font-bold flex flex-col sm:flex-row items-center justify-center gap-1.5 transition-all text-[#64748b] hover:text-[#1e293b] hover:bg-white/60";
                }
            });

            // Update labels and helpers
            const config = demoAccounts[role];
            document.getElementById('labelIdentifier').innerText = config.label;
            document.getElementById('inputIdentifier').placeholder = config.placeholder;
            document.getElementById('helperIdentifier').innerText = config.helper;
            document.getElementById('iconIdentifier').className = `bi ${config.icon} absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm`;
        }

        // Fill Demo Credentials
        function fillDemo(role) {
            selectRole(role);
            const data = demoAccounts[role];
            document.getElementById('inputIdentifier').value = data.identifier;
            document.getElementById('inputPassword').value = data.password;
            showToast(`Kredensial demo ${role.toUpperCase()} berhasil dimuat!`, 'info');
        }

        // Toggle Password Visibility
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('inputPassword');
            const icon = document.getElementById('togglePasswordIcon');
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pwdInput.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Form Submit Handler
        function handleFormSubmit(e) {
            e.preventDefault();

            const identifier = document.getElementById('inputIdentifier').value.trim();
            const password = document.getElementById('inputPassword').value;
            const role = document.getElementById('roleInput').value;

            if (!identifier || !password) {
                showToast('Harap isi semua kolom login.', 'error');
                return;
            }

            const btn = document.getElementById('btnSubmitLogin');
            const icon = document.getElementById('submitIcon');
            const text = document.getElementById('submitText');

            btn.disabled = true;
            icon.className = 'bi bi-arrow-repeat animate-spin text-base';
            text.innerText = 'Memverifikasi Kredensial...';

            setTimeout(() => {
                showToast(`Berhasil masuk sebagai ${role.toUpperCase()}! Mengalihkan...`, 'success');
                setTimeout(() => {
                    window.location.href = "{{ route('dashboard') }}";
                }, 800);
            }, 600);
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
                bg = 'bg-[#554fed] text-white';
                icon = 'bi-shield-check';
            }

            toast.className = `${bg} px-4 py-3 rounded-2xl shadow-xl flex items-center gap-3 text-xs font-semibold transform transition-all duration-300 pointer-events-auto border border-white/10`;
            toast.innerHTML = `<i class="bi ${icon} text-base"></i><span>${message}</span>`;
            
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</body>
</html>
