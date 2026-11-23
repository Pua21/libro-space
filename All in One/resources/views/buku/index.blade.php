@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
<!-- TOP HEADER BAR -->
<header class="bg-white rounded-3xl p-4 lg:px-6 flex items-center justify-between gap-4 glass-card mb-6">
    <!-- Center Search Input -->
    <div class="relative flex-1 max-w-lg">
        <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
        <input type="text" 
               id="globalBookSearch"
               onkeyup="liveFilterBooks()"
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
                <p class="text-[10px] text-[#64748b] font-medium">Super Administrator</p>
            </div>
            <i class="bi bi-chevron-down text-[10px] text-gray-400 ml-1"></i>
        </div>
    </div>
</header>

<!-- PAGE TITLE & ACTIONS -->
<div class="flex flex-wrap items-center justify-between gap-4 mb-5">
    <div>
        <h2 class="text-2xl font-bold text-[#1e293b] tracking-tight">Data Buku</h2>
        <p class="text-xs text-[#64748b] font-medium mt-0.5">Katalog dan inventaris koleksi buku perpustakaan</p>
    </div>

    <div class="flex items-center gap-3">
        <!-- Button Impor Excel -->
        <button onclick="document.getElementById('importModal').classList.remove('hidden')" 
                class="bg-white hover:bg-gray-50 border border-gray-200 text-xs font-semibold text-[#1e293b] px-4 py-2.5 rounded-full flex items-center gap-2 shadow-sm transition-all">
            <i class="bi bi-file-earmark-excel text-[#10b981] text-sm"></i>
            <span>Impor Excel</span>
        </button>

        <!-- Button Tambah Buku -->
        <button onclick="document.getElementById('addModal').classList.remove('hidden')" 
                class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-plus-lg"></i>
            <span>Tambah Buku</span>
        </button>
    </div>
</div>

<!-- FILTER & SEARCH BAR -->
<div class="bg-white rounded-2xl p-3 glass-card mb-6">
    <div class="flex flex-wrap items-center gap-3">
        <!-- Search -->
        <div class="relative flex-1 min-w-[240px]">
            <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            <input type="text" 
                   id="bookSearchInput"
                   onkeyup="liveFilterBooks()"
                   placeholder="Cari judul, pengarang, atau ISBN..." 
                   class="w-full bg-[#f8fafc] border border-gray-100 rounded-full pl-10 pr-4 py-2.5 text-xs text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 transition-all">
        </div>

        <!-- Filter Kategori -->
        <div class="relative min-w-[160px]">
            <select id="bookCategoryFilter" onchange="liveFilterBooks()" class="w-full appearance-none bg-[#f8fafc] border border-gray-100 text-xs font-medium text-[#1e293b] rounded-full pl-4 pr-9 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach ($kategoriList as $kat)
                    @if($kat != 'Semua Kategori')
                    <option value="{{ $kat }}">{{ $kat }}</option>
                    @endif
                @endforeach
            </select>
            <i class="bi bi-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
        </div>

        <!-- Filter Status -->
        <div class="relative min-w-[140px]">
            <select id="bookStatusFilter" onchange="liveFilterBooks()" class="w-full appearance-none bg-[#f8fafc] border border-gray-100 text-xs font-medium text-[#1e293b] rounded-full pl-4 pr-9 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20 cursor-pointer">
                <option value="">Semua Status</option>
                <option value="Tersedia">Tersedia</option>
                <option value="Dipinjam">Dipinjam</option>
                <option value="Rusak">Rusak</option>
            </select>
            <i class="bi bi-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-gray-400 pointer-events-none"></i>
        </div>

        <!-- Button Terapkan -->
        <button onclick="liveFilterBooks(); showToast('Filter diterapkan.');" class="bg-[#554fed] hover:bg-[#4338ca] text-white text-xs font-bold px-6 py-2.5 rounded-full flex items-center gap-1.5 shadow-md shadow-indigo-500/20 transition-all">
            <i class="bi bi-filter"></i>
            <span>Terapkan</span>
        </button>
    </div>
</div>

<!-- DATA TABLE CONTAINER -->
<div class="bg-white rounded-3xl p-6 glass-card">
    <div class="overflow-x-auto">
        <table id="booksTable" class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-bold text-[#94a3b8] uppercase tracking-wider">
                    <th class="pb-3.5 px-3">Cover</th>
                    <th class="pb-3.5 px-3">Kode</th>
                    <th class="pb-3.5 px-3">Judul</th>
                    <th class="pb-3.5 px-3">Pengarang</th>
                    <th class="pb-3.5 px-3">Kategori</th>
                    <th class="pb-3.5 px-3">Rak</th>
                    <th class="pb-3.5 px-3">Stok</th>
                    <th class="pb-3.5 px-3 text-center">Status</th>
                    <th class="pb-3.5 px-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs">
                @forelse ($buku as $item)
                <tr class="book-row hover:bg-slate-50/60 transition-colors" data-kode="{{ $item['kode'] }}" data-judul="{{ $item['judul'] }}" data-pengarang="{{ $item['pengarang'] }}" data-kategori="{{ $item['kategori'] }}" data-rak="{{ $item['rak'] }}" data-stok="{{ $item['stok'] }}" data-status="{{ $item['status'] }}" data-cover="{{ asset($item['cover']) }}">
                    <!-- Cover -->
                    <td class="py-3 px-3">
                        <img src="{{ asset($item['cover']) }}" 
                             alt="{{ $item['judul'] }}" 
                             class="w-8 h-11 object-cover rounded shadow-sm border border-gray-100 book-cover-img">
                    </td>

                    <!-- Kode -->
                    <td class="py-3 px-3">
                        <span class="font-bold text-[#554fed] book-kode-text">{{ $item['kode'] }}</span>
                    </td>

                    <!-- Judul -->
                    <td class="py-3 px-3 font-bold text-[#1e293b] book-judul-text">
                        {{ $item['judul'] }}
                    </td>

                    <!-- Pengarang -->
                    <td class="py-3 px-3 text-[#64748b] book-pengarang-text">
                        {{ $item['pengarang'] }}
                    </td>

                    <!-- Kategori -->
                    <td class="py-3 px-3 text-[#1e293b] font-medium book-kategori-text">
                        {{ $item['kategori'] }}
                    </td>

                    <!-- Rak -->
                    <td class="py-3 px-3 text-[#64748b] book-rak-text">
                        {{ $item['rak'] }}
                    </td>

                    <!-- Stok -->
                    <td class="py-3 px-3 font-bold text-[#1e293b] book-stok-text">
                        {{ $item['stok'] }}
                    </td>

                    <!-- Status -->
                    <td class="py-3 px-3 text-center book-status-cell">
                        @if ($item['status_type'] == 'success')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                                {{ $item['status'] }}
                            </span>
                        @elseif ($item['status_type'] == 'warning')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>
                                {{ $item['status'] }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>
                                {{ $item['status'] }}
                            </span>
                        @endif
                    </td>

                    <!-- Aksi -->
                    <td class="py-3 px-3 text-center">
                        <div class="inline-flex items-center gap-2">
                            <!-- View -->
                            <button onclick="viewBookDetail(this)" title="Lihat Detail" class="w-8 h-8 rounded-full bg-indigo-50 text-[#554fed] hover:bg-indigo-100 flex items-center justify-center transition-colors">
                                <i class="bi bi-eye text-xs"></i>
                            </button>
                            <!-- Edit -->
                            <button onclick="openEditBookModal(this)" title="Edit Data" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                                <i class="bi bi-pencil text-xs"></i>
                            </button>
                            <!-- Delete -->
                            <button onclick="confirmDeleteBook(this)" title="Hapus Data" class="w-8 h-8 rounded-full bg-red-50 text-[#ef4444] hover:bg-red-100 flex items-center justify-center transition-colors">
                                <i class="bi bi-trash text-xs"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr id="emptyBooksRow">
                    <td colspan="9" class="py-8 text-center text-gray-400">
                        Tidak ada data buku yang sesuai filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div class="flex flex-wrap items-center justify-between gap-4 pt-6 mt-4 border-t border-gray-100 text-xs">
        <p class="text-[#64748b]">
            Menampilkan <span class="font-bold text-[#1e293b]" id="booksVisibleCount">1–6</span> dari <span class="font-bold text-[#1e293b]" id="booksTotalCount">{{ $totalBuku }}</span> buku
        </p>
        <div class="flex items-center gap-1.5">
            <button onclick="showToast('Halaman sebelumnya.');" class="w-7 h-7 rounded-lg text-gray-400 hover:bg-gray-100 flex items-center justify-center font-bold">
                <i class="bi bi-chevron-left text-[10px]"></i>
            </button>
            <button class="w-7 h-7 rounded-lg bg-[#554fed] text-white font-bold flex items-center justify-center shadow-sm">1</button>
            <button onclick="showToast('Membuka halaman 2...');" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">2</button>
            <button onclick="showToast('Membuka halaman 3...');" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">3</button>
            <span class="px-1 text-gray-400">...</span>
            <button class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">209</button>
            <button onclick="showToast('Halaman berikutnya.');" class="w-7 h-7 rounded-lg text-gray-600 hover:bg-gray-100 flex items-center justify-center font-bold">
                <i class="bi bi-chevron-right text-[10px]"></i>
            </button>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH BUKU -->
<div id="addModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Tambah Koleksi Buku</h3>
                    <p class="text-xs text-[#64748b]">Isi formulir lengkap untuk menambahkan buku baru</p>
                </div>
            </div>
            <button onclick="document.getElementById('addModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <form onsubmit="handleAddNewBook(event)" class="space-y-4 text-xs">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Judul Buku</label>
                <input type="text" id="addBookJudul" placeholder="Masukkan judul buku..." required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Pengarang</label>
                    <input type="text" id="addBookPengarang" placeholder="Nama pengarang..." required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Kategori</label>
                    <select id="addBookKategori" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option>Novel</option>
                        <option>Sastra</option>
                        <option>Pengembangan Diri</option>
                        <option>Fiksi Sejarah</option>
                        <option>Sejarah & Sains</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Lokasi Rak</label>
                    <input type="text" id="addBookRak" placeholder="Contoh: Rak A1" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Jumlah Stok</label>
                    <input type="number" id="addBookStok" value="5" min="1" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
            </div>
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                    <i class="bi bi-check-lg"></i>
                    <span>Simpan Buku</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL EDIT BUKU -->
<div id="editBookModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-[#eff1fe] text-[#554fed] flex items-center justify-center text-lg">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div>
                    <h3 class="font-bold text-[#1e293b] text-base">Edit Data Koleksi Buku</h3>
                    <p class="text-xs text-[#64748b]">Perbarui informasi katalog buku</p>
                </div>
            </div>
            <button onclick="document.getElementById('editBookModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <form onsubmit="handleSaveEditedBook(event)" class="space-y-4 text-xs">
            <input type="hidden" id="editBookKode">
            <div>
                <label class="block font-semibold text-[#1e293b] mb-1.5">Judul Buku</label>
                <input type="text" id="editBookJudul" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Pengarang</label>
                    <input type="text" id="editBookPengarang" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#554fed]/20">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Kategori</label>
                    <select id="editBookKategori" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option>Novel</option>
                        <option>Sastra</option>
                        <option>Pengembangan Diri</option>
                        <option>Fiksi Sejarah</option>
                        <option>Sejarah & Sains</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Lokasi Rak</label>
                    <input type="text" id="editBookRak" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Jumlah Stok</label>
                    <input type="number" id="editBookStok" min="0" required class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3.5 py-2.5 focus:outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-[#1e293b] mb-1.5">Status</label>
                    <select id="editBookStatus" class="w-full bg-[#f8fafc] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Rusak">Rusak</option>
                    </select>
                </div>
            </div>
            <div class="pt-4 flex items-center justify-end gap-3 border-t border-gray-100 mt-6">
                <button type="button" onclick="document.getElementById('editBookModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 font-semibold hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="bg-[#554fed] hover:bg-[#4338ca] text-white font-bold px-6 py-2.5 rounded-full shadow-md shadow-indigo-500/20 transition-all flex items-center gap-1.5">
                    <i class="bi bi-floppy"></i>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL DETAIL BUKU -->
<div id="viewBookModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl animate-in fade-in zoom-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
            <h4 class="font-bold text-[#1e293b] text-sm flex items-center gap-2">
                <i class="bi bi-book text-[#554fed]"></i> Detail Informasi Koleksi Buku
            </h4>
            <button onclick="document.getElementById('viewBookModal').classList.add('hidden')" class="w-7 h-7 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <div class="flex gap-4 mb-4">
            <img id="viewBookCover" src="" alt="Cover" class="w-20 h-28 object-cover rounded-xl shadow-md border border-gray-100">
            <div class="space-y-1 text-xs">
                <span id="viewBookKode" class="font-bold text-[#554fed] font-mono text-[11px]">-</span>
                <h3 id="viewBookJudul" class="font-bold text-base text-[#1e293b] leading-tight">-</h3>
                <p id="viewBookPengarang" class="text-gray-500 font-medium">-</p>
                <div class="pt-2 flex items-center gap-2">
                    <span id="viewBookKategori" class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-[#eff1fe] text-[#554fed]">-</span>
                    <span id="viewBookStatus" class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600">-</span>
                </div>
            </div>
        </div>
        <div class="bg-[#f8fafc] p-3 rounded-2xl border border-gray-100 space-y-2 text-xs mb-4">
            <div class="flex justify-between"><span class="text-gray-500">Lokasi Penempatan:</span><span id="viewBookRak" class="font-bold text-gray-700">-</span></div>
            <div class="flex justify-between"><span class="text-gray-500">Stok Tersedia:</span><span id="viewBookStok" class="font-bold text-gray-700">- Eksemplar</span></div>
            <div class="flex justify-between"><span class="text-gray-500">ISBN:</span><span class="font-mono text-gray-700">978-602-06-3317-6</span></div>
        </div>
        <div class="flex justify-end">
            <button onclick="document.getElementById('viewBookModal').classList.add('hidden')" class="bg-[#554fed] text-white text-xs font-bold px-5 py-2 rounded-full">Tutup</button>
        </div>
    </div>
</div>

<!-- MODAL IMPOR EXCEL -->
<div id="importModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md p-6 shadow-2xl">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-5">
            <h3 class="font-bold text-[#1e293b] text-base">Impor Data Buku Excel</h3>
            <button onclick="document.getElementById('importModal').classList.add('hidden')" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
        <div onclick="document.getElementById('excelFileInput').click()" class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center hover:bg-gray-50 cursor-pointer transition-colors">
            <input type="file" id="excelFileInput" accept=".xlsx,.xls,.csv" class="hidden" onchange="handleExcelSelected(this)">
            <i class="bi bi-cloud-arrow-up text-4xl text-[#554fed] mb-2 block"></i>
            <p id="excelFileLabel" class="text-xs font-bold text-[#1e293b]">Pilih file Excel (.xlsx / .xls)</p>
            <p class="text-[11px] text-gray-400 mt-1">atau seret dan lepas file di sini</p>
        </div>
        <div class="pt-4 flex items-center justify-end gap-3 mt-4">
            <button onclick="document.getElementById('importModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-gray-600 text-xs font-semibold hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button onclick="processExcelImport()" class="bg-[#10b981] hover:bg-[#059669] text-white text-xs font-bold px-6 py-2.5 rounded-full shadow-md shadow-emerald-500/20 transition-all">
                Unggah & Proses
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let activeEditingRow = null;

    function liveFilterBooks() {
        const query = (document.getElementById('bookSearchInput')?.value || document.getElementById('globalBookSearch')?.value || '').toLowerCase();
        const cat = document.getElementById('bookCategoryFilter').value.toLowerCase();
        const status = document.getElementById('bookStatusFilter').value.toLowerCase();

        const rows = document.querySelectorAll('.book-row');
        let visibleCount = 0;

        rows.forEach(row => {
            const judul = row.getAttribute('data-judul').toLowerCase();
            const pengarang = row.getAttribute('data-pengarang').toLowerCase();
            const kode = row.getAttribute('data-kode').toLowerCase();
            const rCat = row.getAttribute('data-kategori').toLowerCase();
            const rStatus = row.getAttribute('data-status').toLowerCase();

            const matchQuery = judul.includes(query) || pengarang.includes(query) || kode.includes(query);
            const matchCat = !cat || rCat.includes(cat);
            const matchStatus = !status || rStatus.includes(status);

            if (matchQuery && matchCat && matchStatus) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('booksVisibleCount').textContent = `1–${visibleCount}`;
    }

    function viewBookDetail(btn) {
        const row = btn.closest('tr');
        document.getElementById('viewBookCover').src = row.getAttribute('data-cover');
        document.getElementById('viewBookKode').textContent = row.getAttribute('data-kode');
        document.getElementById('viewBookJudul').textContent = row.getAttribute('data-judul');
        document.getElementById('viewBookPengarang').textContent = row.getAttribute('data-pengarang');
        document.getElementById('viewBookKategori').textContent = row.getAttribute('data-kategori');
        document.getElementById('viewBookRak').textContent = row.getAttribute('data-rak');
        document.getElementById('viewBookStok').textContent = row.getAttribute('data-stok');
        document.getElementById('viewBookStatus').textContent = row.getAttribute('data-status');
        document.getElementById('viewBookModal').classList.remove('hidden');
    }

    function openEditBookModal(btn) {
        activeEditingRow = btn.closest('tr');
        document.getElementById('editBookKode').value = activeEditingRow.getAttribute('data-kode');
        document.getElementById('editBookJudul').value = activeEditingRow.getAttribute('data-judul');
        document.getElementById('editBookPengarang').value = activeEditingRow.getAttribute('data-pengarang');
        document.getElementById('editBookKategori').value = activeEditingRow.getAttribute('data-kategori');
        document.getElementById('editBookRak').value = activeEditingRow.getAttribute('data-rak');
        document.getElementById('editBookStok').value = activeEditingRow.getAttribute('data-stok');
        document.getElementById('editBookStatus').value = activeEditingRow.getAttribute('data-status');
        document.getElementById('editBookModal').classList.remove('hidden');
    }

    function handleSaveEditedBook(e) {
        e.preventDefault();
        if (!activeEditingRow) return;

        const judul = document.getElementById('editBookJudul').value;
        const pengarang = document.getElementById('editBookPengarang').value;
        const kategori = document.getElementById('editBookKategori').value;
        const rak = document.getElementById('editBookRak').value;
        const stok = document.getElementById('editBookStok').value;
        const status = document.getElementById('editBookStatus').value;

        activeEditingRow.setAttribute('data-judul', judul);
        activeEditingRow.setAttribute('data-pengarang', pengarang);
        activeEditingRow.setAttribute('data-kategori', kategori);
        activeEditingRow.setAttribute('data-rak', rak);
        activeEditingRow.setAttribute('data-stok', stok);
        activeEditingRow.setAttribute('data-status', status);

        activeEditingRow.querySelector('.book-judul-text').textContent = judul;
        activeEditingRow.querySelector('.book-pengarang-text').textContent = pengarang;
        activeEditingRow.querySelector('.book-kategori-text').textContent = kategori;
        activeEditingRow.querySelector('.book-rak-text').textContent = rak;
        activeEditingRow.querySelector('.book-stok-text').textContent = stok;

        const statusCell = activeEditingRow.querySelector('.book-status-cell');
        if (status === 'Tersedia') {
            statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5]"><span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>Tersedia</span>`;
        } else if (status === 'Dipinjam') {
            statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#f59e0b] bg-[#fffbeb]"><span class="w-1.5 h-1.5 rounded-full bg-[#f59e0b]"></span>Dipinjam</span>`;
        } else {
            statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#ef4444] bg-[#fef2f2]"><span class="w-1.5 h-1.5 rounded-full bg-[#ef4444]"></span>Rusak</span>`;
        }

        document.getElementById('editBookModal').classList.add('hidden');
        showToast(`Buku "${judul}" berhasil diperbarui!`);
    }

    function confirmDeleteBook(btn) {
        const row = btn.closest('tr');
        const judul = row.getAttribute('data-judul');
        if (confirm(`Apakah Anda yakin ingin menghapus buku "${judul}" dari inventaris?`)) {
            row.style.opacity = '0';
            row.style.transform = 'scale(0.95)';
            setTimeout(() => {
                row.remove();
                showToast(`Buku "${judul}" berhasil dihapus dari inventaris!`, 'warning');
                liveFilterBooks();
            }, 250);
        }
    }

    function handleAddNewBook(e) {
        e.preventDefault();
        const judul = document.getElementById('addBookJudul').value;
        const pengarang = document.getElementById('addBookPengarang').value;
        const kategori = document.getElementById('addBookKategori').value;
        const rak = document.getElementById('addBookRak').value;
        const stok = document.getElementById('addBookStok').value;
        const kode = 'BK-' + String(Math.floor(Math.random() * 900) + 100);

        const tbody = document.querySelector('#booksTable tbody');
        const tr = document.createElement('tr');
        tr.className = 'book-row hover:bg-slate-50/60 transition-colors animate-in fade-in';
        tr.setAttribute('data-kode', kode);
        tr.setAttribute('data-judul', judul);
        tr.setAttribute('data-pengarang', pengarang);
        tr.setAttribute('data-kategori', kategori);
        tr.setAttribute('data-rak', rak);
        tr.setAttribute('data-stok', stok);
        tr.setAttribute('data-status', 'Tersedia');
        tr.setAttribute('data-cover', '{{ asset("images/book-bumi-manusia.png") }}');

        tr.innerHTML = `
            <td class="py-3 px-3">
                <img src="{{ asset('images/book-bumi-manusia.png') }}" alt="${judul}" class="w-8 h-11 object-cover rounded shadow-sm border border-gray-100 book-cover-img">
            </td>
            <td class="py-3 px-3"><span class="font-bold text-[#554fed] book-kode-text">${kode}</span></td>
            <td class="py-3 px-3 font-bold text-[#1e293b] book-judul-text">${judul}</td>
            <td class="py-3 px-3 text-[#64748b] book-pengarang-text">${pengarang}</td>
            <td class="py-3 px-3 text-[#1e293b] font-medium book-kategori-text">${kategori}</td>
            <td class="py-3 px-3 text-[#64748b] book-rak-text">${rak}</td>
            <td class="py-3 px-3 font-bold text-[#1e293b] book-stok-text">${stok}</td>
            <td class="py-3 px-3 text-center book-status-cell">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold text-[#10b981] bg-[#ecfdf5]">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#10b981]"></span>
                    Tersedia
                </span>
            </td>
            <td class="py-3 px-3 text-center">
                <div class="inline-flex items-center gap-2">
                    <button onclick="viewBookDetail(this)" title="Lihat Detail" class="w-8 h-8 rounded-full bg-indigo-50 text-[#554fed] hover:bg-indigo-100 flex items-center justify-center transition-colors">
                        <i class="bi bi-eye text-xs"></i>
                    </button>
                    <button onclick="openEditBookModal(this)" title="Edit Data" class="w-8 h-8 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition-colors">
                        <i class="bi bi-pencil text-xs"></i>
                    </button>
                    <button onclick="confirmDeleteBook(this)" title="Hapus Data" class="w-8 h-8 rounded-full bg-red-50 text-[#ef4444] hover:bg-red-100 flex items-center justify-center transition-colors">
                        <i class="bi bi-trash text-xs"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.insertBefore(tr, tbody.firstChild);
        document.getElementById('addModal').classList.add('hidden');
        showToast(`Buku baru "${judul}" berhasil ditambahkan ke inventaris!`);
    }

    function handleExcelSelected(input) {
        if (input.files && input.files[0]) {
            document.getElementById('excelFileLabel').textContent = input.files[0].name;
            showToast(`File ${input.files[0].name} terpilih.`, 'info');
        }
    }

    function processExcelImport() {
        document.getElementById('importModal').classList.add('hidden');
        showToast('Memproses file Excel...', 'info');
        setTimeout(() => {
            showToast('6 koleksi buku baru berhasil diimpor ke sistem!');
        }, 1000);
    }
</script>
@endpush
