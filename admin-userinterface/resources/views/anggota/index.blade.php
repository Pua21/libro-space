@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <!-- Center Search Input -->
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="globalAnggotaSearch"
               onkeyup="liveFilterAnggota()"
               placeholder="Cari buku, anggota, atau transaksi..." 
               class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-11 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all">
    </div>

    <!-- Right Icons & Profile -->
    <div class="flex items-center gap-3">
        <!-- Notification Bell -->
        <button class="relative w-10 h-10 rounded-full bg-[#f8fafc] hover:bg-gray-100 flex items-center justify-center text-gray-600 transition-all border border-gray-100">
            <i class="bi bi-bell text-base"></i>
            <span class="absolute top-2 right-2 w-2 h-2 bg-[#f43f5e] rounded-full ring-2 ring-white"></span>
        </button>

        <!-- User Profile Pill -->
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
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Anggota</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Kelola data keanggotaan dan pembuatan kartu anggota perpustakaan</p>
    </div>

    <div class="flex items-center gap-3">
        <!-- Button Ekspor Data -->
        <button onclick="exportAnggotaData()" class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-download text-gray-600"></i>
            <span>Ekspor Data</span>
        </button>

        <!-- Button Tambah Anggota -->
        <button onclick="document.getElementById('addAnggotaModal').classList.remove('hidden')" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-person-plus text-sm"></i>
            <span>+ Tambah Anggota</span>
        </button>
    </div>
</div>

<!-- MAIN GRID (Table & Digital Card) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    
    <!-- LEFT COLUMN: Filter & Table (8 cols) -->
    <div class="lg:col-span-8 space-y-6">
        
        <!-- Filter Bar -->
        <div class="bg-white rounded-3xl p-4 glass-card flex flex-wrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       id="filterAnggotaInput"
                       onkeyup="liveFilterAnggota()"
                       placeholder="Cari nama, nomor anggota, atau jurusan..." 
                       class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>

            <select id="filterAnggotaStatus" onchange="liveFilterAnggota()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="Aktif">Aktif</option>
                <option value="Nonaktif">Nonaktif</option>
            </select>

            <select id="filterAnggotaJurusan" onchange="liveFilterAnggota()" class="bg-[#f8fafc] border border-gray-100 text-xs rounded-full px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                <option value="">Semua Jurusan/Kelas</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Akuntansi">Akuntansi</option>
                <option value="Manajemen">Manajemen</option>
                <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
            </select>

            <button onclick="liveFilterAnggota(); showToast('Filter anggota diterapkan.');" class="bg-[#eff1fe] text-[#554fed] font-semibold text-xs px-5 py-2 rounded-full hover:bg-[#e0e4fd] transition-all">
                Terapkan
            </button>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="overflow-x-auto">
                <table id="anggotaTable" class="w-full text-left text-xs">
                    <thead>
                        <tr class="text-[#64748b] border-b border-gray-100 font-semibold">
                            <th class="pb-3.5 pl-2">Anggota</th>
                            <th class="pb-3.5">No. Anggota</th>
                            <th class="pb-3.5">Kelas/Jurusan</th>
                            <th class="pb-3.5">Kontak</th>
                            <th class="pb-3.5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($anggotaList as $idx => $anggota)
                        <tr onclick="selectAnggotaForPreview(this)" 
                            class="anggota-row hover:bg-slate-50/80 cursor-pointer transition-colors {{ $idx == 0 ? 'bg-[#fcfaff]' : '' }}"
                            data-id="{{ $anggota['id'] }}"
                            data-nama="{{ $anggota['nama'] }}"
                            data-jurusan="{{ $anggota['jurusan'] }}"
                            data-email="{{ $anggota['email'] }}"
                            data-kontak="{{ $anggota['kontak'] }}"
                            data-status="{{ $anggota['status'] }}"
                            data-avatar="{{ asset($anggota['avatar']) }}"
                            data-pinjam="{{ $anggota['total_pinjam'] }}"
                            data-denda="{{ $anggota['status_denda'] }}"
                            data-registrasi="{{ $anggota['tgl_registrasi'] }}"
                            data-berlaku="{{ $anggota['masa_berlaku'] }}">
                            <!-- Anggota -->
                            <td class="py-4 pl-2 flex items-center gap-3">
                                <img src="{{ asset($anggota['avatar']) }}" 
                                     alt="{{ $anggota['nama'] }}" 
                                     class="w-10 h-10 rounded-full object-cover border border-gray-100 anggota-avatar-thumb">
                                <div>
                                    <p class="font-bold text-[#1e293b] text-xs leading-snug anggota-nama-text">{{ $anggota['nama'] }}</p>
                                    <p class="text-[11px] text-[#64748b] font-normal">{{ $anggota['email'] }}</p>
                                </div>
                            </td>

                            <!-- No. Anggota -->
                            <td class="py-4 font-bold text-[#1e293b] anggota-id-text">
                                {{ $anggota['id'] }}
                            </td>

                            <!-- Kelas/Jurusan -->
                            <td class="py-4 text-[#475569] font-medium anggota-jurusan-text">
                                {{ $anggota['jurusan'] }}
                            </td>

                            <!-- Kontak -->
                            <td class="py-4 text-[#64748b]">
                                {{ $anggota['kontak'] }}
                            </td>

                            <!-- Status -->
                            <td class="py-4 text-center anggota-status-cell">
                                @if($anggota['status'] == 'Aktif')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                    Aktif
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb] border border-[#fef3c7]">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                                    Nonaktif
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination Footer -->
            <div class="flex flex-wrap items-center justify-between gap-4 mt-6 pt-4 border-t border-gray-100 text-xs text-[#64748b]">
                <p>Menampilkan <span class="font-semibold text-[#1e293b]" id="anggotaVisibleRange">1–6</span> dari <span class="font-semibold text-[#1e293b]" id="anggotaTotalNum">342</span> anggota</p>
                <div class="flex items-center gap-1.5">
                    <button onclick="showToast('Halaman sebelumnya.');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                        <i class="bi bi-chevron-left text-[10px]"></i>
                    </button>
                    <button class="w-8 h-8 rounded-full bg-[#554fed] text-white font-semibold flex items-center justify-center shadow-sm">1</button>
                    <button onclick="showToast('Membuka halaman 2...');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">2</button>
                    <button onclick="showToast('Membuka halaman 3...');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">3</button>
                    <span class="px-1 text-gray-400">...</span>
                    <button class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-[#1e293b] hover:bg-gray-50 transition-all font-medium">57</button>
                    <button onclick="showToast('Halaman berikutnya.');" class="w-8 h-8 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50 transition-all">
                        <i class="bi bi-chevron-right text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>

    </div>

    <!-- RIGHT COLUMN: Preview Card & Summary (4 cols) -->
    <div class="lg:col-span-4 space-y-6">
        
        <!-- Preview Kartu Anggota Digital -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <i class="bi bi-person-vcard text-[#554fed] text-lg"></i>
                    <h3 class="text-sm font-bold text-[#1e293b]">Preview Kartu Anggota Digital</h3>
                </div>
                <span id="previewCardStatus" class="text-[11px] font-semibold text-[#6366f1] bg-[#eef2ff] px-2.5 py-0.5 rounded-full">Aktif</span>
            </div>

            <!-- Digital ID Card Graphic -->
            <div id="printableIdCard" class="bg-gradient-to-tr from-[#4338ca] via-[#554fed] to-[#6d66ff] rounded-2xl p-5 text-white shadow-lg shadow-indigo-500/20 mb-5 relative overflow-hidden transition-all duration-300">
                <!-- Watermark circle pattern -->
                <div class="absolute -right-6 -bottom-6 w-32 h-32 rounded-full bg-white/10 blur-xl pointer-events-none"></div>

                <!-- Card Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-white/20 flex items-center justify-center text-sm">
                            <i class="bi bi-book"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-bold tracking-wider uppercase leading-none">Perpustakaan Pusat</p>
                            <p class="text-[9px] text-white/80">Universitas Kebangsaan</p>
                        </div>
                    </div>
                    <span class="text-[9px] font-bold bg-white/20 px-2 py-0.5 rounded tracking-wide">MAHASISWA</span>
                </div>

                <!-- Card Body -->
                <div class="flex items-center gap-3.5 my-3">
                    <img id="cardPreviewPhoto" 
                         src="{{ asset($selectedAnggota['avatar']) }}" 
                         alt="{{ $selectedAnggota['nama'] }}" 
                         class="w-14 h-14 rounded-full object-cover ring-2 ring-white/60 shadow">
                    <div>
                        <h4 id="cardPreviewName" class="font-bold text-sm tracking-tight leading-snug">{{ $selectedAnggota['nama'] }}</h4>
                        <p id="cardPreviewMajor" class="text-[11px] text-white/80 font-medium">{{ $selectedAnggota['jurusan'] }}</p>
                        <p class="text-[10px] tracking-wider font-semibold text-indigo-100 mt-1">NO. ANGGOTA</p>
                        <p id="cardPreviewId" class="text-xs font-bold tracking-wide leading-none">{{ $selectedAnggota['id'] }}</p>
                    </div>
                </div>

                <!-- Card Footer -->
                <div class="flex items-end justify-between pt-3 border-t border-white/20 mt-3">
                    <div>
                        <p class="text-[9px] text-white/70 leading-none">MASA BERLAKU</p>
                        <p id="cardPreviewExpiry" class="text-[11px] font-bold tracking-wide mt-0.5">{{ $selectedAnggota['masa_berlaku'] }}</p>
                    </div>
                    <div class="w-8 h-8 bg-white rounded-lg p-1 flex items-center justify-center shadow">
                        <i class="bi bi-qr-code text-[#1e293b] text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Member Info List -->
            <div class="space-y-2.5 text-xs pb-4 border-b border-gray-100 mb-4">
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Total Pinjaman Buku</span>
                    <span id="previewTotalPinjam" class="font-bold text-[#1e293b]">{{ $selectedAnggota['total_pinjam'] }} Buku</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Status Denda</span>
                    <span id="previewStatusDenda" class="font-bold text-[#10b981]">{{ $selectedAnggota['status_denda'] }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-[#64748b]">Tanggal Registrasi</span>
                    <span id="previewTglReg" class="font-medium text-[#1e293b]">{{ $selectedAnggota['tgl_registrasi'] }}</span>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <button onclick="printDigitalCard()" class="flex-1 bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold py-2.5 rounded-full flex items-center justify-center gap-2 shadow-md shadow-indigo-500/20 transition-all">
                    <i class="bi bi-printer text-sm"></i>
                    <span>Cetak Kartu</span>
                </button>
                <button onclick="shareMemberCard()" title="Bagikan Kartu" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-gray-500 hover:text-[#554fed] hover:bg-gray-50 transition-all">
                    <i class="bi bi-share text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Ringkasan Anggota -->
        <div class="bg-white rounded-3xl p-6 glass-card">
            <h3 class="text-sm font-bold text-[#1e293b] mb-4">Ringkasan Anggota</h3>
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-[#f8fafc] rounded-2xl p-4 text-center border border-gray-100">
                    <p class="text-[11px] text-[#64748b] font-medium">Total Anggota</p>
                    <h4 class="text-2xl font-extrabold text-[#554fed] mt-1">{{ $summary['total'] }}</h4>
                    <span class="inline-block text-[10px] text-[#10b981] font-semibold mt-1">{{ $summary['total_growth'] }}</span>
                </div>
                <div class="bg-[#f8fafc] rounded-2xl p-4 text-center border border-gray-100">
                    <p class="text-[11px] text-[#64748b] font-medium">Anggota Aktif</p>
                    <h4 class="text-2xl font-extrabold text-[#1e293b] mt-1">{{ $summary['aktif'] }}</h4>
                    <span class="inline-block text-[10px] text-[#64748b] font-semibold mt-1">{{ $summary['aktif_percent'] }}</span>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- MODAL TAMBAH ANGGOTA -->
<div id="addAnggotaModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-person-plus"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Registrasi Anggota Baru</h3>
                    <p class="text-xs text-[#64748b]">Daftarkan mahasiswa atau civitas akademika</p>
                </div>
            </div>
            <button onclick="document.getElementById('addAnggotaModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <form onsubmit="handleAddNewAnggota(event)" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Nama Lengkap</label>
                <input type="text" id="addAnggotaNama" placeholder="Nama mahasiswa lengkap..." required 
                       class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">NIM / No. Anggota</label>
                    <input type="text" id="addAnggotaId" placeholder="Contoh: AGT-0007" required 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Jurusan / Kelas</label>
                    <select id="addAnggotaJurusan" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option>Sistem Informasi</option>
                        <option>Teknik Informatika</option>
                        <option>Akuntansi</option>
                        <option>Manajemen</option>
                        <option>Ilmu Komunikasi</option>
                        <option>Desain Komunikasi Visual</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Email Kampus</label>
                    <input type="email" id="addAnggotaEmail" placeholder="nama@univ.ac.id" required 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Nomor WhatsApp / HP</label>
                    <input type="text" id="addAnggotaKontak" placeholder="0812-xxxx-xxxx" required 
                           class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
            </div>
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('addAnggotaModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                    <i class="bi bi-check-lg"></i>
                    <span>Daftarkan Anggota</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function liveFilterAnggota() {
        const query = (document.getElementById('filterAnggotaInput')?.value || document.getElementById('globalAnggotaSearch')?.value || '').toLowerCase();
        const status = (document.getElementById('filterAnggotaStatus')?.value || '').toLowerCase();
        const jurusan = (document.getElementById('filterAnggotaJurusan')?.value || '').toLowerCase();

        const rows = document.querySelectorAll('.anggota-row');
        let count = 0;

        rows.forEach(row => {
            const nama = (row.getAttribute('data-nama') || '').toLowerCase();
            const id = (row.getAttribute('data-id') || '').toLowerCase();
            const rJurusan = (row.getAttribute('data-jurusan') || '').toLowerCase();
            const rStatus = (row.getAttribute('data-status') || '').toLowerCase();

            const matchQuery = nama.includes(query) || id.includes(query) || rJurusan.includes(query);
            const matchStatus = !status || rStatus.includes(status);
            const matchJurusan = !jurusan || rJurusan.includes(jurusan);

            if (matchQuery && matchStatus && matchJurusan) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('anggotaVisibleRange').textContent = `1–${count}`;
    }

    function selectAnggotaForPreview(row) {
        document.querySelectorAll('.anggota-row').forEach(r => r.classList.remove('bg-[#fcfaff]'));
        row.classList.add('bg-[#fcfaff]');

        const nama = row.getAttribute('data-nama');
        const id = row.getAttribute('data-id');
        const jurusan = row.getAttribute('data-jurusan');
        const avatar = row.getAttribute('data-avatar');
        const status = row.getAttribute('data-status');
        const pinjam = row.getAttribute('data-pinjam');
        const denda = row.getAttribute('data-denda');
        const registrasi = row.getAttribute('data-registrasi');
        const berlaku = row.getAttribute('data-berlaku');

        document.getElementById('cardPreviewPhoto').src = avatar;
        document.getElementById('cardPreviewName').textContent = nama;
        document.getElementById('cardPreviewMajor').textContent = jurusan;
        document.getElementById('cardPreviewId').textContent = id;
        document.getElementById('cardPreviewExpiry').textContent = berlaku;
        document.getElementById('previewCardStatus').textContent = status;
        document.getElementById('previewTotalPinjam').textContent = `${pinjam} Buku`;
        document.getElementById('previewStatusDenda').textContent = denda;
        document.getElementById('previewTglReg').textContent = registrasi;

        showToast(`Menampilkan kartu digital untuk ${nama}.`, 'info');
    }

    function printDigitalCard() {
        const name = document.getElementById('cardPreviewName').textContent;
        showToast(`Mempersiapkan cetak kartu anggota ${name}...`);
        setTimeout(() => {
            window.print();
        }, 300);
    }

    function shareMemberCard() {
        const id = document.getElementById('cardPreviewId').textContent;
        const name = document.getElementById('cardPreviewName').textContent;
        navigator.clipboard?.writeText(window.location.origin + `/data-anggota?id=${id}`);
        showToast(`Tautan kartu anggota ${name} (${id}) berhasil disalin ke clipboard!`);
    }

    function exportAnggotaData() {
        const rows = document.querySelectorAll('.anggota-row');
        let csv = "No Anggota,Nama,Jurusan,Kontak,Status\n";
        rows.forEach(r => {
            csv += `"${r.getAttribute('data-id')}","${r.getAttribute('data-nama')}","${r.getAttribute('data-jurusan')}","${r.getAttribute('data-kontak')}","${r.getAttribute('data-status')}"\n`;
        });
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = "data_anggota_perpustakaan.csv";
        a.click();
        window.URL.revokeObjectURL(url);
        showToast('Data anggota berhasil diekspor ke format CSV!');
    }

    function handleAddNewAnggota(e) {
        e.preventDefault();
        const nama = document.getElementById('addAnggotaNama').value;
        const id = document.getElementById('addAnggotaId').value;
        const jurusan = document.getElementById('addAnggotaJurusan').value;
        const email = document.getElementById('addAnggotaEmail').value;
        const kontak = document.getElementById('addAnggotaKontak').value;
        const avatar = "{{ asset('images/avatar-nabila.png') }}";

        const tbody = document.querySelector('#anggotaTable tbody');
        const tr = document.createElement('tr');
        tr.className = 'anggota-row hover:bg-slate-50/80 cursor-pointer transition-colors animate-in fade-in';
        tr.setAttribute('onclick', 'selectAnggotaForPreview(this)');
        tr.setAttribute('data-id', id);
        tr.setAttribute('data-nama', nama);
        tr.setAttribute('data-jurusan', jurusan);
        tr.setAttribute('data-email', email);
        tr.setAttribute('data-kontak', kontak);
        tr.setAttribute('data-status', 'Aktif');
        tr.setAttribute('data-avatar', avatar);
        tr.setAttribute('data-pinjam', '0');
        tr.setAttribute('data-denda', 'Tidak Ada (Lunas)');
        tr.setAttribute('data-registrasi', 'Hari Ini');
        tr.setAttribute('data-berlaku', '31 Des 2026');

        tr.innerHTML = `
            <td class="py-4 pl-2 flex items-center gap-3">
                <img src="${avatar}" alt="${nama}" class="w-10 h-10 rounded-full object-cover border border-gray-100 anggota-avatar-thumb">
                <div>
                    <p class="font-bold text-[#1e293b] text-xs leading-snug anggota-nama-text">${nama}</p>
                    <p class="text-[11px] text-[#64748b] font-normal">${email}</p>
                </div>
            </td>
            <td class="py-4 font-bold text-[#1e293b] anggota-id-text">${id}</td>
            <td class="py-4 text-[#475569] font-medium anggota-jurusan-text">${jurusan}</td>
            <td class="py-4 text-[#64748b]">${kontak}</td>
            <td class="py-4 text-center anggota-status-cell">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5] border border-[#d1fae5]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                    Aktif
                </span>
            </td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
        document.getElementById('addAnggotaModal').classList.add('hidden');
        showToast(`Anggota "${nama}" (${id}) berhasil didaftarkan!`);
        selectAnggotaForPreview(tr);
    }
</script>
@endpush
