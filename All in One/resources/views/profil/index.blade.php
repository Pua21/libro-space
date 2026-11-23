@extends('layouts.app')

@section('title', 'Profil Pengguna')

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
                 id="topNavAvatar"
                 alt="Admin" 
                 class="w-8 h-8 rounded-full object-cover ring-2 ring-indigo-100">
            <div class="text-left hidden sm:block">
                <p class="text-xs font-bold text-[#1e293b] leading-tight" id="topNavNama">Admin Perpustakaan</p>
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
                     id="profileAvatarPreview"
                     alt="{{ $profil['nama'] }}" 
                     class="w-28 h-28 rounded-full object-cover ring-4 ring-indigo-50 shadow-md">
                <button type="button" onclick="triggerPhotoUpload()" class="absolute bottom-0 right-0 bg-[#554fed] hover:bg-[#4338ca] text-white text-[11px] font-semibold px-3 py-1 rounded-full flex items-center gap-1 shadow-md transition-all cursor-pointer">
                    <i class="bi bi-camera"></i>
                    <span>Ubah Foto</span>
                </button>
                <input type="file" id="hiddenPhotoInput" accept="image/*" class="hidden" onchange="handlePhotoUpload(event)">
            </div>

            <h3 class="text-base font-bold text-[#1e293b]" id="profileCardNama">{{ $profil['nama'] }}</h3>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] mt-2 mb-2">
                <i class="bi bi-shield-check"></i>
                <span id="profileCardRole">{{ $profil['role'] }}</span>
            </div>
            <p class="text-xs text-[#64748b] font-mono">{{ $profil['username'] }}</p>
            <p class="text-xs text-[#64748b]" id="profileCardEmail">{{ $profil['email'] }}</p>

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
            <div class="space-y-3" id="sessionsContainer">
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
                <div id="sessionOtherDevice" class="flex items-center justify-between p-2.5 rounded-xl bg-[#f8fafc] border border-gray-100 transition-all">
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
            <button type="button" onclick="keluarkanSesiLain()" id="btnKeluarkanSesi" class="w-full mt-4 bg-[#fef2f2] hover:bg-rose-100 border border-[#fee2e2] text-[#ef4444] text-xs font-bold py-2.5 rounded-xl flex items-center justify-center gap-1.5 transition-colors cursor-pointer">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluarkan Sesi Lain</span>
            </button>
        </div>

    </div>

    <!-- RIGHT COLUMN (8 cols) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Informasi Pribadi Card -->
        <form onsubmit="handleSaveProfile(event)" class="bg-white rounded-3xl p-6 glass-card">
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
                    <input type="text" id="inputNamaLengkap" value="{{ $profil['nama'] }}" required
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
                    <input type="email" id="inputEmail" value="{{ $profil['email'] }}" required
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Nomor WhatsApp / Kontak</label>
                    <input type="text" id="inputKontak" value="{{ $profil['kontak'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Jabatan Struktural</label>
                    <input type="text" id="inputJabatan" value="{{ $profil['jabatan'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Divisi / Unit Kerja</label>
                    <input type="text" id="inputDivisi" value="{{ $profil['divisi'] }}" 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-medium focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-2 pt-3 border-t border-gray-100">
                <button type="button" onclick="cancelProfileEdit()" class="px-5 py-2 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all cursor-pointer">
                    Batal
                </button>
                <button type="submit" id="btnSaveProfile" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all cursor-pointer">
                    <i class="bi bi-floppy"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>

        <!-- Keamanan Password Card -->
        <form onsubmit="handleUpdatePassword(event)" class="bg-white rounded-3xl p-6 glass-card">
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
                        <input type="password" id="inputCurrentPassword" value="AdminSecretLibrary2024!" required
                               class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-mono pr-10 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                        <button type="button" onclick="togglePasswordVisibility('inputCurrentPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 cursor-pointer">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="inputNewPassword" value="Perpustakaan2025#Utama" oninput="checkPasswordStrength(this.value)" required
                                   class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-mono pr-10 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                            <button type="button" onclick="togglePasswordVisibility('inputNewPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 cursor-pointer">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="inputConfirmPassword" value="Perpustakaan2025#Utama" required
                                   class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs text-[#1e293b] font-mono pr-10 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                            <button type="button" onclick="togglePasswordVisibility('inputConfirmPassword', this)" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 cursor-pointer">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Password strength indicator -->
                <div class="bg-[#f8fafc] rounded-2xl p-4 border border-gray-100">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[11px] font-bold text-[#1e293b]">Kekuatan Sandi:</span>
                        <span id="strengthLabel" class="text-[11px] font-bold text-[#10b981] flex items-center gap-1">
                            <i class="bi bi-shield-check"></i> Sangat Kuat
                        </span>
                    </div>

                    <!-- 4 strength bars -->
                    <div class="grid grid-cols-4 gap-2 mb-3" id="strengthBars">
                        <div class="strength-bar h-1.5 rounded-full bg-[#10b981] transition-all"></div>
                        <div class="strength-bar h-1.5 rounded-full bg-[#10b981] transition-all"></div>
                        <div class="strength-bar h-1.5 rounded-full bg-[#10b981] transition-all"></div>
                        <div class="strength-bar h-1.5 rounded-full bg-[#10b981] transition-all"></div>
                    </div>

                    <!-- Requirements checklist -->
                    <div class="flex flex-wrap items-center gap-4 text-[10px] text-gray-600 font-medium">
                        <span id="reqLength" class="flex items-center gap-1 text-[#10b981]">
                            <i class="bi bi-check-circle-fill"></i> Minimal 8 karakter
                        </span>
                        <span id="reqCase" class="flex items-center gap-1 text-[#10b981]">
                            <i class="bi bi-check-circle-fill"></i> Huruf besar & kecil
                        </span>
                        <span id="reqSpecial" class="flex items-center gap-1 text-[#10b981]">
                            <i class="bi bi-check-circle-fill"></i> Angka & karakter khusus
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                <button type="button" onclick="open2FAResetModal()" class="border border-gray-200 hover:bg-gray-50 text-[#64748b] text-xs font-semibold px-4 py-2 rounded-full flex items-center gap-1.5 transition-colors cursor-pointer">
                    <i class="bi bi-arrow-repeat"></i>
                    <span>Reset Kunci 2FA</span>
                </button>
                <button type="submit" id="btnUpdatePassword" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2 rounded-full flex items-center gap-2 shadow-md shadow-indigo-500/20 transition-all cursor-pointer">
                    <i class="bi bi-shield-lock"></i>
                    <span>Perbarui Password</span>
                </button>
            </div>
        </form>

    </div>

</div>

<!-- MODAL RESET KUNCI 2FA -->
<div id="modal2FA" class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative animate-in fade-in zoom-in duration-200 text-center">
        <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-2xl mx-auto mb-3">
            <i class="bi bi-qr-code-scan"></i>
        </div>
        <h3 class="text-base font-bold text-[#1e293b]">Reset Autentikasi Dua Langkah (2FA)</h3>
        <p class="text-xs text-[#64748b] mt-1 mb-4">Pindai kode QR baru dengan Google Authenticator atau aplikasi OTP pilihan Anda.</p>

        <!-- Simulated QR Code placeholder -->
        <div class="bg-[#f8fafc] border border-gray-200 rounded-2xl p-4 inline-block mb-3">
            <div class="w-40 h-40 bg-white border border-gray-300 rounded-xl flex flex-col items-center justify-center gap-2 mx-auto">
                <i class="bi bi-qr-code text-6xl text-slate-800"></i>
                <span class="text-[9px] font-mono text-gray-500">LIBRO-2FA-SECURE-KEY</span>
            </div>
        </div>

        <div class="p-2.5 bg-slate-100 rounded-xl text-xs font-mono text-slate-700 mb-5 select-all">
            KODE RAHASIA: <strong>7K42-99XZ-LIBR-2026</strong>
        </div>

        <div class="flex items-center justify-center gap-2">
            <button onclick="close2FAResetModal()" class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50">
                Batal
            </button>
            <button onclick="confirmReset2FA()" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20">
                Verifikasi & Simpan Kunci
            </button>
        </div>
    </div>
</div>

<script>
// Initial Profile Values
const initialProfile = {
    nama: "{{ $profil['nama'] }}",
    email: "{{ $profil['email'] }}",
    kontak: "{{ $profil['kontak'] }}",
    jabatan: "{{ $profil['jabatan'] }}",
    divisi: "{{ $profil['divisi'] }}"
};

// Photo Upload Trigger & Preview
function triggerPhotoUpload() {
    document.getElementById('hiddenPhotoInput').click();
}

function handlePhotoUpload(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(evt) {
            document.getElementById('profileAvatarPreview').src = evt.target.result;
            const topNavAvatar = document.getElementById('topNavAvatar');
            if (topNavAvatar) topNavAvatar.src = evt.target.result;
            if (window.showToast) {
                window.showToast('Foto profil baru berhasil diunggah!', 'success');
            }
        };
        reader.readAsDataURL(file);
    }
}

// Profile Save Handler
function handleSaveProfile(e) {
    e.preventDefault();
    const btn = document.getElementById('btnSaveProfile');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i><span>Menyimpan...</span>';

    setTimeout(() => {
        const newNama = document.getElementById('inputNamaLengkap').value;
        const newEmail = document.getElementById('inputEmail').value;

        document.getElementById('profileCardNama').innerText = newNama;
        document.getElementById('profileCardEmail').innerText = newEmail;
        const topNavNama = document.getElementById('topNavNama');
        if (topNavNama) topNavNama.innerText = newNama;

        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-floppy"></i><span>Simpan Perubahan</span>';

        if (window.showToast) {
            window.showToast('Informasi profil berhasil diperbarui.', 'success');
        }
    }, 400);
}

function cancelProfileEdit() {
    document.getElementById('inputNamaLengkap').value = initialProfile.nama;
    document.getElementById('inputEmail').value = initialProfile.email;
    document.getElementById('inputKontak').value = initialProfile.kontak;
    document.getElementById('inputJabatan').value = initialProfile.jabatan;
    document.getElementById('inputDivisi').value = initialProfile.divisi;

    if (window.showToast) {
        window.showToast('Perubahan form profil dibatalkan.', 'info');
    }
}

// Password Eye Toggle
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye-slash';
    }
}

// Real-Time Password Strength Calculation
function checkPasswordStrength(password) {
    const bars = document.querySelectorAll('.strength-bar');
    const label = document.getElementById('strengthLabel');
    const reqLength = document.getElementById('reqLength');
    const reqCase = document.getElementById('reqCase');
    const reqSpecial = document.getElementById('reqSpecial');

    const hasLength = password.length >= 8;
    const hasCase = /[A-Z]/.test(password) && /[a-z]/.test(password);
    const hasSpecial = /[0-9]/.test(password) && /[^A-Za-z0-9]/.test(password);

    // Update requirements
    updateReq(reqLength, hasLength);
    updateReq(reqCase, hasCase);
    updateReq(reqSpecial, hasSpecial);

    let score = 0;
    if (password.length >= 6) score++;
    if (hasLength && hasCase) score++;
    if (hasLength && hasCase && /[0-9]/.test(password)) score++;
    if (hasLength && hasCase && hasSpecial) score++;

    // Color bars based on score
    bars.forEach((bar, idx) => {
        bar.className = 'strength-bar h-1.5 rounded-full transition-all';
        if (idx < score) {
            if (score <= 1) bar.classList.add('bg-[#ef4444]');
            else if (score === 2) bar.classList.add('bg-[#f59e0b]');
            else if (score === 3) bar.classList.add('bg-[#3b82f6]');
            else bar.classList.add('bg-[#10b981]');
        } else {
            bar.classList.add('bg-gray-200');
        }
    });

    if (score <= 1) {
        label.innerHTML = '<i class="bi bi-shield-x"></i> Lemah';
        label.className = 'text-[11px] font-bold text-[#ef4444] flex items-center gap-1';
    } else if (score === 2) {
        label.innerHTML = '<i class="bi bi-shield-exclamation"></i> Cukup';
        label.className = 'text-[11px] font-bold text-[#f59e0b] flex items-center gap-1';
    } else if (score === 3) {
        label.innerHTML = '<i class="bi bi-shield-check"></i> Kuat';
        label.className = 'text-[11px] font-bold text-[#3b82f6] flex items-center gap-1';
    } else {
        label.innerHTML = '<i class="bi bi-shield-check"></i> Sangat Kuat';
        label.className = 'text-[11px] font-bold text-[#10b981] flex items-center gap-1';
    }
}

function updateReq(elem, isValid) {
    if (isValid) {
        elem.className = "flex items-center gap-1 text-[#10b981]";
        elem.querySelector('i').className = "bi bi-check-circle-fill";
    } else {
        elem.className = "flex items-center gap-1 text-gray-400";
        elem.querySelector('i').className = "bi bi-circle";
    }
}

// Update Password Handler
function handleUpdatePassword(e) {
    e.preventDefault();
    const cur = document.getElementById('inputCurrentPassword').value;
    const newP = document.getElementById('inputNewPassword').value;
    const conf = document.getElementById('inputConfirmPassword').value;

    if (newP !== conf) {
        if (window.showToast) {
            window.showToast('Password baru dan konfirmasi password tidak cocok!', 'warning');
        }
        return;
    }

    const btn = document.getElementById('btnUpdatePassword');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin"></i><span>Memperbarui...</span>';

    setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-shield-lock"></i><span>Perbarui Password</span>';
        if (window.showToast) {
            window.showToast('Kata sandi administrator berhasil diperbarui dengan aman!', 'success');
        }
    }, 500);
}

// 2FA Reset Modal
function open2FAResetModal() {
    const modal = document.getElementById('modal2FA');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function close2FAResetModal() {
    const modal = document.getElementById('modal2FA');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function confirmReset2FA() {
    close2FAResetModal();
    if (window.showToast) {
        window.showToast('Kunci 2FA berhasil direset dan siap digunakan.', 'success');
    }
}

// Logout Other Sessions
function keluarkanSesiLain() {
    const session2 = document.getElementById('sessionOtherDevice');
    if (!session2) {
        if (window.showToast) {
            window.showToast('Tidak ada sesi lain yang sedang aktif.', 'info');
        }
        return;
    }

    if (confirm('Apakah Anda yakin ingin mengeluarkan seluruh sesi di perangkat lain?')) {
        session2.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            session2.remove();
            const btn = document.getElementById('btnKeluarkanSesi');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');
            btn.innerHTML = '<i class="bi bi-check2"></i><span>Hanya Sesi Ini Yang Aktif</span>';
            if (window.showToast) {
                window.showToast('Semua sesi perangkat lain berhasil dikeluarkan.', 'success');
            }
        }, 300);
    }
}
</script>
@endsection