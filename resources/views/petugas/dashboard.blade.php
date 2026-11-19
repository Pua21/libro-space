
@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')
@section('page-heading', 'Dashboard')

@section('content')

    <!-- SAPAAN -->
    <div class="mb-7">
        <h1 class="text-2xl font-bold text-slate-800">
            Selamat datang, Petugas! 👋
        </h1>
        <p class="mt-1 text-sm text-slate-500">
            Berikut ringkasan aktivitas perpustakaan hari ini.
        </p>
    </div>

    <!-- KARTU STATISTIK -->
    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        <!-- TOTAL BUKU -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-xl text-indigo-600">
                    📚
                </div>
                <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600">
                    Koleksi
                </span>
            </div>
            <p class="mt-5 text-sm font-medium text-slate-500">Total Buku</p>
            <h3 class="mt-1 text-3xl font-bold text-slate-800">1.250</h3>
            <p class="mt-2 text-xs text-slate-400">Jumlah seluruh koleksi buku</p>
        </div>

        <!-- TOTAL ANGGOTA -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-xl text-emerald-600">
                    👥
                </div>
                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                    Anggota
                </span>
            </div>
            <p class="mt-5 text-sm font-medium text-slate-500">Total Anggota</p>
            <h3 class="mt-1 text-3xl font-bold text-slate-800">342</h3>
            <p class="mt-2 text-xs text-slate-400">Anggota terdaftar di perpustakaan</p>
        </div>

        <!-- PEMINJAMAN AKTIF -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-xl text-violet-600">
                    📖
                </div>
                <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-semibold text-violet-600">
                    Berlangsung
                </span>
            </div>
            <p class="mt-5 text-sm font-medium text-slate-500">Peminjaman Aktif</p>
            <h3 class="mt-1 text-3xl font-bold text-slate-800">24</h3>
            <p class="mt-2 text-xs text-slate-400">Buku yang sedang dipinjam</p>
        </div>

        <!-- MENUNGGU KONFIRMASI -->
        <div class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-xl text-amber-600">
                    🕒
                </div>
                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600">
                    Perlu dicek
                </span>
            </div>
            <p class="mt-5 text-sm font-medium text-slate-500">Menunggu Konfirmasi</p>
            <h3 class="mt-1 text-3xl font-bold text-slate-800">5</h3>
            <p class="mt-2 text-xs text-slate-400">Permintaan peminjaman baru</p>
        </div>

    </div>

    <!-- AKTIVITAS DAN KETERLAMBATAN -->
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        <!-- AKTIVITAS TERBARU -->
        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm xl:col-span-2">

            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800">Aktivitas Terbaru</h3>
                    <p class="mt-1 text-xs text-slate-400">
                        Aktivitas peminjaman dan pengembalian buku
                    </p>
                </div>
                <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                    Lihat semua
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs text-slate-400">
                            <th class="whitespace-nowrap px-3 py-3 font-medium">Anggota</th>
                            <th class="whitespace-nowrap px-3 py-3 font-medium">Aktivitas</th>
                            <th class="whitespace-nowrap px-3 py-3 font-medium">Tanggal</th>
                            <th class="whitespace-nowrap px-3 py-3 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">

                        <tr>
                            <td class="whitespace-nowrap px-3 py-4">
                                <p class="font-semibold text-slate-700">Andi Saputra</p>
                                <p class="text-xs text-slate-400">ANG-001</p>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-600">
                                Peminjaman Buku
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-500">
                                20 Nov 2026
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="rounded-full bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-600">
                                    Menunggu
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="whitespace-nowrap px-3 py-4">
                                <p class="font-semibold text-slate-700">Budi Santoso</p>
                                <p class="text-xs text-slate-400">ANG-002</p>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-600">
                                Pengembalian Buku
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-500">
                                20 Nov 2026
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="whitespace-nowrap px-3 py-4">
                                <p class="font-semibold text-slate-700">Citra Lestari</p>
                                <p class="text-xs text-slate-400">ANG-003</p>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-600">
                                Peminjaman Buku
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-500">
                                19 Nov 2026
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-600">
                                    Diproses
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <td class="whitespace-nowrap px-3 py-4">
                                <p class="font-semibold text-slate-700">Dina Permata</p>
                                <p class="text-xs text-slate-400">ANG-004</p>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-600">
                                Pengembalian Buku
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-slate-500">
                                19 Nov 2026
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-600">
                                    Selesai
                                </span>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </section>

        <!-- BUKU TERLAMBAT -->
        <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm">

            <div class="mb-5 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-slate-800">Buku Terlambat</h3>
                    <p class="mt-1 text-xs text-slate-400">
                        Perlu tindak lanjut petugas
                    </p>
                </div>
                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-red-600">
                    3 Buku
                </span>
            </div>

            <div class="space-y-4">

                <div class="rounded-xl bg-red-50/70 p-4">
                    <p class="text-sm font-semibold text-slate-700">Laskar Pelangi</p>
                    <p class="mt-1 text-xs text-slate-500">Peminjam: Andi Saputra</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs text-red-600">Terlambat 3 hari</span>
                        <span class="text-xs font-bold text-red-600">Perlu dicek</span>
                    </div>
                </div>

                <div class="rounded-xl bg-red-50/70 p-4">
                    <p class="text-sm font-semibold text-slate-700">Bumi Manusia</p>
                    <p class="mt-1 text-xs text-slate-500">Peminjam: Citra Lestari</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs text-red-600">Terlambat 2 hari</span>
                        <span class="text-xs font-bold text-red-600">Perlu dicek</span>
                    </div>
                </div>

                <div class="rounded-xl bg-red-50/70 p-4">
                    <p class="text-sm font-semibold text-slate-700">Filosofi Teras</p>
                    <p class="mt-1 text-xs text-slate-500">Peminjam: Budi Santoso</p>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xs text-red-600">Terlambat 1 hari</span>
                        <span class="text-xs font-bold text-red-600">Perlu dicek</span>
                    </div>
                </div>

            </div>
        </section>

    </div>

@endsection
