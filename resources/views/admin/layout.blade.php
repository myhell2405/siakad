<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIAKAD SD - Portal Eksekutif v3.0' }}</title>

    {{-- Google Fonts: Space Grotesk & JetBrains Mono --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Tailwind CDN & Custom Config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Space Grotesk"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    },
                    colors: {
                        void: '#000000',
                        signal: '#ff3b30',
                        cobalt: '#0047ff',
                        surface: '#f4f4f6',
                    }
                }
            }
        }
    </script>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-color: #f4f4f6;
            color: #111827;
            font-family: 'Space Grotesk', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        /* Subtle Engineering Dot Grid */
        .bg-engineering-grid {
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 20px 20px;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #000000;
            border-radius: 2px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #ff3b30;
        }

        /* Mini Sidebar Collapsed Rules & Sleek Alignment */
        #sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #sidebar,
        #sidebar * {
            overflow-x: hidden !important;
        }

        #sidebar.sidebar-collapsed {
            width: 80px !important;
        }

        #sidebar.sidebar-collapsed .sidebar-text,
        #sidebar.sidebar-collapsed .sidebar-header,
        #sidebar.sidebar-collapsed .chevron-icon,
        #sidebar.sidebar-collapsed [id$="Menu"] {
            display: none !important;
        }

        #sidebar.sidebar-collapsed > div:first-child {
            padding: 0 !important;
            justify-content: center !important;
        }

        #sidebar.sidebar-collapsed .logo-wrapper {
            justify-content: center !important;
            padding: 0 !important;
            width: 100% !important;
        }

        #sidebar.sidebar-collapsed .logo-wrapper img {
            margin: 0 auto !important;
        }

        #sidebar.sidebar-collapsed .overflow-y-auto {
            padding-left: 12px !important;
            padding-right: 12px !important;
        }

        #sidebar.sidebar-collapsed ul > li > a,
        #sidebar.sidebar-collapsed ul > li > button,
        #sidebar.sidebar-collapsed form > button {
            width: 46px !important;
            height: 46px !important;
            padding: 0 !important;
            margin: 0 auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            border-radius: 12px !important;
        }

        #sidebar.sidebar-collapsed ul > li > button > div {
            justify-content: center !important;
            width: 100% !important;
            margin: 0 !important;
        }

        #sidebar.sidebar-collapsed svg,
        #sidebar.sidebar-collapsed i {
            margin: 0 !important;
            flex-shrink: 0 !important;
        }
    </style>
</head>

<body class="bg-engineering-grid bg-[#f4f4f6] text-gray-900 font-sans antialiased selection:bg-void selection:text-white"
      x-data="{ time: new Date().toLocaleTimeString('id-ID', { hour12: false }) }"
      x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID', { hour12: false }), 1000)">
    @php
        $userRole = session('role') ?? (auth()->user()->role->nama_role ?? 'admin');
        $userPermissions = session('permissions') ?? (auth()->user()->role->permissions ?? []);
        if (!is_array($userPermissions)) {
            $userPermissions = [];
        }

        $portalTitle = match ($userRole) {
            'admin' => 'Portal Administrator',
            'guru' => 'Portal Guru Mata Pelajaran',
            'wali_kelas' => 'Portal Wali Kelas',
            'kepala_sekolah' => 'Portal Kepala Sekolah',
            'siswa' => 'Portal Akademik Siswa / Orang Tua',
            default => 'SIAKAD SD Negeri 01 Durian Gadang'
        };

        $dashboardLink = route('admin.dashboard');
    @endphp

    <div class="flex">

        <!-- =======================
             SIDEBAR NAVIGATION (Nothing OS Aesthetic)
        ======================== -->

        <aside id="sidebar"
            class="fixed top-0 left-0 h-screen w-[260px] bg-white shadow-[4px_0_30px_rgba(0,0,0,0.02)] transition-all duration-300 z-50 flex flex-col border-r border-black/10 select-none overflow-x-hidden">

            <!-- Logo Header -->
            <div
                class="flex items-center justify-between px-6 h-[76px] border-b border-black/10 flex-shrink-0 bg-white">
                <div class="flex items-center gap-3.5 logo-wrapper w-full overflow-hidden">
                    <img src="{{ asset('images/tutwuri.jpeg') }}"
                        class="h-9 w-9 rounded-xl object-cover border border-black/20 shadow-xs flex-shrink-0"
                        title="SDN 01 Durian Gadang">
                    <div class="sidebar-text min-w-0 flex-1 truncate">
                        <span class="font-extrabold text-void text-[13.5px] tracking-tight block truncate leading-tight uppercase">SDN 01 DURIAN</span>
                        <span class="inline-block px-2 py-0.5 mt-0.5 bg-black text-white font-mono font-bold text-[9px] uppercase tracking-widest rounded">
                            {{ str_replace('_', ' ', $userRole) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden px-4 py-6">
                <ul class="space-y-1.5 text-xs font-semibold">

                    <!-- Dashboard Common -->
                    <li>
                        <a href="{{ $dashboardLink }}" title="Dashboard"
                            class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('*.dashboard') && !request()->routeIs('admin.dashboard.statis') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('*.dashboard') && !request()->routeIs('admin.dashboard.statis') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="sidebar-text tracking-tight truncate">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.dashboard.statis') }}" title="Showcase Gen-Z (Statis)"
                            class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard.statis') ? 'bg-signal text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.dashboard.statis') ? 'text-white' : 'text-gray-400 group-hover:text-signal' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span class="sidebar-text tracking-tight truncate">Showcase Gen-Z</span>
                        </a>
                    </li>

                    {{-- ============================================ --}}
                    {{-- 👑 MENU ADMIN & DATA MASTER --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'admin' || in_array('kelola_master', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-[0.2em] block truncate">Administrasi Master</span>
                        </li>
                        <li>
                            <button onclick="toggleMaster()" title="Data Master"
                                class="group w-full flex justify-between items-center px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <div class="flex items-center gap-3 min-w-0 truncate">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                    <span class="sidebar-text tracking-tight truncate">Data Master</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 chevron-icon {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? 'text-white' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="masterMenu"
                                class="{{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? '' : 'hidden' }} space-y-0.5 mt-1 ml-4 pl-3.5 border-l border-black/10 py-1 font-mono text-xs">
                                <a href="{{ route('admin.guru.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.guru.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Guru</a>
                                <a href="{{ route('admin.siswa.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.siswa.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Siswa</a>
                                <a href="{{ route('admin.wali-siswa.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.wali-siswa.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Wali Siswa</a>
                                <a href="{{ route('admin.kelas.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.kelas.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Kelas</a>
                                <a href="{{ route('admin.mapel.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.mapel.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Mata Pelajaran</a>
                                <a href="{{ route('admin.ekskul.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.ekskul.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Ekstrakurikuler</a>
                                <a href="{{ route('admin.tahun-ajaran.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.tahun-ajaran.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Tahun Ajaran</a>
                            </div>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('pembagian_kelas', $userPermissions))
                        <li>
                            <a href="{{ route('admin.pembagian-kelas.index') }}" title="Pembagian Kelas Aktif"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pembagian-kelas.*') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pembagian-kelas.*') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Pembagian Kelas Aktif</span>
                            </a>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('kelola_nilai_admin', $userPermissions))
                        <li>
                            <a href="{{ route('admin.nilai.index') }}" title="Kelola Nilai Massal"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.*') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.*') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Kelola Nilai Massal</span>
                            </a>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('laporan_akademik', $userPermissions))
                        <li>
                            <button onclick="toggleLaporan()" title="Laporan Sekolah"
                                class="group w-full flex justify-between items-center px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <div class="flex items-center gap-3 min-w-0 truncate">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="sidebar-text tracking-tight truncate">Laporan Sekolah</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 chevron-icon {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="laporanMenu"
                                class="{{ request()->routeIs('admin.laporan.*') ? '' : 'hidden' }} space-y-0.5 mt-1 ml-4 pl-3.5 border-l border-black/10 py-1 font-mono text-xs">
                                <a href="{{ route('admin.laporan.identitas-siswa') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.identitas-siswa') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Identitas Siswa</a>
                                <a href="{{ route('admin.laporan.identitas-guru') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.identitas-guru') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Identitas Guru</a>
                                <a href="{{ route('admin.laporan.rapor') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.rapor') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Rapor Siswa</a>
                                <a href="{{ route('admin.laporan.monitoring') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.monitoring') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Monitoring Akademik</a>
                            </div>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('kelola_akun', $userPermissions))
                        <li>
                            <button onclick="toggleAkun()" title="Manajemen Akun"
                                class="group w-full flex justify-between items-center px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <div class="flex items-center gap-3 min-w-0 truncate">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span class="sidebar-text tracking-tight truncate">Manajemen Akun</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 chevron-icon {{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? 'text-white' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="akunMenu"
                                class="{{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? '' : 'hidden' }} space-y-0.5 mt-1 ml-4 pl-3.5 border-l border-black/10 py-1 font-mono text-xs">
                                <a href="{{ route('admin.akun.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.akun.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Akun Pengguna</a>
                                <a href="{{ route('admin.role.index') }}"
                                    class="block px-3 py-2 rounded-lg transition-all duration-150 truncate {{ request()->routeIs('admin.role.*') ? 'font-bold text-signal bg-red-50' : 'text-gray-500 hover:text-void hover:bg-gray-100' }}">Role & Hak Akses</a>
                            </div>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 👨‍🏫 MENU GURU MAPEL & WALI KELAS --}}
                    {{-- ============================================ --}}
                    @if(in_array($userRole, ['guru', 'wali_kelas']) || in_array('input_nilai_mapel', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-[0.2em] block truncate">Portal Guru Mapel</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.index') }}" title="Input Nilai Mapel"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.*') && !request()->routeIs('admin.nilai.validasi') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.*') && !request()->routeIs('admin.nilai.validasi') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Input Nilai Mapel</span>
                            </a>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 📋 MENU KHUSUS WALI KELAS --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'wali_kelas' || in_array('validasi_nilai', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-[0.2em] block truncate">Portal Wali Kelas</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.validasi') }}" title="Validasi Nilai Kelas"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.validasi') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.validasi') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Validasi Nilai Kelas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}" title="Cetak Rapor Siswa"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.rapor') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.rapor') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Cetak Rapor Siswa</span>
                            </a>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 🎓 MENU SISWA / ORANG TUA --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'siswa' || in_array('view_nilai_siswa', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-[0.2em] block truncate">Portal Siswa</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.index') }}" title="Transkrip Nilai"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.index') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.index') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Transkrip Nilai</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}" title="Cetak Rapor Mandiri"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.rapor') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.rapor') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Cetak Rapor Mandiri</span>
                            </a>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 🏢 MENU KEPALA SEKOLAH --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'kepala_sekolah' || in_array('monitoring_akademik', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-[0.2em] block truncate">Eksekutif Pengawas</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.monitoring') }}" title="Monitoring Nilai Sekolah"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.monitoring') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.monitoring') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Monitoring Nilai Sekolah</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.identitas-siswa') }}" title="Rekapitulasi Laporan"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.identitas-*') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.identitas-*') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Rekapitulasi Laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}" title="Arsip Rapor Siswa"
                                class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.rapor') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.rapor') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Arsip Rapor Siswa</span>
                            </a>
                        </li>
                    @endif

                    <!-- Profil & Pengaturan -->
                    <li class="sidebar-header mt-6 mb-2 px-3.5">
                        <span class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-[0.2em] block truncate">Akun Pengguna</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.profil') }}" title="Profil Akun Saya"
                            class="group flex items-center gap-3 px-3.5 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.profil') ? 'bg-void text-white font-bold shadow-md' : 'text-gray-600 hover:text-void hover:bg-gray-100' }}">
                            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.profil') ? 'text-white' : 'text-gray-400 group-hover:text-void' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="sidebar-text tracking-tight truncate">Profil Akun Saya</span>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Logout Button (Solid Block Style) -->
            <div class="border-t border-black/10 p-4 bg-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button title="Keluar Portal"
                        class="group w-full flex items-center justify-center gap-2.5 bg-white border border-black/20 hover:bg-void text-void hover:text-white font-bold py-3 px-4 rounded-xl transition-all duration-200 text-xs shadow-2xs active:scale-95 uppercase tracking-wider font-mono">
                        <i class="bi bi-box-arrow-right text-sm"></i>
                        <span class="sidebar-text">Keluar Portal</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- =====================
             MAIN CONTENT WRAPPER
        ====================== -->

        <div id="mainWrapper" class="flex-1 transition-all duration-300 ml-[260px] min-h-screen flex flex-col">

            <!-- TOPBAR HEADER (Nothing OS Ticker Style) -->
            <nav id="topbar"
                class="fixed top-0 left-0 right-0 h-[76px] bg-white/95 backdrop-blur-md shadow-[0_2px_15px_rgba(0,0,0,0.02)] border-b border-black/10 flex justify-between items-center px-6 sm:px-8 transition-all duration-300 z-40 ml-[260px]">

                <div class="flex items-center gap-4">
                    <button id="toggleSidebar" title="Toggle Sidebar"
                        class="w-10 h-10 rounded-xl bg-gray-100 hover:bg-void text-gray-700 hover:text-white focus:outline-none flex items-center justify-center transition-all duration-200 border border-black/10 active:scale-95">
                        <i class="bi bi-layout-sidebar text-lg leading-none"></i>
                    </button>
                    <div class="flex items-center gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-signal animate-pulse" title="System Live"></div>
                        <div>
                            <h1 class="font-black text-void text-base leading-tight tracking-tight uppercase">
                                {{ $portalTitle }}
                            </h1>
                            <p class="text-[10px] font-mono font-bold text-gray-400 mt-0.5 tracking-wider uppercase">
                                {{ now()->isoFormat('dddd, D MMMM YYYY') }} // SDN 01 DURIAN GADANG
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-6">
                    <!-- Live Clock -->
                    <div class="hidden sm:flex items-center gap-2.5 px-3.5 py-1.5 rounded-xl bg-gray-100 border border-black/10 font-mono text-xs font-black text-void">
                        <i class="bi bi-clock-fill text-signal"></i>
                        <span x-text="time">09:15:00</span>
                        <span class="text-[9px] text-gray-400">WIB</span>
                    </div>

                    <div
                        class="hidden md:flex items-center gap-2 bg-white border border-black/15 rounded-xl px-3 py-1.5 text-xs text-void font-mono font-bold shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 inline-block"></span>
                        <span>TA: <span class="font-black underline">{{ \App\Models\TahunAjaran::where('status', 'aktif')->first()?->tahun_ajaran ?? '2025/2026' }}</span></span>
                    </div>

                    <div class="flex items-center gap-3 pl-4 border-l border-black/10">
                        <div class="text-right hidden sm:block">
                            <p class="text-xs font-black text-void leading-tight uppercase font-mono">
                                {{ session('username') ?? (auth()->user()->username ?? 'Pengguna') }}
                            </p>
                            <p class="text-[9px] text-signal font-mono font-bold tracking-widest uppercase mt-0.5">
                                {{ str_replace('_', ' ', $userRole) }}
                            </p>
                        </div>
                        <div
                            class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-mono font-black text-sm shadow-sm border border-black/20">
                            {{ strtoupper(substr(session('username') ?? (auth()->user()->username ?? 'P'), 0, 1)) }}
                        </div>
                    </div>
                </div>

            </nav>

            <main id="content" class="pt-[100px] px-6 sm:px-8 pb-12 flex-1 transition-all duration-300">
                @if(session('impersonator_id'))
                <div class="mb-6 bg-signal text-white p-4 rounded-2xl font-mono text-xs font-bold uppercase flex flex-col sm:flex-row items-center justify-between gap-4 border border-black shadow-md animate-fade-in">
                    <div class="flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-void animate-ping inline-block"></span>
                        <div>
                            <span class="block font-black text-sm">MODE IMPERSONASI AKTIF</span>
                            <span class="text-white/90">ANDA SEDANG LOGIN SEBAGAI: <u class="font-black">{{ session('username') }}</u> (ROLE: {{ strtoupper(session('role')) }})</span>
                        </div>
                    </div>
                    <form action="{{ route('admin.unimpersonate') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-void hover:bg-black text-white px-4 py-2.5 rounded-xl border border-black font-mono text-xs font-black uppercase transition shadow-2xs active:scale-95 flex items-center gap-2 shrink-0">
                            <i class="bi bi-box-arrow-left text-signal text-sm"></i> KEMBALI KE AKUN ASLI
                        </button>
                    </form>
                </div>
                @endif

                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="bg-white border-t border-black/10 py-5 px-8 text-center text-xs font-mono font-bold text-gray-400 tracking-wider uppercase">
                &copy; {{ date('Y') }} <span class="text-void font-black">SIAKAD SD NEGERI 01 DURIAN GADANG</span> // NOTHING OS ARCHITECTURE V3.0
            </footer>

        </div>

    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const topbar = document.getElementById("topbar");
        const mainWrapper = document.getElementById("mainWrapper");
        let open = true;

        document.getElementById("toggleSidebar").addEventListener("click", function () {
            if (window.innerWidth < 768) {
                sidebar.classList.toggle("-translate-x-full");
            } else {
                open = !open;
                if (open) {
                    sidebar.classList.remove("sidebar-collapsed");
                    sidebar.classList.add("w-[260px]");
                    topbar.classList.remove("ml-[80px]");
                    topbar.classList.add("ml-[260px]");
                    mainWrapper.classList.remove("ml-[80px]");
                    mainWrapper.classList.add("ml-[260px]");
                } else {
                    sidebar.classList.add("sidebar-collapsed");
                    sidebar.classList.remove("w-[260px]");
                    topbar.classList.remove("ml-[260px]");
                    topbar.classList.add("ml-[80px]");
                    mainWrapper.classList.remove("ml-[260px]");
                    mainWrapper.classList.add("ml-[80px]");
                }
            }
        });

        function toggleMaster() {
            const menu = document.getElementById("masterMenu");
            if (menu) menu.classList.toggle("hidden");
        }

        function toggleAkun() {
            const menu = document.getElementById("akunMenu");
            if (menu) menu.classList.toggle("hidden");
        }

        function toggleLaporan() {
            const menu = document.getElementById("laporanMenu");
            if (menu) menu.classList.toggle("hidden");
        }
    </script>

</body>

</html>