@extends('layouts.app')

@section('title', 'Data Master')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex flex-wrap items-center justify-between gap-4 glass-card mb-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs font-medium text-[#64748b]">
        <span>Manajemen Data</span>
        <i class="bi bi-chevron-right text-[10px]"></i>
        <span class="font-bold text-[#554fed]">Data Master</span>
    </div>

    <!-- Center Search Input -->
    <div class="relative flex-1 max-w-md hidden md:block">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="globalMasterSearch"
               onkeyup="filterMasterTable(this.value)"
               placeholder="Pencarian umum sistem..." 
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
                <p class="text-[10px] text-[#64748b] font-medium">Superadmin</p>
            </div>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

<!-- PAGE TITLE & MASTER TABS -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Master</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Kelola kategori, pengarang, penerbit, dan rak buku perpustakaan.</p>
    </div>

    <!-- Master Tabs -->
    <div class="bg-gray-100/80 p-1.5 rounded-full flex items-center gap-1 text-xs">
        <!-- Tab Kategori -->
        <a href="{{ route('master.index', ['tab' => 'kategori']) }}" 
           class="{{ $tab == 'kategori' ? 'bg-[#554fed] text-white shadow-sm font-semibold' : 'text-[#64748b] hover:text-[#1e293b]' }} px-4 py-2 rounded-full flex items-center gap-2 transition-all">
            <i class="bi bi-folder text-xs"></i>
            <span>Kategori</span>
        </a>

        <!-- Tab Pengarang -->
        <a href="{{ route('master.index', ['tab' => 'pengarang']) }}" 
           class="{{ $tab == 'pengarang' ? 'bg-[#554fed] text-white shadow-sm font-semibold' : 'text-[#64748b] hover:text-[#1e293b]' }} px-4 py-2 rounded-full flex items-center gap-2 transition-all">
            <i class="bi bi-person text-xs"></i>
            <span>Pengarang</span>
        </a>

        <!-- Tab Penerbit -->
        <a href="{{ route('master.index', ['tab' => 'penerbit']) }}" 
           class="{{ $tab == 'penerbit' ? 'bg-[#554fed] text-white shadow-sm font-semibold' : 'text-[#64748b] hover:text-[#1e293b]' }} px-4 py-2 rounded-full flex items-center gap-2 transition-all">
            <i class="bi bi-building text-xs"></i>
            <span>Penerbit</span>
        </a>

        <!-- Tab Rak -->
        <a href="{{ route('master.index', ['tab' => 'rak']) }}" 
           class="{{ $tab == 'rak' ? 'bg-[#554fed] text-white shadow-sm font-semibold' : 'text-[#64748b] hover:text-[#1e293b]' }} px-4 py-2 rounded-full flex items-center gap-2 transition-all">
            <i class="bi bi-grid text-xs"></i>
            <span>Rak</span>
        </a>
    </div>
</div>

<!-- 2-COLUMN GRID (Table Left, Form Right) -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
    <!-- LEFT COLUMN: TABLE -->
    <div class="lg:col-span-7 bg-white rounded-3xl p-6 glass-card">
        <!-- Search & Total Bar -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div class="relative w-full sm:w-64">
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" 
                       id="masterSearchInput"
                       onkeyup="filterMasterTable(this.value)"
                       placeholder="Cari {{ $tab }}..." 
                       class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="text-xs text-[#64748b]">
                Total: <span id="masterTotalLabel" class="font-bold text-[#1e293b]">{{ $totalItems }} {{ ucfirst($tab) }} Terdaftar</span>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="masterDataTable" class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-gray-100 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider">
                        <th class="pb-3 px-3 w-16">No</th>
                        <th class="pb-3 px-3">Nama {{ ucfirst($tab) }}</th>
                        <th class="pb-3 px-3">Jumlah Buku</th>
                        <th class="pb-3 px-3 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-xs">
                    @php
                        $list = match($tab) {
                            'pengarang' => $pengarang,
                            'penerbit' => $penerbit,
                            'rak' => $rak,
                            default => $kategori
                        };
                    @endphp

                    @foreach ($list as $item)
                    <tr class="master-row hover:bg-slate-50/60 transition-colors" data-name="{{ $item['nama'] }}">
                        <!-- No -->
                        <td class="py-4 px-3 text-[#64748b] font-medium item-no-cell">
                            {{ $item['no'] }}
                        </td>

                        <!-- Nama Kategori -->
                        <td class="py-4 px-3">
                            <div class="flex items-center gap-2.5">
                                <span class="w-2 h-2 rounded-full bg-[#554fed]"></span>
                                <span class="font-bold text-[#1e293b] item-name-text">{{ $item['nama'] }}</span>
                            </div>
                        </td>

                        <!-- Jumlah Buku -->
                        <td class="py-4 px-3">
                            <div class="inline-flex items-center gap-2 text-[#554fed] font-semibold bg-indigo-50/60 px-3 py-1 rounded-full">
                                <i class="bi bi-book"></i>
                                <span>{{ $item['jumlah'] }}</span>
                            </div>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-3 text-center">
                            <div class="inline-flex items-center gap-2">
                                <button onclick="editMasterRow(this)" title="Edit" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                    <i class="bi bi-pencil text-xs"></i>
                                </button>
                                <button onclick="deleteMasterRow(this)" title="Hapus" class="w-8 h-8 rounded-full bg-red-50 text-[#ef4444] hover:bg-red-100 flex items-center justify-center transition-colors">
                                    <i class="bi bi-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Note Callout Box -->
        <div class="mt-6 p-4 rounded-2xl bg-[#f0f4ff] border border-indigo-100 flex items-start gap-3 text-xs text-[#3730a3]">
            <i class="bi bi-info-circle text-[#554fed] text-base shrink-0 mt-0.5"></i>
            <div>
                <span class="font-bold">Catatan:</span> {{ ucfirst($tab) }} yang masih terhubung dengan data buku aktif tidak dapat dihapus dari sistem.
            </div>
        </div>

        <!-- Table Pagination Footer -->
        <div class="flex flex-wrap items-center justify-between gap-4 pt-5 mt-4 border-t border-gray-100 text-xs">
            <p class="text-[#64748b]">Menampilkan <span class="font-bold text-[#1e293b]" id="masterVisibleCount">1–6</span> dari <span class="font-bold text-[#1e293b]" id="masterTotalNum">{{ $totalItems }}</span> {{ $tab }}</p>
            <div class="flex items-center gap-1.5">
                <button onclick="showToast('Halaman sebelumnya.');" class="w-7 h-7 rounded-lg text-gray-400 hover:bg-gray-100 flex items-center justify-center font-bold">
                    <i class="bi bi-chevron-left text-[10px]"></i>
                </button>
                <button class="w-7 h-7 rounded-lg bg-[#554fed] text-white font-bold flex items-center justify-center shadow-sm">1</button>
                <button onclick="showToast('Membuka halaman 2...');" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">2</button>
                <button onclick="showToast('Membuka halaman 3...');" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">3</button>
                <button onclick="showToast('Halaman berikutnya.');" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">
                    <i class="bi bi-chevron-right text-[10px]"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN: FORM TAMBAH -->
    <div class="lg:col-span-5 bg-white rounded-3xl p-6 glass-card">
        <!-- Form Header -->
        <div class="flex items-start gap-3 mb-6">
            <div class="w-8 h-8 rounded-full bg-indigo-50 text-[#554fed] flex items-center justify-center text-sm shrink-0 mt-0.5">
                <i class="bi bi-plus-circle"></i>
            </div>
            <div>
                <h3 id="masterFormHeading" class="font-bold text-base text-[#1e293b]">Tambah {{ ucfirst($tab) }}</h3>
                <p id="masterFormSubtext" class="text-xs text-[#64748b] mt-0.5">Tambahkan {{ $tab }} buku baru ke sistem.</p>
            </div>
        </div>

        <!-- Form Body -->
        <form id="masterDataForm" onsubmit="handleMasterFormSubmit(event)" class="space-y-5 text-xs">
            <div>
                <label class="block font-bold text-[#1e293b] mb-2">Nama {{ ucfirst($tab) }}</label>
                <input type="text" 
                       id="inputMasterName"
                       placeholder="Contoh: {{ $tab == 'kategori' ? 'Ensiklopedia' : ($tab == 'pengarang' ? 'Tere Liye' : ($tab == 'penerbit' ? 'Erlangga' : 'Rak D1')) }}" 
                       required
                       class="w-full bg-[#f8fafc] border border-gray-100 rounded-2xl px-4 py-3 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all">
            </div>

            <div>
                <label class="block font-bold text-[#1e293b] mb-2">Deskripsi {{ ucfirst($tab) }} (Opsional)</label>
                <textarea id="inputMasterDesc"
                          rows="4" 
                          placeholder="Tulis keterangan singkat {{ $tab }}..." 
                          class="w-full bg-[#f8fafc] border border-gray-100 rounded-2xl p-4 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 focus:border-[#554fed] transition-all"></textarea>
            </div>

            <!-- Helpful Callout Box -->
            <div class="p-4 rounded-2xl bg-[#f0f9ff] border border-sky-100 flex items-start gap-3 text-xs text-[#0369a1]">
                <i class="bi bi-lightbulb text-sky-600 text-base shrink-0 mt-0.5"></i>
                <p class="leading-relaxed">
                    Nama {{ $tab }} yang jelas memudahkan pengelompokan pada pencarian katalog online anggota.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" 
                        id="btnSubmitMaster"
                        class="flex-1 bg-[#554fed] hover:bg-[#4338ca] text-white font-bold py-3 px-5 rounded-full shadow-md shadow-indigo-500/20 flex items-center justify-center gap-1.5 transition-all">
                    <i class="bi bi-check-circle"></i>
                    <span id="btnSubmitMasterText">Simpan {{ ucfirst($tab) }}</span>
                </button>
                <button type="button" 
                        onclick="resetMasterForm()"
                        class="bg-white hover:bg-gray-50 border border-gray-200 text-gray-600 font-semibold py-3 px-6 rounded-full transition-all">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeEditingMasterRow = null;
    const currentTab = "{{ $tab }}";

    function filterMasterTable(query) {
        const q = (query || '').toLowerCase();
        const rows = document.querySelectorAll('.master-row');
        let count = 0;
        rows.forEach(row => {
            const name = (row.getAttribute('data-name') || '').toLowerCase();
            if (name.includes(q)) {
                row.style.display = '';
                count++;
            } else {
                row.style.display = 'none';
            }
        });
        document.getElementById('masterVisibleCount').textContent = `1–${count}`;
    }

    function editMasterRow(btn) {
        activeEditingMasterRow = btn.closest('tr');
        const name = activeEditingMasterRow.querySelector('.item-name-text').textContent.trim();
        document.getElementById('inputMasterName').value = name;
        document.getElementById('masterFormHeading').textContent = `Edit ${currentTab.charAt(0).toUpperCase() + currentTab.slice(1)}`;
        document.getElementById('masterFormSubtext').textContent = `Perbarui data ${currentTab} terpilih.`;
        document.getElementById('btnSubmitMasterText').textContent = `Perbarui ${currentTab.charAt(0).toUpperCase() + currentTab.slice(1)}`;
        document.getElementById('inputMasterName').focus();
        showToast(`Memuat data "${name}" ke formulir editor.`);
    }

    function deleteMasterRow(btn) {
        const row = btn.closest('tr');
        const name = row.querySelector('.item-name-text').textContent.trim();
        if (confirm(`Apakah Anda yakin ingin menghapus data master "${name}"?`)) {
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                showToast(`Data "${name}" berhasil dihapus!`, 'warning');
            }, 200);
        }
    }

    function handleMasterFormSubmit(e) {
        e.preventDefault();
        const name = document.getElementById('inputMasterName').value.trim();
        if (!name) return;

        if (activeEditingMasterRow) {
            // Update existing
            activeEditingMasterRow.querySelector('.item-name-text').textContent = name;
            activeEditingMasterRow.setAttribute('data-name', name);
            showToast(`Data ${currentTab} "${name}" berhasil diperbarui!`);
            resetMasterForm();
        } else {
            // Add new
            const tbody = document.querySelector('#masterDataTable tbody');
            const rowCount = tbody.querySelectorAll('tr').length + 1;
            const noStr = rowCount < 10 ? '0' + rowCount : rowCount;

            const tr = document.createElement('tr');
            tr.className = 'master-row hover:bg-slate-50/60 transition-colors animate-in fade-in';
            tr.setAttribute('data-name', name);
            tr.innerHTML = `
                <td class="py-4 px-3 text-[#64748b] font-medium item-no-cell">${noStr}</td>
                <td class="py-4 px-3">
                    <div class="flex items-center gap-2.5">
                        <span class="w-2 h-2 rounded-full bg-[#554fed]"></span>
                        <span class="font-bold text-[#1e293b] item-name-text">${name}</span>
                    </div>
                </td>
                <td class="py-4 px-3">
                    <div class="inline-flex items-center gap-2 text-[#554fed] font-semibold bg-indigo-50/60 px-3 py-1 rounded-full">
                        <i class="bi bi-book"></i>
                        <span>0 Buku</span>
                    </div>
                </td>
                <td class="py-4 px-3 text-center">
                    <div class="inline-flex items-center gap-2">
                        <button onclick="editMasterRow(this)" title="Edit" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                            <i class="bi bi-pencil text-xs"></i>
                        </button>
                        <button onclick="deleteMasterRow(this)" title="Hapus" class="w-8 h-8 rounded-full bg-red-50 text-[#ef4444] hover:bg-red-100 flex items-center justify-center transition-colors">
                            <i class="bi bi-trash text-xs"></i>
                        </button>
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
            showToast(`${currentTab.charAt(0).toUpperCase() + currentTab.slice(1)} "${name}" berhasil ditambahkan!`);
            resetMasterForm();
        }
    }

    function resetMasterForm() {
        activeEditingMasterRow = null;
        document.getElementById('masterDataForm').reset();
        document.getElementById('masterFormHeading').textContent = `Tambah ${currentTab.charAt(0).toUpperCase() + currentTab.slice(1)}`;
        document.getElementById('masterFormSubtext').textContent = `Tambahkan ${currentTab} buku baru ke sistem.`;
        document.getElementById('btnSubmitMasterText').textContent = `Simpan ${currentTab.charAt(0).toUpperCase() + currentTab.slice(1)}`;
    }
</script>
@endpush
