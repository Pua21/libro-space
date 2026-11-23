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
        @media print {
            aside, header, .no-print {
                display: none !important;
            }
            body {
                background: white !important;
                padding: 0 !important;
            }
            .printable-content {
                display: block !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen flex flex-col lg:flex-row p-3 sm:p-4 lg:p-6 gap-4 lg:gap-6 relative">

    <!-- Mobile Header Trigger -->
    <div class="lg:hidden flex items-center justify-between bg-white px-5 py-3.5 rounded-2xl glass-card">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#554fed] to-[#6d66ff] flex items-center justify-center text-white text-base shadow-sm">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <h1 class="font-bold text-sm text-[#1e293b] leading-tight">Perpustakaan</h1>
                <p class="text-[10px] text-[#64748b]">Sistem Informasi</p>
            </div>
        </div>
        <button onclick="toggleMobileSidebar()" class="w-9 h-9 rounded-xl bg-gray-50 flex items-center justify-center text-gray-700 hover:bg-gray-100">
            <i class="bi bi-list text-xl"></i>
        </button>
    </div>

    <!-- Mobile Backdrop -->
    <div id="sidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-black/40 z-40 backdrop-blur-xs hidden lg:hidden transition-opacity"></div>

    <!-- SIDEBAR -->
    <aside id="mainSidebar" class="fixed lg:static top-0 left-0 h-full lg:h-auto z-50 w-64 bg-white rounded-none lg:rounded-3xl p-5 flex flex-col justify-between shrink-0 glass-card -translate-x-full lg:translate-x-0 transition-transform duration-200 overflow-y-auto">
        <div>
            <!-- Logo Brand -->
            <div class="flex items-center justify-between px-2 py-2 mb-6">
                <div class="flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-[#554fed] to-[#6d66ff] flex items-center justify-center text-white text-xl shadow-md shadow-indigo-500/25">
                        <i class="bi bi-book"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-[17px] text-[#1e293b] tracking-tight leading-none">Perpustakaan</h1>
                        <p class="text-[11px] text-[#64748b] font-medium mt-1">Sistem Informasi Manajemen</p>
                    </div>
                </div>
                <button onclick="toggleMobileSidebar()" class="lg:hidden text-gray-400 hover:text-gray-600">
                    <i class="bi bi-x-lg"></i>
                </button>
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

                <!-- Portal Petugas (Sirkulasi Live) -->
                <a href="{{ route('petugas.portal') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[13.5px] font-medium transition-all text-[#64748b] hover:text-[#554fed] hover:bg-[#eff1fe]">
                    <i class="bi bi-box-arrow-up-right text-lg text-[#554fed]"></i>
                    <span class="flex items-center gap-2">Portal Petugas <span class="text-[10px] bg-indigo-100 text-[#554fed] px-1.5 py-0.5 rounded-full font-bold">Live</span></span>
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
        <div class="pt-6 space-y-1.5 border-t border-gray-100 mt-6 lg:mt-0">
            <a href="{{ route('pengaturan.index') }}" 
               class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('pengaturan.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                <i class="bi bi-gear text-lg"></i>
                <span>Pengaturan Sistem</span>
            </a>
            <a href="{{ route('profil.index') }}" 
               class="flex items-center gap-3.5 px-4 py-2.5 rounded-2xl text-[13.5px] font-medium transition-all {{ request()->routeIs('profil.*') ? 'nav-item-active font-semibold' : 'text-[#64748b] hover:text-[#1e293b] hover:bg-[#f8fafc]' }}">
                <i class="bi bi-person text-lg"></i>
                <span>Profil</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT WRAPPER -->
    <main class="flex-1 flex flex-col min-w-0">
        @yield('content')
    </main>

    <!-- GLOBAL TOAST NOTIFICATION CONTAINER -->
    <div id="toastContainer" class="fixed bottom-6 right-6 z-[100] flex flex-col gap-2.5 pointer-events-none"></div>

    <!-- NOTIFICATION DROPDOWN POPUP TEMPLATE (Interactivity for Header Bell) -->
    <div id="notificationDropdown" class="hidden fixed z-50 bg-white rounded-3xl p-5 shadow-2xl border border-gray-100 w-80 sm:w-96 glass-card animate-in fade-in duration-150">
        <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-3">
            <div class="flex items-center gap-2">
                <i class="bi bi-bell text-[#554fed] text-base"></i>
                <h4 class="text-xs font-bold text-[#1e293b]">Pemberitahuan Sistem</h4>
            </div>
            <button onclick="clearNotifications()" class="text-[10px] text-[#554fed] font-semibold hover:underline">Tandai telah dibaca</button>
        </div>
        <div class="space-y-2.5 text-xs">
            <div class="p-3 rounded-2xl bg-amber-50/60 border border-amber-100 flex items-start gap-2.5">
                <i class="bi bi-exclamation-triangle-fill text-amber-500 mt-0.5 text-sm"></i>
                <div>
                    <p class="font-bold text-[#1e293b] leading-tight">3 Buku Terlambat Jatuh Tempo</p>
                    <p class="text-[11px] text-gray-500 mt-0.5">Dimas Pratama & 2 anggota lain belum mengembalikan buku.</p>
                    <span class="text-[9px] text-gray-400 mt-1 block">15 menit yang lalu</span>
                </div>
            </div>
            <div class="p-3 rounded-2xl bg-indigo-50/60 border border-indigo-100 flex items-start gap-2.5">
                <i class="bi bi-journal-plus text-[#554fed] mt-0.5 text-sm"></i>
                <div>
                    <p class="font-bold text-[#1e293b] leading-tight">Transaksi Peminjaman Baru</p>
                    <p class="text-[11px] text-gray-500 mt-0.5">Putri Ayu Lestari meminjam "Laskar Pelangi" (PJ-001).</p>
                    <span class="text-[9px] text-gray-400 mt-1 block">1 jam yang lalu</span>
                </div>
            </div>
            <div class="p-3 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex items-start gap-2.5">
                <i class="bi bi-check-circle-fill text-[#10b981] mt-0.5 text-sm"></i>
                <div>
                    <p class="font-bold text-[#1e293b] leading-tight">Pembayaran Denda Diterima</p>
                    <p class="text-[11px] text-gray-500 mt-0.5">Denda Rp 55.000 (Andi Saputra) telah berhasil dilunasi.</p>
                    <span class="text-[9px] text-gray-400 mt-1 block">3 jam yang lalu</span>
                </div>
            </div>
        </div>
        <div class="pt-3 mt-3 border-t border-gray-100 text-center">
            <a href="{{ route('log.index') }}" class="text-[11px] font-bold text-[#554fed] hover:underline">Lihat Log Aktivitas Selengkapnya →</a>
        </div>
    </div>

    <!-- PROFILE DROPDOWN MENU -->
    <div id="profileDropdown" class="hidden fixed z-50 bg-white rounded-2xl p-2 shadow-2xl border border-gray-100 w-56 glass-card animate-in fade-in duration-150 text-xs">
        <div class="p-3 border-b border-gray-100 mb-1">
            <p class="font-bold text-[#1e293b]">Admin Perpustakaan</p>
            <p class="text-[11px] text-[#64748b]">admin@perpustakaan.go.id</p>
            <span class="inline-block mt-1 text-[10px] font-bold text-[#554fed] bg-[#eef2ff] px-2 py-0.5 rounded-full">Super Administrator</span>
        </div>
        <a href="{{ route('profil.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-700 hover:bg-[#f8fafc] hover:text-[#554fed] transition-colors">
            <i class="bi bi-person text-sm"></i>
            <span>Profil Pengguna</span>
        </a>
        <a href="{{ route('pengaturan.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-gray-700 hover:bg-[#f8fafc] hover:text-[#554fed] transition-colors">
            <i class="bi bi-gear text-sm"></i>
            <span>Pengaturan Sistem</span>
        </a>
        <div class="my-1 border-t border-gray-100"></div>
        <button onclick="showLogoutConfirm()" class="w-full text-left flex items-center gap-2.5 px-3 py-2 rounded-xl text-rose-600 hover:bg-rose-50 transition-colors">
            <i class="bi bi-box-arrow-right text-sm"></i>
            <span>Keluar / Logout</span>
        </button>
    </div>

    <!-- LOGOUT CONFIRMATION MODAL -->
    <div id="logoutModal" class="hidden fixed inset-0 z-50 bg-black/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl w-full max-w-sm p-6 shadow-2xl text-center">
            <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center text-xl mx-auto mb-3">
                <i class="bi bi-box-arrow-right"></i>
            </div>
            <h3 class="font-bold text-[#1e293b] text-base">Konfirmasi Keluar</h3>
            <p class="text-xs text-[#64748b] mt-1 mb-5">Apakah Anda yakin ingin keluar dari sesi admin perpustakaan?</p>
            <div class="flex items-center justify-center gap-2">
                <button onclick="document.getElementById('logoutModal').classList.add('hidden')" class="px-5 py-2.5 rounded-full border border-gray-200 text-xs font-semibold text-gray-600 hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <a href="{{ route('login') }}" onclick="document.getElementById('logoutModal').classList.add('hidden');" class="bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold px-6 py-2.5 rounded-full shadow-md shadow-rose-500/20 transition-all inline-flex items-center justify-center">
                    Ya, Keluar
                </a>
            </div>
        </div>
    </div>

    <!-- GLOBAL JS LOGIC -->
    <script>
        // Toast notification system
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-2xl shadow-xl border text-xs font-semibold transform transition-all duration-300 translate-y-3 opacity-0';
            
            let icon = 'bi-check-circle-fill text-[#10b981]';
            let bg = 'bg-white border-emerald-100 text-[#1e293b]';
            
            if (type === 'error' || type === 'danger') {
                icon = 'bi-x-circle-fill text-[#ef4444]';
                bg = 'bg-white border-rose-100 text-[#1e293b]';
            } else if (type === 'warning') {
                icon = 'bi-exclamation-triangle-fill text-[#f59e0b]';
                bg = 'bg-white border-amber-100 text-[#1e293b]';
            } else if (type === 'info') {
                icon = 'bi-info-circle-fill text-[#554fed]';
                bg = 'bg-white border-indigo-100 text-[#1e293b]';
            }

            toast.className += ` ${bg}`;
            toast.innerHTML = `
                <i class="bi ${icon} text-base shrink-0"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.remove()" class="ml-2 text-gray-400 hover:text-gray-600"><i class="bi bi-x"></i></button>
            `;

            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-3', 'opacity-0');
            });

            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        };

        // Mobile Sidebar
        function toggleMobileSidebar() {
            const sb = document.getElementById('mainSidebar');
            const bd = document.getElementById('sidebarBackdrop');
            if (sb.classList.contains('-translate-x-full')) {
                sb.classList.remove('-translate-x-full');
                bd.classList.remove('hidden');
            } else {
                sb.classList.add('-translate-x-full');
                bd.classList.add('hidden');
            }
        }

        // Notification popup
        function setupDropdowns() {
            // Find all notification bell buttons across views
            document.querySelectorAll('button:has(> .bi-bell)').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const dd = document.getElementById('notificationDropdown');
                    const rect = btn.getBoundingClientRect();
                    dd.style.top = (rect.bottom + 10) + 'px';
                    dd.style.right = (window.innerWidth - rect.right) + 'px';
                    dd.classList.toggle('hidden');
                    document.getElementById('profileDropdown').classList.add('hidden');
                });
            });

            // Find all profile pill dropdowns across views
            document.querySelectorAll('div:has(> img[alt="Admin"])').forEach(pill => {
                pill.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const pd = document.getElementById('profileDropdown');
                    const rect = pill.getBoundingClientRect();
                    pd.style.top = (rect.bottom + 10) + 'px';
                    pd.style.right = (window.innerWidth - rect.right) + 'px';
                    pd.classList.toggle('hidden');
                    document.getElementById('notificationDropdown').classList.add('hidden');
                });
            });

            document.addEventListener('click', function() {
                const nd = document.getElementById('notificationDropdown');
                const pd = document.getElementById('profileDropdown');
                if (nd) nd.classList.add('hidden');
                if (pd) pd.classList.add('hidden');
            });
        }

        function clearNotifications() {
            document.querySelectorAll('button:has(> .bi-bell) span.bg-\\[\\#f43f5e\\]').forEach(el => el.remove());
            showToast('Semua notifikasi telah ditandai dibaca.');
            document.getElementById('notificationDropdown').classList.add('hidden');
        }

        function showLogoutConfirm() {
            document.getElementById('profileDropdown').classList.add('hidden');
            document.getElementById('logoutModal').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', setupDropdowns);
    </script>

    @stack('scripts')
</body>
</html>
