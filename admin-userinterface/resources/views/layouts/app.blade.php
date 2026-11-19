<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Perpustakaan') - Sistem Informasi Manajemen</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#534dec',
                            700: '#4338ca',
                        },
                        sidebar: '#ffffff',
                        cardbg: '#ffffff',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    borderRadius: {
                        '3xl': '24px',
                        '4xl': '32px',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f3f5f9;
            color: #1e293b;
            -webkit-font-smoothing: antialiased;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .nav-item-active {
            background: linear-gradient(135deg, #5750f6 0%, #635bf7 100%);
            color: #ffffff !important;
            box-shadow: 0 8px 18px -4px rgba(87, 80, 246, 0.38);
        }
        .nav-item-active i, .nav-item-active span {
            color: #ffffff !important;
        }
        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 4px 20px -2px rgba(15, 23, 42, 0.03), 0 2px 6px -1px rgba(15, 23, 42, 0.02);
        }
        .badge-soft-success {
            background-color: #ecfdf5;
            color: #10b981;
            border: 1px solid #d1fae5;
        }
        .badge-soft-warning {
            background-color: #fffbeb;
            color: #f59e0b;
            border: 1px solid #fef3c7;
        }
        .badge-soft-danger {
            background-color: #fef2f2;
            color: #ef4444;
            border: 1px solid #fee2e2;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex p-4 lg:p-6 gap-6">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white rounded-3xl p-5 flex flex-col justify-between shrink-0 glass-card">
        <div>
            <!-- Logo Brand -->
            <div class="flex items-center gap-3.5 px-2 py-2 mb-6">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-[#554fed] to-[#6d66ff] flex items-center justify-center text-white text-xl shadow-md shadow-indigo-500/25">
                    <i class="bi bi-book"></i>
                </div>
                <div>
                    <h1 class="font-bold text-[17px] text-[#1e293b] tracking-tight leading-none">Perpustakaan</h1>
                    <p class="text-[11px] text-[#64748b] font-medium mt-1">Sistem Informasi Manajemen</p>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-1.5">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('dashboard') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-grid-fill text-lg"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Data Buku -->
                <a href="{{ route('buku.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('buku.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-book text-lg"></i>
                    <span>Data Buku</span>
                </a>

                <!-- Data Master -->
                <a href="{{ route('master.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('master.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-diagram-3 text-lg"></i>
                    <span>Data Master</span>
                </a>

                <!-- Data Anggota -->
                <a href="{{ route('anggota.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('anggota.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-people text-lg"></i>
                    <span>Data Anggota</span>
                </a>

                <!-- Data Petugas -->
                <a href="{{ route('petugas.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('petugas.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-person-badge text-lg"></i>
                    <span>Data Petugas</span>
                </a>

                <!-- Data Peminjaman -->
                <a href="{{ route('peminjaman.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('peminjaman.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-journal-text text-lg"></i>
                    <span>Data Peminjaman</span>
                </a>

                <!-- Pengembalian & Denda -->
                <a href="{{ route('pengembalian.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('pengembalian.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-box-arrow-in-down-left text-lg"></i>
                    <span>Pengembalian & Denda</span>
                </a>

                <!-- Laporan -->
                <a href="{{ route('laporan.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('laporan.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-bar-chart text-lg"></i>
                    <span>Laporan</span>
                </a>

                <!-- Log Aktivitas -->
                <a href="{{ route('log.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('log.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                    <i class="bi bi-clock-history text-lg"></i>
                    <span>Log Aktivitas</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Settings & Profile -->
        <div class="pt-6 space-y-1.5 border-t border-gray-100">
            <a href="{{ route('pengaturan.index') }}" 
               class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[13.5px] font-medium text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc] transition-all">
                <i class="bi bi-gear text-lg"></i>
                <span>Pengaturan Sistem</span>
            </a>
            <a href="{{ route('profil.index') }}" 
               class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[13.5px] font-medium text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc] transition-all">
                <i class="bi bi-person text-lg"></i>
                <span>Profil</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <main class="flex-1 flex flex-col min-w-0">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
