@extends('layouts.app')

@section('title', 'Data Petugas')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="globalPetugasSearch"
               onkeyup="liveFilterPetugas()"
               placeholder="Cari fitur, buku, staf..." 
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
                <p class="text-[10px] text-[#64748b] font-medium">Administrator Utama</p>
            </div>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

<!-- PAGE TITLE & ACTIONS -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Petugas</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Manajemen akun staf, petugas sirkulasi, dan hak akses sistem</p>
    </div>

    <button onclick="document.getElementById('addPetugasModal').classList.remove('hidden')" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
        <i class="bi bi-person-plus text-sm"></i>
        <span>+ Tambah Petugas</span>
    </button>
</div>

<!-- 3 METRIC CARDS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-6">
    <!-- Total Petugas -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-xl">
                <i class="bi bi-person-badge"></i>
            </div>
            <div>
                <p class="text-xs text-[#64748b] font-medium">Total Petugas</p>
                <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight"><span id="metricTotalPetugas">{{ $stats['total'] }}</span> <span class="text-xs font-normal text-gray-500">Petugas</span></h3>
            </div>
        </div>
        <span class="text-[11px] font-semibold text-[#554fed] bg-[#eef2ff] px-3 py-1 rounded-full">Total Staf</span>
    </div>

    <!-- Petugas Aktif -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#ecfdf5] text-[#10b981] flex items-center justify-center text-xl">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <p class="text-xs text-[#64748b] font-medium">Petugas Aktif</p>
                <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight"><span id="metricAktifPetugas">{{ $stats['aktif'] }}</span> <span class="text-xs font-normal text-gray-500">Aktif</span></h3>
            </div>
        </div>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] px-3 py-1 rounded-full border border-[#d1fae5]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span> Terverifikasi
        </span>
    </div>

    <!-- Sedang Bertugas -->
    <div class="bg-white rounded-3xl p-5 glass-card flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-[#fffbeb] text-[#f59e0b] flex items-center justify-center text-xl">
                <i class="bi bi-clock"></i>
            </div>
            <div>
                <p class="text-xs text-[#64748b] font-medium">Sedang Bertugas</p>
                <h3 class="text-2xl font-extrabold text-[#1e293b] tracking-tight"><span id="metricOnlinePetugas">{{ $stats['online'] }}</span> <span class="text-xs font-normal text-gray-500">Online Saat Ini</span></h3>
            </div>
        </div>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-[#0d9488] bg-[#f0fdfa] px-3 py-1 rounded-full border border-[#ccfbf1]">
            <span class="w-1.5 h-1.5 rounded-full bg-[#0d9488]"></span> Shift Pagi
        </span>
    </div>
</div>

<!-- SEARCH & FILTER -->
<div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center gap-3 mb-6">
    <div class="relative flex-1 min-w-[240px]">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
        <input type="text" 
               id="filterPetugasInput"
               onkeyup="liveFilterPetugas()"
               placeholder="Cari nama petugas, username, atau email..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
    </div>

    <select id="filterPetugasRole" onchange="liveFilterPetugas()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option value="">Peran / Role: Semua</option>
        <option value="Kepala Sirkulasi">Kepala Sirkulasi</option>
        <option value="Staf Inventaris & Katalog">Staf Inventaris & Katalog</option>
        <option value="Staf Peminjaman & Layanan">Staf Peminjaman & Layanan</option>
        <option value="Staf Pengembalian & Denda">Staf Pengembalian & Denda</option>
        <option value="Petugas Arsip">Petugas Arsip</option>
        <option value="Staf Layanan Referensi">Staf Layanan Referensi</option>
    </select>

    <select id="filterPetugasStatus" onchange="liveFilterPetugas()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
        <option value="">Status: Semua</option>
        <option value="Aktif">Aktif</option>
        <option value="Nonaktif">Nonaktif</option>
    </select>

    <button onclick="resetPetugasFilters()" class="bg-[#f8fafc] hover:bg-gray-100 border border-gray-200 text-[#64748b] text-xs font-semibold px-4 py-2 rounded-full flex items-center gap-1.5 transition-all">
        <i class="bi bi-arrow-clockwise"></i>
        <span>Reset</span>
    </button>
</div>

<!-- MAIN GRID (Table & Quick Action) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start mb-6">
    
    <!-- LEFT: Table (8 cols) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center justify-between pb-4 mb-4 border-b border-gray-100">
            <div>
                <h3 class="text-sm font-bold text-[#1e293b]">Daftar Akun Petugas</h3>
                <p class="text-[11px] text-[#64748b] mt-0.5">6 akun staf terdaftar dalam sistem perpustakaan</p>
            </div>
            <select id="sortPetugasSelect" onchange="sortPetugasTable(this.value)" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-3 py-1.5 text-gray-700 focus:outline-none cursor-pointer">
                <option value="terbaru">Urutkan: Terbaru Aktif</option>
                <option value="nama">Nama A-Z</option>
                <option value="role">Role / Jabatan</option>
            </select>
        </div>

        <div class="overflow-x-auto">
            <table id="petugasTable" class="w-full text-left text-xs">
                <thead>
                    <tr class="text-[#64748b] font-semibold border-b border-gray-100">
                        <th class="pb-3.5 pl-2">Petugas</th>
                        <th class="pb-3.5">Username</th>
                        <th class="pb-3.5">Email</th>
                        <th class="pb-3.5">Terakhir Login</th>
                        <th class="pb-3.5 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($petugasList as $idx => $petugas)
                    <tr onclick="selectPetugasForReset(this)" 
                        class="petugas-row hover:bg-slate-50/80 cursor-pointer transition-colors {{ $idx == 0 ? 'bg-[#fcfaff]' : '' }}"
                        data-nama="{{ $petugas['nama'] }}"
                        data-username="{{ $petugas['username'] }}"
                        data-email="{{ $petugas['email'] }}"
                        data-role="{{ $petugas['role'] }}"
                        data-status="{{ $petugas['status'] }}"
                        data-avatar="{{ asset($petugas['avatar']) }}">
                        <!-- Petugas & Role -->
                        <td class="py-4 pl-2 flex items-center gap-3">
                            <img src="{{ asset($petugas['avatar']) }}" 
                                 alt="{{ $petugas['nama'] }}" 
                                 class="w-10 h-10 rounded-full object-cover border border-gray-100 petugas-avatar-img">
                            <div>
                                <p class="font-bold text-[#1e293b] text-xs leading-snug petugas-nama-text">{{ $petugas['nama'] }}</p>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-semibold text-[#554fed] bg-[#eef2ff] petugas-role-text">
                                    {{ $petugas['role'] }}
                                </span>
                            </div>
                        </td>

                        <!-- Username -->
                        <td class="py-4 text-[#475569] font-medium font-mono text-[11px] petugas-user-text">
                            {{ $petugas['username'] }}
                        </td>

                        <!-- Email -->
                        <td class="py-4 text-[#64748b] petugas-email-text">
                            {{ $petugas['email'] }}
                        </td>

                        <!-- Terakhir Login -->
                        <td class="py-4 text-[#64748b]">
                            {{ $petugas['terakhir_login'] }}
                        </td>

                        <!-- Status -->
                        <td class="py-4 text-center">
                            @if($petugas['status'] == 'Aktif')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                Aktif
                            </span>
                            @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2] border border-[#fee2e2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                                Nonaktif
                            </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between pt-4 mt-4 border-t border-gray-100 text-xs text-[#64748b]">
            <p>Menampilkan <span class="font-semibold text-[#1e293b]" id="petugasVisibleRange">1–6</span> dari <span class="font-semibold text-[#1e293b]" id="petugasTotalCount">6</span> petugas</p>
            <div class="flex items-center gap-1.5">
                <button class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 cursor-not-allowed">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-7 h-7 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                <button class="w-7 h-7 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 cursor-not-allowed">
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- RIGHT: Quick Action (Reset Password) (4 cols) -->
    <div class="lg:col-span-4 bg-white rounded-3xl p-6 glass-card">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl bg-[#fef3c7] text-[#d97706] flex items-center justify-center text-lg">
                <i class="bi bi-key"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#1e293b]">Aksi Cepat</h3>
                <p class="text-[11px] text-[#64748b]">Reset Password Petugas</p>
            </div>
        </div>

        <p class="text-xs text-[#64748b] leading-relaxed mb-4">
            Buat kata sandi sementara yang aman untuk staf yang lupa akses login atau memerlukan pembaruan kredensial.
        </p>

        <!-- Selected User Box -->
        <div class="flex items-center justify-between p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4 transition-all duration-200" id="selectedPetugasBox">
            <div class="flex items-center gap-3">
                <img id="resetAvatar" src="{{ asset('images/avatar-budi.png') }}" alt="Petugas" class="w-9 h-9 rounded-full object-cover">
                <div>
                    <p id="resetNama" class="text-xs font-bold text-[#1e293b] leading-tight">Budi Santoso, S.Kom</p>
                    <p id="resetUsername" class="text-[11px] text-[#64748b] font-mono">budi.s</p>
                </div>
            </div>
            <span class="text-[10px] font-semibold text-[#554fed] bg-[#eef2ff] px-2.5 py-1 rounded-full">Dipilih</span>
        </div>

        <!-- Password Generator Input -->
        <div class="mb-3">
            <label class="block text-[11px] font-bold text-[#1e293b] mb-1.5">Kata Sandi Sementara (Acak & Aman)</label>
            <div class="relative">
                <input type="text" 
                       id="tempPasswordInput"
                       value="Perpus#2025!K9mZ" 
                       readonly
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 text-xs font-mono font-bold text-[#1e293b] pr-10 focus:outline-none">
                <button onclick="copyTempPassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#554fed] transition-colors" title="Salin Password">
                    <i class="bi bi-copy text-sm"></i>
                </button>
            </div>
            <p class="flex items-center gap-1.5 text-[10px] text-[#10b981] font-semibold mt-1.5">
                <i class="bi bi-check-circle-fill"></i> Tingkat keamanan: Sangat Kuat (16 Karakter)
            </p>
        </div>

        <!-- Notification Checkbox -->
        <div class="flex items-start gap-2.5 p-3 rounded-2xl bg-[#f8fafc] border border-gray-100 mb-4">
            <input type="checkbox" checked id="notifyEmail" class="mt-0.5 rounded text-[#554fed] focus:ring-[#554fed]">
            <label for="notifyEmail" class="text-xs text-[#1e293b] leading-snug cursor-pointer">
                <span class="font-semibold block">Kirim notifikasi ke email petugas</span>
                <span id="resetEmailNotifyDesc" class="text-[11px] text-[#64748b]">Kredensial baru akan otomatis dikirimkan ke budi.santoso@perpustakaan.go.id</span>
            </label>
        </div>

        <!-- Alert note -->
        <div class="p-3 rounded-2xl bg-[#fffbeb] border border-[#fef3c7] text-[#92400e] text-[11px] flex items-start gap-2 mb-5">
            <i class="bi bi-info-circle-fill text-amber-500 mt-0.5 text-xs"></i>
            <p>Petugas diwajibkan mengganti kata sandi sementara ini saat login pertama kali ke sistem.</p>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-2">
            <button onclick="handleExecuteResetPassword()" id="btnResetPassword" class="flex-1 bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 rounded-full flex items-center justify-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
                <i class="bi bi-arrow-repeat"></i>
                <span>Reset Password</span>
            </button>
            <button onclick="regenerateRandomPassword()" class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-[#64748b] hover:bg-gray-50 transition-all">
                Batal
            </button>
        </div>
    </div>

</div>

<!-- BOTTOM INFO FOOTER -->
<div class="flex flex-wrap items-center justify-between gap-4 text-xs text-[#64748b] pt-2 border-t border-gray-200/60">
    <div class="flex items-center gap-2">
        <i class="bi bi-shield-check text-[#10b981]"></i>
        <span>Semua pergantian kata sandi dan hak akses dicatat dalam <a href="{{ route('log.index') }}" class="text-[#554fed] font-semibold hover:underline">Log Aktivitas Keamanan</a>.</span>
    </div>
    <div>
        <span>Perpustakaan SIM v3.4 • Desain Serene Codex</span>
    </div>
</div>

<!-- MODAL TAMBAH PETUGAS -->
<div id="addPetugasModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Tambah Akun Petugas Baru</h3>
                    <p class="text-xs text-[#64748b]">Daftarkan staf pengelola dan tetapkan hak akses sirkulasi</p>
                </div>
            </div>
            <button onclick="document.getElementById('addPetugasModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <form onsubmit="handleAddNewPetugas(event)" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Nama Lengkap & Gelar</label>
                <input type="text" id="addPetugasNama" placeholder="Contoh: Hendra Kusuma, S.I.Pust" required 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Username Akun</label>
                    <input type="text" id="addPetugasUsername" placeholder="Contoh: hendra.k" required 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Peran / Role</label>
                    <select id="addPetugasRole" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option>Kepala Sirkulasi</option>
                        <option>Staf Inventaris & Katalog</option>
                        <option>Staf Peminjaman & Layanan</option>
                        <option>Staf Pengembalian & Denda</option>
                        <option>Petugas Arsip</option>
                        <option>Staf Layanan Referensi</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Email Kedinasan</label>
                <input type="email" id="addPetugasEmail" placeholder="nama@perpustakaan.go.id" required 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('addPetugasModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                    <i class="bi bi-check-lg"></i>
                    <span>Buat Akun Petugas</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activePetugasEmail = "budi.santoso@perpustakaan.go.id";

    function liveFilterPetugas() {
        const query = (document.getElementById('filterPetugasInput')?.value || document.getElementById('globalPetugasSearch')?.value || '').toLowerCase();
        const role = (document.getElementById('filterPetugasRole')?.value || '').toLowerCase();
        const status = (document.getElementById('filterPetugasStatus')?.value || '').toLowerCase();

        const rows = document.querySelectorAll('.petugas-row');
        let count = 0;

        rows.forEach(row => {
            const nama = (row.getAttribute('data-nama') || '').toLowerCase();
            const username = (row.getAttribute('data-username') || '').toLowerCase();
            const email = (row.getAttribute('data-email') || '').toLowerCase();
            const rRole = (row.getAttribute('data-role') || '').toLowerCase();
            const rStatus = (row.getAttribute('data-status') || '').toLowerCase();

            const matchQuery = nama.includes(query) || username.includes(query) || email.includes(query);
            const matchRole = !role || rRole.includes(role);
            const matchStatus = !status || rStatus.includes(status);

            if (matchQuery && matchRole && matchStatus) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('petugasVisibleRange').textContent = `1–${count}`;
    }

    function resetPetugasFilters() {
        document.getElementById('filterPetugasInput').value = '';
        document.getElementById('filterPetugasRole').value = '';
        document.getElementById('filterPetugasStatus').value = '';
        liveFilterPetugas();
        showToast('Filter pencarian direset.');
    }

    function selectPetugasForReset(row) {
        document.querySelectorAll('.petugas-row').forEach(r => r.classList.remove('bg-[#fcfaff]'));
        row.classList.add('bg-[#fcfaff]');

        const nama = row.getAttribute('data-nama');
        const username = row.getAttribute('data-username');
        const email = row.getAttribute('data-email');
        const avatar = row.getAttribute('data-avatar');
        activePetugasEmail = email;

        document.getElementById('resetAvatar').src = avatar;
        document.getElementById('resetNama').textContent = nama;
        document.getElementById('resetUsername').textContent = username;
        document.getElementById('resetEmailNotifyDesc').textContent = `Kredensial baru akan otomatis dikirimkan ke ${email}`;

        regenerateRandomPassword();
        showToast(`Memilih ${nama} untuk aksi reset kata sandi.`, 'info');
    }

    function regenerateRandomPassword() {
        const chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz23456789!@#$%&*";
        let newPass = "Perpus#" + Math.floor(1000 + Math.random() * 9000) + "!" + chars.charAt(Math.floor(Math.random() * chars.length)) + chars.charAt(Math.floor(Math.random() * chars.length));
        document.getElementById('tempPasswordInput').value = newPass;
    }

    function copyTempPassword() {
        const pass = document.getElementById('tempPasswordInput').value;
        navigator.clipboard?.writeText(pass);
        showToast('Kata sandi acak berhasil disalin ke clipboard!');
    }

    function handleExecuteResetPassword() {
        const btn = document.getElementById('btnResetPassword');
        const nama = document.getElementById('resetNama').textContent;
        const pass = document.getElementById('tempPasswordInput').value;

        btn.disabled = true;
        btn.innerHTML = `<span class="inline-block animate-spin mr-1"><i class="bi bi-arrow-repeat"></i></span> Memproses...`;

        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = `<i class="bi bi-arrow-repeat"></i> <span>Reset Password</span>`;
            showToast(`Kata sandi untuk ${nama} berhasil direset! Kredensial baru telah dikirimkan ke ${activePetugasEmail}`);
        }, 800);
    }

    function sortPetugasTable(criterion) {
        const tbody = document.querySelector('#petugasTable tbody');
        const rows = Array.from(tbody.querySelectorAll('.petugas-row'));

        if (criterion === 'nama') {
            rows.sort((a, b) => a.getAttribute('data-nama').localeCompare(b.getAttribute('data-nama')));
        } else if (criterion === 'role') {
            rows.sort((a, b) => a.getAttribute('data-role').localeCompare(b.getAttribute('data-role')));
        } else {
            // Default reverse
            rows.reverse();
        }

        rows.forEach(r => tbody.appendChild(r));
        showToast(`Daftar petugas diurutkan berdasarkan ${criterion}.`, 'info');
    }

    function handleAddNewPetugas(e) {
        e.preventDefault();
        const nama = document.getElementById('addPetugasNama').value;
        const username = document.getElementById('addPetugasUsername').value;
        const role = document.getElementById('addPetugasRole').value;
        const email = document.getElementById('addPetugasEmail').value;
        const avatar = "{{ asset('images/avatar-budi.png') }}";

        const tbody = document.querySelector('#petugasTable tbody');
        const tr = document.createElement('tr');
        tr.className = 'petugas-row hover:bg-slate-50/80 cursor-pointer transition-colors animate-in fade-in';
        tr.setAttribute('onclick', 'selectPetugasForReset(this)');
        tr.setAttribute('data-nama', nama);
        tr.setAttribute('data-username', username);
        tr.setAttribute('data-email', email);
        tr.setAttribute('data-role', role);
        tr.setAttribute('data-status', 'Aktif');
        tr.setAttribute('data-avatar', avatar);

        tr.innerHTML = `
            <td class="py-4 pl-2 flex items-center gap-3">
                <img src="${avatar}" alt="${nama}" class="w-10 h-10 rounded-full object-cover border border-gray-100 petugas-avatar-img">
                <div>
                    <p class="font-bold text-[#1e293b] text-xs leading-snug petugas-nama-text">${nama}</p>
                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-semibold text-[#554fed] bg-[#eef2ff] petugas-role-text">
                        ${role}
                    </span>
                </div>
            </td>
            <td class="py-4 text-[#475569] font-medium font-mono text-[11px] petugas-user-text">${username}</td>
            <td class="py-4 text-[#64748b] petugas-email-text">${email}</td>
            <td class="py-4 text-[#64748b]">Hari ini, Baru saja</td>
            <td class="py-4 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                    Aktif
                </span>
            </td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
        document.getElementById('addPetugasModal').classList.add('hidden');
        showToast(`Akun petugas baru "${nama}" berhasil dibuat!`);
        selectPetugasForReset(tr);
    }
</script>
@endpush
