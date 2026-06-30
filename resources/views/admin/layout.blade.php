<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIAKAD SD - Portal Eksekutif' }}</title>

    {{-- Google Fonts: Plus Jakarta Sans --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    {{-- Tailwind CDN & Custom Config --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        executive: {
                            50: '#f0f5ff',
                            100: '#e5edff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 99px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Mini Sidebar Collapsed Rules & Scrollbar Fix */
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

        #sidebar.sidebar-collapsed .logo-wrapper {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        #sidebar.sidebar-collapsed .logo-wrapper img {
            margin: 0 auto;
        }

        #sidebar.sidebar-collapsed a,
        #sidebar.sidebar-collapsed button {
            justify-content: center !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-left: 12px !important;
            margin-right: 12px !important;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] text-slate-800 font-sans antialiased selection:bg-blue-600 selection:text-white">
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
             SIDEBAR NAVIGATION
        ======================== -->

        <aside id="sidebar"
            class="fixed top-0 left-0 h-screen w-[260px] bg-white shadow-[0_4px_30px_rgba(0,0,0,0.03)] transition-all duration-300 z-50 flex flex-col border-r border-slate-100 select-none overflow-x-hidden">

            <!-- Logo Header -->
            <div
                class="flex items-center justify-between px-6 h-[76px] border-b border-slate-100 flex-shrink-0 bg-white">
                <div class="flex items-center gap-3.5 logo-wrapper w-full overflow-hidden">
                    <img src="{{ asset('images/tutwuri.jpeg') }}"
                        class="h-9 w-9 rounded-xl object-cover ring-1 ring-slate-200 shadow-2xs flex-shrink-0"
                        title="SDN 01 Durian Gadang">
                    <div class="sidebar-text min-w-0 flex-1 truncate">
                        <span class="font-black text-slate-900 text-[13.5px] tracking-tight block truncate leading-tight">SDN 01 DURIAN</span>
                        <span class="inline-block px-2 py-0.5 mt-0.5 bg-blue-50 text-blue-600 font-extrabold text-[9px] uppercase tracking-wider rounded-md">
                            {{ str_replace('_', ' ', $userRole) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden px-4 py-6">
                <ul class="space-y-1 text-[13px] font-medium">

                    <!-- Dashboard Common -->
                    <li>
                        <a href="{{ $dashboardLink }}" title="Dashboard"
                            class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('*.dashboard') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('*.dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            <span class="sidebar-text tracking-tight truncate">Dashboard</span>
                        </a>
                    </li>

                    {{-- ============================================ --}}
                    {{-- 👑 MENU ADMIN & DATA MASTER --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'admin' || in_array('kelola_master', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.18em] block truncate">Administrasi Master</span>
                        </li>
                        <li>
                            <button onclick="toggleMaster()" title="Data Master"
                                class="group w-full flex justify-between items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-3 min-w-0 truncate">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                                    </svg>
                                    <span class="sidebar-text tracking-tight truncate">Data Master</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 chevron-icon {{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div id="masterMenu"
                                class="{{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? '' : 'hidden' }} space-y-0.5 mt-1 ml-4 pl-3.5 border-l border-slate-200/80 py-1">
                                <a href="{{ route('admin.guru.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.guru.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Guru</a>
                                <a href="{{ route('admin.siswa.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.siswa.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Siswa</a>
                                <a href="{{ route('admin.wali-siswa.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.wali-siswa.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Wali Siswa</a>
                                <a href="{{ route('admin.kelas.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.kelas.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Kelas</a>
                                <a href="{{ route('admin.mapel.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.mapel.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Mata Pelajaran</a>
                                <a href="{{ route('admin.ekskul.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.ekskul.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Ekstrakurikuler</a>
                                <a href="{{ route('admin.tahun-ajaran.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.tahun-ajaran.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Tahun Ajaran</a>
                            </div>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('pembagian_kelas', $userPermissions))
                        <li>
                            <a href="{{ route('admin.pembagian-kelas.index') }}" title="Pembagian Kelas Aktif"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pembagian-kelas.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.pembagian-kelas.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Pembagian Kelas Aktif</span>
                            </a>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('kelola_nilai_admin', $userPermissions))
                        <li>
                            <a href="{{ route('admin.nilai.index') }}" title="Kelola Nilai Massal"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Kelola Nilai Massal</span>
                            </a>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('laporan_akademik', $userPermissions))
                        <li>
                            <button onclick="toggleLaporan()" title="Laporan Sekolah"
                                class="group w-full flex justify-between items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-3 min-w-0 truncate">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span class="sidebar-text tracking-tight truncate">Laporan Sekolah</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 chevron-icon {{ request()->routeIs('admin.laporan.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="laporanMenu"
                                class="{{ request()->routeIs('admin.laporan.*') ? '' : 'hidden' }} space-y-0.5 mt-1 ml-4 pl-3.5 border-l border-slate-200/80 py-1">
                                <a href="{{ route('admin.laporan.identitas-siswa') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.identitas-siswa') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Identitas Siswa</a>
                                <a href="{{ route('admin.laporan.identitas-guru') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.identitas-guru') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Identitas Guru</a>
                                <a href="{{ route('admin.laporan.rapor') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.rapor') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Rapor Siswa</a>
                                <a href="{{ route('admin.laporan.monitoring') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.laporan.monitoring') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Monitoring Akademik</a>
                            </div>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('kelola_akun', $userPermissions))
                        <li>
                            <button onclick="toggleAkun()" title="Manajemen Akun"
                                class="group w-full flex justify-between items-center px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <div class="flex items-center gap-3 min-w-0 truncate">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    <span class="sidebar-text tracking-tight truncate">Manajemen Akun</span>
                                </div>
                                <svg class="w-4 h-4 shrink-0 transition-transform duration-200 chevron-icon {{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? 'text-white' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div id="akunMenu"
                                class="{{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? '' : 'hidden' }} space-y-0.5 mt-1 ml-4 pl-3.5 border-l border-slate-200/80 py-1">
                                <a href="{{ route('admin.akun.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.akun.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Akun Pengguna</a>
                                <a href="{{ route('admin.role.index') }}"
                                    class="block px-3 py-2 rounded-lg text-[12.5px] transition-all duration-150 truncate {{ request()->routeIs('admin.role.*') ? 'font-bold text-blue-600 bg-blue-50/80' : 'text-slate-500 hover:text-slate-900 hover:bg-slate-50' }}">Role & Hak Akses</a>
                            </div>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 👨‍🏫 MENU GURU MAPEL & WALI KELAS --}}
                    {{-- ============================================ --}}
                    @if(in_array($userRole, ['guru', 'wali_kelas']) || in_array('input_nilai_mapel', $userPermissions))
                        <li class="sidebar-header mt-6 mb-2 px-3.5">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.18em] block truncate">Portal Guru Mapel</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.index') }}" title="Input Nilai Mapel"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.*') && !request()->routeIs('admin.nilai.validasi') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.*') && !request()->routeIs('admin.nilai.validasi') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.18em] block truncate">Portal Wali Kelas</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.validasi') }}" title="Validasi Nilai Kelas"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.validasi') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.validasi') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Validasi Nilai Kelas</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}" title="Cetak Rapor Siswa"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.rapor') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.rapor') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.18em] block truncate">Portal Siswa</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.index') }}" title="Transkrip Nilai"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.nilai.index') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.nilai.index') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Transkrip Nilai</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}" title="Cetak Rapor Mandiri"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.rapor') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.rapor') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.18em] block truncate">Eksekutif Pengawas</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.monitoring') }}" title="Monitoring Nilai Sekolah"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.monitoring') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.monitoring') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Monitoring Nilai Sekolah</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.identitas-siswa') }}" title="Rekapitulasi Laporan"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.identitas-*') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.identitas-*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Rekapitulasi Laporan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}" title="Arsip Rapor Siswa"
                                class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.laporan.rapor') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                                <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.laporan.rapor') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                </svg>
                                <span class="sidebar-text tracking-tight truncate">Arsip Rapor Siswa</span>
                            </a>
                        </li>
                    @endif

                    <!-- Profil & Pengaturan -->
                    <li class="sidebar-header mt-6 mb-2 px-3.5">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.18em] block truncate">Akun Pengguna</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.profil') }}" title="Profil Akun Saya"
                            class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.profil') ? 'bg-blue-600 text-white font-semibold shadow-md shadow-blue-500/20' : 'text-slate-600 hover:text-slate-950 hover:bg-slate-50' }}">
                            <svg class="w-5 h-5 shrink-0 transition-transform duration-200 group-hover:scale-110 {{ request()->routeIs('admin.profil') ? 'text-white' : 'text-slate-400 group-hover:text-blue-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span class="sidebar-text tracking-tight truncate">Profil Akun Saya</span>
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Logout Button -->
            <div class="border-t border-slate-100 p-4 bg-white">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button title="Keluar Portal"
                        class="group w-full flex items-center justify-center gap-2.5 bg-rose-50 hover:bg-rose-500 text-rose-600 hover:text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 text-[13px] active:scale-95">
                        <svg class="w-4 h-4 shrink-0 transition-transform duration-200 group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="sidebar-text font-bold">Keluar Portal</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- =====================
             MAIN CONTENT WRAPPER
        ====================== -->

        <div id="mainWrapper" class="flex-1 transition-all duration-300 ml-[260px] min-h-screen flex flex-col">

            <!-- TOPBAR HEADER -->
            <nav id="topbar"
                class="fixed top-0 left-0 right-0 h-[76px] bg-white/80 backdrop-blur-xl shadow-[0_4px_25px_-10px_rgba(0,0,0,0.03)] border-b border-slate-900/[0.04] flex justify-between items-center px-6 sm:px-8 transition-all duration-300 z-40 ml-[260px]">

                <div class="flex items-center gap-4">
                    <button id="toggleSidebar" title="Toggle Sidebar"
                        class="w-10 h-10 rounded-2xl bg-slate-50/80 hover:bg-blue-50 text-slate-500 hover:text-blue-600 focus:outline-none flex items-center justify-center transition-all duration-200 ring-1 ring-slate-900/[0.05] hover:ring-blue-500/20 active:scale-95">
                        <i class="bi bi-layout-sidebar text-lg leading-none"></i>
                    </button>
                    <div>
                        <h1 class="font-black text-slate-900 text-base leading-tight tracking-tight">
                            {{ $portalTitle }}
                        </h1>
                        <p class="text-[11px] font-bold text-slate-400 mt-0.5 tracking-wide uppercase">
                            {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5">
                    <div
                        class="hidden sm:flex items-center gap-2 bg-gradient-to-r from-slate-50 to-blue-50/40 border border-slate-900/[0.05] rounded-2xl px-3.5 py-2 text-xs text-slate-600 font-bold shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>TA. Aktif:
                            <span class="text-blue-700 font-black">{{ \App\Models\TahunAjaran::where('status', 'aktif')->first()?->tahun_ajaran ?? '2025/2026' }}</span></span>
                    </div>

                    <div class="text-right hidden md:block pl-3 border-l border-slate-900/[0.06]">
                        <p class="text-xs font-black text-slate-900 leading-tight">
                            {{ session('username') ?? (auth()->user()->username ?? 'Pengguna') }}
                        </p>
                        <p class="text-[10px] text-blue-600 font-black tracking-widest uppercase mt-0.5">
                            {{ str_replace('_', ' ', $userRole) }}
                        </p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-purple-600 text-white flex items-center justify-center font-black text-sm shadow-md shadow-blue-500/20 ring-2 ring-white">
                        {{ strtoupper(substr(session('username') ?? (auth()->user()->username ?? 'P'), 0, 1)) }}
                    </div>
                </div>

            </nav>

            <main id="content" class="pt-[100px] px-6 sm:px-8 pb-12 flex-1 transition-all duration-300">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="bg-white border-t border-slate-900/[0.04] py-5 px-8 text-center text-xs text-slate-400 font-bold tracking-wide">
                &copy; {{ date('Y') }} <span class="text-slate-600 font-black">SIAKAD SD Negeri 01 Durian Gadang</span> &bull; Executive Portal V2
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