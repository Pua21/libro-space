
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Petugas') - Libro Space</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">

    <div class="min-h-screen lg:flex">

        <!-- SIDEBAR -->
        <aside class="hidden w-64 shrink-0 border-r border-slate-200 bg-white px-5 py-7 lg:flex lg:flex-col">

            <div class="mb-10 flex items-center gap-3 px-2">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-600 text-xl text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-lg font-bold tracking-tight text-slate-800">Libro Space</h1>
                    <p class="text-xs text-slate-400">Sistem Informasi Perpustakaan</p>
                </div>
            </div>

            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Menu Utama
            </p>

            <nav class="space-y-2">
                <a href="#" class="flex items-center gap-3 rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-md shadow-indigo-100">
                    <span>▦</span>
                    Dashboard
                </a>

                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                    <span>▤</span>
                    Data Buku
                </a>

                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                    <span>♙</span>
                    Data Anggota
                </a>

                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                    <span>⇄</span>
                    Peminjaman
                </a>

                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                    <span>↩</span>
                    Pengembalian
                </a>

                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600">
                    <span>◷</span>
                    Riwayat Transaksi
                </a>
            </nav>

            <div class="mt-auto rounded-2xl bg-indigo-50 p-4">
                <p class="text-sm font-semibold text-indigo-800">Butuh bantuan?</p>
                <p class="mt-1 text-xs leading-relaxed text-indigo-500">
                    Hubungi administrator jika mengalami kendala pada sistem.
                </p>
            </div>
        </aside>

        <!-- AREA KONTEN -->
        <div class="min-w-0 flex-1">

            <!-- NAVBAR -->
            <header class="sticky top-0 z-10 border-b border-slate-200 bg-white/95 px-5 py-4 backdrop-blur md:px-8">
                <div class="flex items-center justify-between gap-4">

                    <div>
                        <p class="text-xs font-medium text-slate-400">Libro Space / Petugas</p>
                        <h2 class="text-xl font-bold text-slate-800">
                            @yield('page-heading', 'Dashboard')
                        </h2>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden items-center gap-2 rounded-xl bg-slate-100 px-3 py-2 sm:flex">
                            <span class="text-slate-400">⌕</span>
                            <input type="text" placeholder="Cari sesuatu..."
                                class="w-36 bg-transparent text-sm outline-none placeholder:text-slate-400 md:w-52">
                        </div>

                        <button type="button"
                            class="relative flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                            ♧
                            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-red-500"></span>
                        </button>

                        <div class="flex items-center gap-2">
                            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 font-bold text-indigo-600">
                                P
                            </div>
                            <div class="hidden sm:block">
                                <p class="text-sm font-semibold text-slate-700">Petugas</p>
                                <p class="text-xs text-slate-400">Perpustakaan</p>
                            </div>
                        </div>
                    </div>

                </div>
            </header>

            <!-- KONTEN HALAMAN -->
            <main class="p-5 md:p-8">
                @yield('content')
            </main>

            <footer class="px-5 pb-6 text-center text-xs text-slate-400 md:px-8">
                © {{ date('Y') }} Libro Space. Sistem Informasi Perpustakaan.
            </footer>

        </div>
    </div>

</body>
</html>
