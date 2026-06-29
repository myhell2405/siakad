<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'SIAKAD SD - Portal Eksekutif' }}</title>

    {{-- Tailwind CDN (untuk development) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-gray-100">
    @php
        $userRole = session('role') ?? (auth()->user()->role->nama_role ?? 'admin');
        $userPermissions = session('permissions') ?? (auth()->user()->role->permissions ?? []);
        if (!is_array($userPermissions)) {
            $userPermissions = [];
        }

        $portalTitle = match($userRole) {
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
            class="fixed top-0 left-0 h-screen w-64 bg-white shadow-xl transition-all duration-300 z-50 flex flex-col border-r border-gray-200">

            <!-- Logo -->
            <div class="border-b p-6 text-center bg-gradient-to-b from-blue-50/50 to-white">
                <div class="w-20 h-20 rounded-full border-2 border-blue-600 shadow-md overflow-hidden mx-auto">
                    <img src="{{ asset('images/tutwuri.jpeg') }}" class="w-full h-full object-cover">
                </div>
                <h2 class="font-bold text-gray-800 text-sm mt-3 leading-snug">
                    SD NEGERI 01<br>DURIAN GADANG
                </h2>
                <span class="inline-block mt-2 px-3 py-1 bg-blue-600 text-white text-[10px] font-extrabold uppercase tracking-wider rounded-full shadow-sm">
                    {{ str_replace('_', ' ', $userRole) }}
                </span>
            </div>

            <!-- Menu Items -->
            <div class="flex-1 overflow-y-auto">
                <ul class="py-3 text-sm font-medium">

                    <!-- Dashboard Common -->
                    <li>
                        <a href="{{ $dashboardLink }}"
                            class="flex items-center gap-3 px-6 py-3 transition {{ request()->routeIs('*.dashboard') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                            <i class="bi bi-house-door-fill text-lg {{ request()->routeIs('*.dashboard') ? 'text-blue-600' : 'text-gray-400' }}"></i>
                            Dashboard
                        </a>
                    </li>

                    {{-- ============================================ --}}
                    {{-- 👑 MENU ADMIN & DATA MASTER --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'admin' || in_array('kelola_master', $userPermissions))
                        <li class="mt-3 pt-3 border-t border-gray-100">
                            <span class="px-6 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Administrasi Master</span>
                        </li>
                        <li class="mt-1">
                            <button onclick="toggleMaster()"
                                class="w-full flex justify-between items-center px-6 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">
                                <div class="flex items-center gap-3">
                                    <i class="bi bi-database-fill text-lg text-purple-500"></i>
                                    <span>Data Master</span>
                                </div>
                                <i class="bi bi-chevron-down text-xs"></i>
                            </button>

                            <div id="masterMenu" class="{{ request()->routeIs('admin.guru.*') || request()->routeIs('admin.siswa.*') || request()->routeIs('admin.wali-siswa.*') || request()->routeIs('admin.kelas.*') || request()->routeIs('admin.mapel.*') || request()->routeIs('admin.ekskul.*') || request()->routeIs('admin.tahun-ajaran.*') ? '' : 'hidden' }} bg-gray-50/70 py-1 border-y border-gray-100">
                                <a href="{{ route('admin.guru.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.guru.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Guru</a>
                                <a href="{{ route('admin.siswa.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.siswa.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Siswa</a>
                                <a href="{{ route('admin.wali-siswa.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.wali-siswa.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Wali Siswa</a>
                                <a href="{{ route('admin.kelas.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.kelas.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Kelas</a>
                                <a href="{{ route('admin.mapel.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.mapel.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Mata Pelajaran</a>
                                <a href="{{ route('admin.ekskul.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.ekskul.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Ekstrakurikuler</a>
                                <a href="{{ route('admin.tahun-ajaran.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.tahun-ajaran.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Tahun Ajaran</a>
                            </div>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('pembagian_kelas', $userPermissions))
                        <li>
                            <a href="{{ route('admin.pembagian-kelas.index') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.pembagian-kelas.*') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-diagram-3-fill text-lg text-indigo-500"></i>
                                Pembagian Kelas Aktif
                            </a>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('kelola_nilai_admin', $userPermissions))
                        <li>
                            <a href="{{ route('admin.nilai.index') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.nilai.*') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-pencil-square text-lg text-green-500"></i>
                                Kelola Nilai Massal
                            </a>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('laporan_akademik', $userPermissions))
                        <li class="mt-1">
                            <button onclick="toggleLaporan()"
                                class="w-full flex justify-between items-center px-6 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">
                                <div class="flex items-center gap-3">
                                    <i class="bi bi-file-earmark-text-fill text-lg text-amber-500"></i>
                                    <span>Laporan Sekolah</span>
                                </div>
                                <i class="bi bi-chevron-down text-xs"></i>
                            </button>
                            <div id="laporanMenu" class="{{ request()->routeIs('admin.laporan.*') ? '' : 'hidden' }} bg-gray-50/70 py-1 border-y border-gray-100">
                                <a href="{{ route('admin.laporan.identitas-siswa') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.laporan.identitas-siswa') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Identitas Siswa</a>
                                <a href="{{ route('admin.laporan.identitas-guru') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.laporan.identitas-guru') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Identitas Guru</a>
                                <a href="{{ route('admin.laporan.rapor') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.laporan.rapor') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Rapor Siswa</a>
                                <a href="{{ route('admin.laporan.monitoring') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.laporan.monitoring') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Monitoring Akademik</a>
                            </div>
                        </li>
                    @endif

                    @if($userRole == 'admin' || in_array('kelola_akun', $userPermissions))
                        <li class="mt-1">
                            <button onclick="toggleAkun()"
                                class="w-full flex justify-between items-center px-6 py-2.5 text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition">
                                <div class="flex items-center gap-3">
                                    <i class="bi bi-shield-lock-fill text-lg text-blue-600"></i>
                                    <span>Manajemen Akun</span>
                                </div>
                                <i class="bi bi-chevron-down text-xs"></i>
                            </button>
                            <div id="akunMenu" class="{{ request()->routeIs('admin.akun.*') || request()->routeIs('admin.role.*') ? '' : 'hidden' }} bg-gray-50/70 py-1 border-y border-gray-100">
                                <a href="{{ route('admin.akun.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.akun.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Akun Pengguna</a>
                                <a href="{{ route('admin.role.index') }}" class="block pl-14 py-2 text-xs {{ request()->routeIs('admin.role.*') ? 'font-bold text-blue-600 bg-blue-100/50' : 'text-gray-600 hover:text-blue-600' }}">Role & Hak Akses</a>
                            </div>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 👨‍🏫 MENU GURU MAPEL & WALI KELAS --}}
                    {{-- ============================================ --}}
                    @if(in_array($userRole, ['guru', 'wali_kelas']) || in_array('input_nilai_mapel', $userPermissions))
                        <li class="mt-3 pt-3 border-t border-gray-100">
                            <span class="px-6 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Portal Guru Mapel</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.index') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.nilai.*') && !request()->routeIs('admin.nilai.validasi') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-journal-check text-lg text-indigo-600"></i>
                                Input Nilai Mapel
                            </a>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 📋 MENU KHUSUS WALI KELAS --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'wali_kelas' || in_array('validasi_nilai', $userPermissions))
                        <li class="mt-3 pt-3 border-t border-gray-100">
                            <span class="px-6 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Portal Wali Kelas</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.validasi') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.nilai.validasi') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-check2-all text-lg text-green-600"></i>
                                Validasi Nilai Kelas
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.laporan.rapor') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-printer-fill text-lg text-amber-600"></i>
                                Cetak Rapor Siswa
                            </a>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 🎓 MENU SISWA / ORANG TUA --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'siswa' || in_array('view_nilai_siswa', $userPermissions))
                        <li class="mt-3 pt-3 border-t border-gray-100">
                            <span class="px-6 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Portal Siswa</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.nilai.index') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.nilai.index') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-award-fill text-lg text-teal-600"></i>
                                Transkrip Nilai
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.laporan.rapor') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-file-earmark-pdf-fill text-lg text-red-600"></i>
                                Cetak Rapor Mandiri
                            </a>
                        </li>
                    @endif

                    {{-- ============================================ --}}
                    {{-- 🏢 MENU KEPALA SEKOLAH --}}
                    {{-- ============================================ --}}
                    @if($userRole == 'kepala_sekolah' || in_array('monitoring_akademik', $userPermissions))
                        <li class="mt-3 pt-3 border-t border-gray-100">
                            <span class="px-6 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Eksekutif Pengawas</span>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.monitoring') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.laporan.monitoring') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-graph-up-arrow text-lg text-blue-600"></i>
                                Monitoring Nilai Sekolah
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.identitas-siswa') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.laporan.identitas-*') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-bar-chart-fill text-lg text-purple-600"></i>
                                Rekapitulasi Laporan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.laporan.rapor') }}"
                                class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.laporan.rapor') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                                <i class="bi bi-folder-check text-lg text-amber-600"></i>
                                Arsip Rapor Siswa
                            </a>
                        </li>
                    @endif

                    <!-- Profil & Pengaturan -->
                    <li class="mt-3 pt-3 border-t border-gray-100">
                        <a href="{{ route('admin.profil') }}"
                            class="flex items-center gap-3 px-6 py-2.5 transition {{ request()->routeIs('admin.profil') ? 'bg-blue-50 font-bold text-blue-700 border-r-4 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                            <i class="bi bi-person-circle text-lg text-gray-400"></i>
                            Profil Akun Saya
                        </a>
                    </li>

                </ul>
            </div>

            <!-- Logout Button -->
            <div class="border-t p-4 bg-gray-50">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 px-4 rounded-xl shadow-sm transition">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar Portal</span>
                    </button>
                </form>
            </div>

        </aside>

        <!-- =====================
             MAIN CONTENT WRAPPER
        ====================== -->

        <div id="mainWrapper" class="flex-1 transition-all duration-300 ml-64 min-h-screen flex flex-col">

            <!-- TOPBAR HEADER -->
            <nav id="topbar"
                class="fixed top-0 left-0 right-0 h-16 bg-white shadow-sm border-b border-gray-200 flex justify-between items-center px-8 transition-all duration-300 z-40 ml-64">

                <div class="flex items-center gap-4">
                    <button id="toggleSidebar" class="text-gray-500 hover:text-blue-600 focus:outline-none p-1 rounded-lg hover:bg-gray-100 transition">
                        <i class="bi bi-list text-2xl"></i>
                    </button>
                    <div class="hidden sm:block">
                        <h1 class="font-bold text-gray-800 text-base leading-tight">
                            {{ $portalTitle }}
                        </h1>
                        <p class="text-[11px] text-gray-400">Sistem Informasi Akademik Sekolah Dasar</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-bold text-gray-800 leading-tight">
                            {{ session('username') ?? (auth()->user()->username ?? 'Pengguna') }}
                        </p>
                        <p class="text-xs text-blue-600 font-semibold capitalize">
                            {{ str_replace('_', ' ', $userRole) }}
                        </p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-extrabold text-base shadow-sm">
                        {{ strtoupper(substr(session('username') ?? (auth()->user()->username ?? 'P'), 0, 1)) }}
                    </div>
                </div>

            </nav>

            <!-- CONTENT -->
            <main id="content" class="pt-24 px-8 pb-12 flex-1 transition-all duration-300">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 min-h-[calc(100vh-8rem)]">
                    @yield('content')
                </div>
            </main>

            <!-- FOOTER -->
            <footer class="bg-white border-t border-gray-200 py-4 px-8 text-center text-xs text-gray-500">
                &copy; {{ date('Y') }} SIAKAD SD Negeri 01 Durian Gadang. Hak Cipta Dilindungi Undang-Undang.
            </footer>

        </div>

    </div>

    <script>
        const sidebar = document.getElementById("sidebar");
        const topbar = document.getElementById("topbar");
        const mainWrapper = document.getElementById("mainWrapper");
        let open = true;

        document.getElementById("toggleSidebar").addEventListener("click", function () {
            open = !open;
            if (open) {
                sidebar.classList.remove("-translate-x-full");
                topbar.classList.add("ml-64");
                mainWrapper.classList.add("ml-64");
            } else {
                sidebar.classList.add("-translate-x-full");
                topbar.classList.remove("ml-64");
                mainWrapper.classList.remove("ml-64");
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