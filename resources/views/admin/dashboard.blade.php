@extends('admin.layout')

@section('content')

    <div class="space-y-10 font-sans text-slate-800 pb-16">

        {{-- ================================================
        HERO SECTION: FLOATING ELEVATION (Seamless Depth)
        ================================================ --}}
        <div
            class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">

            {{-- Background Kinetic Glow Orb --}}
            <div
                class="absolute -right-20 -top-20 w-96 h-96 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse">
            </div>

            <div class="space-y-5 max-w-2xl relative z-10">
                {{-- Live Active Indicator Badge --}}
                <div
                    class="inline-flex items-center gap-2.5 rounded-full px-4 py-1.5 text-[10px] uppercase tracking-[0.2em] font-black bg-blue-50/80 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>System Live • Academic Command Center</span>
                </div>

                {{-- Massive Vibrant Headline --}}
                <h1 class="text-3xl sm:text-5xl font-black tracking-tighter leading-[1.08] text-slate-900">
                    Sistem Siakad <br class="hidden sm:block" />
                    <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        SDN 01 Durian Gadang.
                    </span>
                </h1>

                <p class="text-slate-500 text-xs sm:text-sm font-medium leading-relaxed max-w-xl">
                    Infrastruktur digital sekolah dasar dengan pemantauan kapasitas rombongan belajar secara kinetik,
                    sebaran pendidik, dan pemetaan kepegawaian presisi tinggi.
                </p>

                {{-- Kinetic Button-in-Button CTAs --}}
                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="{{ route('admin.guru.index') }}"
                        class="group inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 transition-all duration-300 active:scale-[0.98]">
                        <span>Kelola Pendidik</span>
                        <div
                            class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                            <i class="bi bi-arrow-up-right text-xs font-bold"></i>
                        </div>
                    </a>

                    <a href="{{ route('admin.pembagian-kelas.index') }}"
                        class="group inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-slate-100 hover:bg-slate-200/80 text-slate-700 font-bold text-xs transition-all duration-300 active:scale-[0.98]">
                        <span>Distribusi Rombel</span>
                        <div
                            class="w-8 h-8 rounded-full bg-white group-hover:bg-slate-300/80 flex items-center justify-center text-slate-800 transition-transform duration-300 group-hover:translate-x-0.5 shadow-2xs">
                            <i class="bi bi-grid-fill text-xs text-indigo-600"></i>
                        </div>
                    </a>
                </div>
            </div>

            {{-- Kinetic Metric Islands (Right Side) --}}
            <div class="flex flex-col sm:flex-row lg:flex-col gap-4 self-stretch lg:self-auto shrink-0 relative z-10">
                <div
                    class="bg-gradient-to-br from-blue-50/80 to-indigo-50/40 p-4 rounded-2xl ring-1 ring-blue-500/10 min-w-[220px] shadow-2xs flex items-center justify-between gap-4">
                    <div>
                        <span class="block text-[10px] uppercase tracking-wider font-extrabold text-blue-500">Tahun
                            Ajaran</span>
                        <span
                            class="text-base font-black text-slate-900 mt-0.5 block">{{ $taAktif->tahun_ajaran ?? '2023/2024' }}</span>
                    </div>
                    <div
                        class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md shadow-blue-500/20 shrink-0">
                        <i class="bi bi-calendar-check text-base"></i>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-emerald-50/80 to-teal-50/40 p-4 rounded-2xl ring-1 ring-emerald-500/10 min-w-[220px] shadow-2xs flex items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span
                                class="block text-[10px] uppercase tracking-wider font-extrabold text-emerald-600">Semester
                                Aktif</span>
                        </div>
                        <span
                            class="text-base font-black text-slate-900 mt-0.5 block">{{ strtoupper($taAktif->semester ?? 'GANJIL') }}</span>
                    </div>
                    <div
                        class="w-11 h-11 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold shadow-md shadow-emerald-500/20 shrink-0">
                        <i class="bi bi-compass text-base"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================================================
        VIBRANT FLOATING BENTO STATS (Zero Borders)
        ================================================ --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            {{-- Metric 1: Peserta Didik (Blue Accent) --}}
            <div
                class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_45px_-10px_rgba(59,130,246,0.12)] ring-1 ring-slate-900/[0.03] transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/5 rounded-full blur-xl group-hover:bg-blue-500/10 transition-colors">
                </div>

                <div class="flex items-start justify-between mb-6 relative z-10">
                    <span
                        class="rounded-full px-3.5 py-1 text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 ring-1 ring-blue-500/15">
                        Peserta Didik
                    </span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-people-fill text-lg"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-black tracking-tight text-slate-900">{{ number_format($totalSiswa ?? 0) }}</p>
                    <p class="text-xs font-bold text-slate-400 mt-1.5 flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                        </span>
                        <span>Siswa Aktif Terdaftar</span>
                    </p>
                </div>
            </div>

            {{-- Metric 2: Tenaga Pendidik (Emerald Accent) --}}
            <div
                class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_45px_-10px_rgba(16,185,129,0.12)] ring-1 ring-slate-900/[0.03] transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-500/5 rounded-full blur-xl group-hover:bg-emerald-500/10 transition-colors">
                </div>

                <div class="flex items-start justify-between mb-6 relative z-10">
                    <span
                        class="rounded-full px-3.5 py-1 text-[10px] font-black uppercase tracking-widest bg-emerald-50 text-emerald-600 ring-1 ring-emerald-500/15">
                        Tenaga Pendidik
                    </span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-300">
                        <i class="bi bi-person-badge-fill text-lg"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-black tracking-tight text-slate-900">{{ number_format($totalGuru ?? 0) }}</p>
                    <p class="text-xs font-bold text-slate-400 mt-1.5 flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span>Guru & Staf Sekolah</span>
                    </p>
                </div>
            </div>

            {{-- Metric 3: Ekstrakurikuler (Amber Accent) --}}
            <div
                class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_45px_-10px_rgba(245,158,11,0.12)] ring-1 ring-slate-900/[0.03] transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-amber-500/5 rounded-full blur-xl group-hover:bg-amber-500/10 transition-colors">
                </div>

                <div class="flex items-start justify-between mb-6 relative z-10">
                    <span
                        class="rounded-full px-3.5 py-1 text-[10px] font-black uppercase tracking-widest bg-amber-50 text-amber-600 ring-1 ring-amber-500/15">
                        Ekstrakurikuler
                    </span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-110 group-hover:rotate-6 transition-all duration-300">
                        <i class="bi bi-trophy-fill text-lg"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-black tracking-tight text-slate-900">{{ number_format($totalEkskul ?? 0) }}
                        <span class="text-sm font-bold text-slate-400">Unit</span></p>
                    <p class="text-xs font-bold text-slate-400 mt-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Bakat & Minat Siswa
                    </p>
                </div>
            </div>

            {{-- Metric 4: Mata Pelajaran (Purple/Rose Accent) --}}
            <div
                class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_45px_-10px_rgba(168,85,247,0.12)] ring-1 ring-slate-900/[0.03] transition-all duration-300 group hover:-translate-y-1.5 flex flex-col justify-between relative overflow-hidden">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/5 rounded-full blur-xl group-hover:bg-purple-500/10 transition-colors">
                </div>

                <div class="flex items-start justify-between mb-6 relative z-10">
                    <span
                        class="rounded-full px-3.5 py-1 text-[10px] font-black uppercase tracking-widest bg-purple-50 text-purple-600 ring-1 ring-purple-500/15">
                        Mata Pelajaran
                    </span>
                    <div
                        class="w-11 h-11 rounded-2xl bg-gradient-to-br from-purple-500 to-rose-600 text-white flex items-center justify-center shadow-lg shadow-purple-500/25 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-300">
                        <i class="bi bi-book-half text-lg"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <p class="text-4xl font-black tracking-tight text-slate-900">{{ number_format($totalMapel ?? 0) }} <span class="text-sm font-bold text-slate-400">Mapel</span></p>
                    <p class="text-xs font-bold text-slate-400 mt-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span> Kurikulum Merdeka
                    </p>
                </div>
            </div>

        </div>

        {{-- ================================================
        MAIN GRID: FLOATING ELEVATION CARDS
        ================================================ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- Left: Rombel Capacity Monitoring (8 Cols) --}}
            <div
                class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-8 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03]">

                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100 mb-6">
                    <div>
                        <div
                            class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] font-extrabold uppercase tracking-widest bg-blue-50 text-blue-600 ring-1 ring-blue-500/15 mb-1.5">
                            <i class="bi bi-activity"></i> Live Rombel Tracking
                        </div>
                        <h3 class="text-xl font-black text-slate-900 tracking-tight">Okupansi & Distribusi Kelas</h3>
                    </div>

                    @if(($userRole ?? session('role') ?? '') == 'admin')
                        <a href="{{ route('admin.pembagian-kelas.index') }}"
                            class="group inline-flex items-center gap-3 pl-5 pr-1.5 py-1.5 rounded-full bg-slate-100 hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-600 hover:text-white text-slate-700 font-bold text-xs transition-all duration-300 shadow-2xs hover:shadow-md hover:shadow-blue-500/20">
                            <span>Atur Rombel</span>
                            <div
                                class="w-7 h-7 rounded-full bg-white group-hover:bg-white/20 flex items-center justify-center text-slate-800 group-hover:text-white transition-transform group-hover:translate-x-0.5 shadow-2xs">
                                <i class="bi bi-arrow-right text-xs"></i>
                            </div>
                        </a>
                    @endif
                </div>

                @if(!empty($distribusiKelas) && count($distribusiKelas) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                    <th class="pb-3.5 pl-2">Kelas</th>
                                    <th class="pb-3.5">Wali Kelas</th>
                                    <th class="pb-3.5 text-center">Okupansi</th>
                                    <th class="pb-3.5 text-right pr-2">Kapasitas (32)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                                @foreach($distribusiKelas as $dk)
                                    @php
                                        $jml = $dk->siswa_kelas_count ?? 0;
                                        $persen = min(round(($jml / 32) * 100), 100);
                                        $barColor = $persen > 90
                                            ? 'from-rose-500 to-red-600 shadow-rose-500/30'
                                            : 'from-blue-500 to-indigo-600 shadow-blue-500/30';
                                    @endphp
                                    <tr class="hover:bg-blue-50/40 transition-colors duration-200 group">
                                        <td class="py-4 pl-2 font-black text-slate-900 flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-2xl bg-slate-100 group-hover:bg-gradient-to-br group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white text-slate-800 flex items-center justify-center font-black text-xs transition-all duration-300 shadow-2xs group-hover:shadow-md group-hover:shadow-blue-500/20">
                                                {{ preg_replace('/[^0-9]/', '', $dk->kelas->nama_kelas ?? '1') ?: 'SD' }}
                                            </div>
                                            <span
                                                class="text-sm font-extrabold group-hover:text-blue-600 transition-colors">{{ $dk->kelas->nama_kelas ?? 'Kelas' }}</span>
                                        </td>
                                        <td class="py-4 text-slate-600 font-medium">
                                            <span
                                                class="inline-flex items-center gap-2 bg-slate-50 group-hover:bg-white ring-1 ring-slate-200/60 px-3.5 py-1.5 rounded-full text-xs font-bold text-slate-700 transition-colors shadow-2xs">
                                                <i class="bi bi-person-check-fill text-blue-500"></i>
                                                {{ $dk->waliKelas->nama_lengkap ?? 'Belum Ditentukan' }}
                                            </span>
                                        </td>
                                        <td class="py-4 text-center">
                                            <span
                                                class="px-3.5 py-1 rounded-full bg-slate-100 group-hover:bg-blue-100 group-hover:text-blue-800 text-slate-800 font-black text-xs transition-colors">
                                                {{ $jml }} Siswa
                                            </span>
                                        </td>
                                        <td class="py-4 pr-2 w-48">
                                            <div class="flex items-center gap-3 justify-end">
                                                <div
                                                    class="w-28 bg-slate-100 h-2.5 rounded-full overflow-hidden p-0.5 ring-1 ring-slate-200/60 shadow-inner">
                                                    <div class="bg-gradient-to-r {{ $barColor }} h-full rounded-full transition-all duration-700 shadow-xs"
                                                        style="width: {{ $persen }}%"></div>
                                                </div>
                                                <span class="font-black text-slate-900 w-10 text-right">{{ $persen }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-16 text-center">
                        <div
                            class="w-16 h-16 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                            <i class="bi bi-folder-x text-3xl"></i>
                        </div>
                        <p class="font-bold text-slate-700">Belum Ada Data Rombel</p>
                        <p class="text-xs text-slate-400 mt-1">Sistem belum mendeteksi konfigurasi kelas aktif.</p>
                    </div>
                @endif

            </div>

            {{-- Right: School Identity & Map Floating Cards (4 Cols) --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- Identity Card --}}
                <div
                    class="bg-white rounded-3xl p-6 sm:p-7 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-5 relative overflow-hidden">
                    <div
                        class="absolute -right-10 -bottom-10 w-32 h-32 bg-emerald-500/5 rounded-full blur-2xl pointer-events-none">
                    </div>

                    <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                        <div>
                            <span class="block text-[10px] font-black uppercase tracking-widest text-slate-400">Profil
                                Institusi</span>
                            <h3 class="text-lg font-black text-slate-900">SDN 01 Durian Gadang</h3>
                        </div>
                        <span
                            class="px-3 py-1 rounded-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-black text-[10px] uppercase tracking-wider shadow-md shadow-emerald-500/20">
                            Akreditasi A
                        </span>
                    </div>

                    <div class="space-y-3.5 text-xs font-semibold text-slate-700 relative z-10">
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-medium">NPSN Sekolah</span>
                            <span
                                class="font-mono font-bold text-blue-700 bg-blue-50 ring-1 ring-blue-100 px-2.5 py-0.5 rounded-lg">10304253</span>
                        </div>
                        <div class="flex justify-between items-start py-1 border-b border-slate-50 gap-4">
                            <span class="text-slate-400 font-medium shrink-0">Alamat Resmi</span>
                            <span class="text-right font-bold text-slate-800">Jorong Beringin Durian Gadang</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-medium">Kecamatan</span>
                            <span class="font-bold text-slate-800">Akabiluru</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-slate-50">
                            <span class="text-slate-400 font-medium">Kabupaten</span>
                            <span class="font-bold text-slate-800">Lima Puluh Kota</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-slate-400 font-medium">Kurikulum</span>
                            <span class="font-extrabold text-indigo-600 flex items-center gap-1.5">
                                <i class="bi bi-patch-check-fill"></i> Kurikulum Merdeka
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Map Card --}}
                <div
                    class="bg-white rounded-3xl p-6 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-2xl bg-gradient-to-br from-slate-800 to-slate-950 text-white flex items-center justify-center font-bold shrink-0 shadow-md">
                            <i class="bi bi-pin-map-fill text-blue-400"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-slate-900 uppercase tracking-wider">Koordinat Kampus</h4>
                            <p class="text-[11px] font-medium text-slate-400">SDN 01 Durian Gadang, Akabiluru</p>
                        </div>
                    </div>

                    <div
                        class="rounded-2xl overflow-hidden ring-1 ring-slate-200 h-48 bg-slate-50 shadow-inner relative group">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2391.920589214627!2d100.47031826358767!3d0.24689432809252837!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302ab7105d03d4b7%3A0xe67ed5e1c2851e09!2sSD%20NEGERI%2001%20DURIAN%20TINGGI!5e0!3m2!1sid!2sid!4v1782717177504!5m2!1sid!2sid"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                        </iframe>
                    </div>

                    <a href="https://maps.google.com/?q=SDN+01+DURIAN+GADANG+Akabiluru+Lima+Puluh+Kota" target="_blank"
                        class="group w-full inline-flex items-center justify-between pl-5 pr-2 py-2 rounded-full bg-slate-100 hover:bg-gradient-to-r hover:from-slate-900 hover:to-slate-800 text-slate-800 hover:text-white font-bold text-xs transition-all duration-300 shadow-2xs">
                        <span>Buka Google Maps Full</span>
                        <div
                            class="w-8 h-8 rounded-full bg-white group-hover:bg-white/20 flex items-center justify-center text-slate-800 group-hover:text-white transition-transform group-hover:translate-x-0.5 shadow-2xs">
                            <i class="bi bi-box-arrow-up-right text-xs"></i>
                        </div>
                    </a>
                </div>

            </div>

        </div>

    </div>

@endsection