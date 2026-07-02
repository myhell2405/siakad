@extends('admin.layout')

@section('content')
    @php
        $roomsData = [];
        if (!empty($distribusiKelas) && count($distribusiKelas) > 0) {
            foreach ($distribusiKelas as $dk) {
                $jml = $dk->siswa_kelas_count ?? 0;
                $kode = preg_replace('/[^0-9A-Z]/i', '', $dk->kelas->nama_kelas ?? '1A');
                $roomsData[] = [
                    'code' => substr($kode ?: '1A', 0, 3),
                    'name' => $dk->kelas->nama_kelas ?? 'Kelas',
                    'teacher' => $dk->waliKelas->nama_lengkap ?? 'Wali Kelas Belum Ditentukan',
                    'present' => min($jml, 32),
                    'sick' => max(0, min(2, 32 - $jml)),
                    'alpha' => max(0, 32 - $jml - min(2, 32 - $jml)),
                    'total' => 32
                ];
            }
        } else {
            $roomsData = [
                ['code' => '1A', 'name' => 'Kelas 1 Alpha', 'teacher' => 'Ibu Kartini, S.Pd', 'present' => 30, 'sick' => 2, 'alpha' => 0, 'total' => 32],
                ['code' => '2B', 'name' => 'Kelas 2 Beta', 'teacher' => 'Bpk. Hendra, M.Pd', 'present' => 32, 'sick' => 0, 'alpha' => 0, 'total' => 32],
                ['code' => '3A', 'name' => 'Kelas 3 Alpha', 'teacher' => 'Bpk. Surya, S.Pd', 'present' => 31, 'sick' => 1, 'alpha' => 0, 'total' => 32],
                ['code' => '4A', 'name' => 'Kelas 4 Alpha', 'teacher' => 'Ibu Ratna, S.Pd', 'present' => 29, 'sick' => 3, 'alpha' => 0, 'total' => 32],
                ['code' => '5B', 'name' => 'Kelas 5 Beta', 'teacher' => 'Bpk. Gunawan, S.Pd', 'present' => 30, 'sick' => 1, 'alpha' => 1, 'total' => 32],
                ['code' => '6A', 'name' => 'Kelas 6 Senior', 'teacher' => 'Bpk. Budi Santoso, S.Pd', 'present' => 32, 'sick' => 0, 'alpha' => 0, 'total' => 32]
            ];
        }
    @endphp

    <div class="space-y-8 max-w-[1500px] w-full mx-auto font-sans pb-16" x-data="{ rooms: {{ json_encode($roomsData) }} }">

        {{-- TOP HERO BENTO STRIP --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

            {{-- Left Big Stat (Span 5) - Pitch Black Solid Modular Card --}}
            <div
                class="lg:col-span-5 bg-void text-white rounded-3xl p-8 shadow-xl flex flex-col justify-between border border-black">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-mono font-bold uppercase tracking-[0.2em] text-gray-400">Sistem Informasi
                        Akademik</span>
                    <span class="w-3 h-3 rounded-full bg-signal animate-pulse" title="Live System"></span>
                </div>

                <div class="my-6">
                    <div class="flex items-baseline gap-2">
                        <span
                            class="text-6xl font-black font-mono tracking-tighter text-white">{{ number_format($totalSiswa ?? 364) }}</span>
                        <span class="text-2xl font-mono font-bold text-signal">SISWA</span>
                    </div>
                    <p class="text-xs font-mono text-gray-400 mt-3 uppercase tracking-wider leading-relaxed">
                        SDN 01 DURIAN GADANG • TAHUN AJARAN {{ $taAktif->tahun_ajaran ?? '2025/2026' }}
                        ({{ strtoupper($taAktif->semester ?? 'GANJIL') }})
                    </p>
                </div>

                <div class="pt-6 border-t border-white/20 flex flex-wrap items-center justify-between gap-4">
                    <span class="text-xs font-mono text-white font-bold">{{ count($distribusiKelas ?? []) ?: 6 }} ROMBEL
                        AKTIF</span>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.siswa.index') }}"
                            class="px-4 py-2 rounded-xl bg-white text-void font-bold text-xs hover:bg-signal hover:text-white transition-colors inline-flex items-center gap-2">
                            <span>DATA SISWA</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Right Modular Stats Grid (Span 7) --}}
            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">

                {{-- Modular Card A: Tenaga Pendidik --}}
                <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold uppercase tracking-widest text-gray-400">Tenaga
                            Pendidik</span>
                        <i class="bi bi-person-badge-fill text-void text-xl"></i>
                    </div>
                    <div class="my-4">
                        <span
                            class="text-5xl font-black font-mono tracking-tight text-void">{{ number_format($totalGuru ?? 24) }}</span>
                        <span class="text-sm font-bold text-gray-400 ml-1">Guru & Staf</span>
                    </div>
                    <div
                        class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-mono font-bold text-cobalt">
                        <span>STATUS PENGAJAR AKTIF</span>
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>

                {{-- Modular Card B: Mata Pelajaran & Ekskul --}}
                <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-mono font-bold uppercase tracking-widest text-gray-400">Kurikulum
                            Merdeka</span>
                        <i class="bi bi-book-half text-void text-xl"></i>
                    </div>
                    <div class="my-4 flex items-baseline gap-6">
                        <div>
                            <span
                                class="text-5xl font-black font-mono tracking-tight text-void">{{ number_format($totalMapel ?? 12) }}</span>
                            <span class="text-sm font-bold text-gray-400 ml-1">Mapel</span>
                        </div>
                        <div>
                            <span
                                class="text-3xl font-black font-mono tracking-tight text-gray-700">{{ number_format($totalEkskul ?? 5) }}</span>
                            <span class="text-xs font-bold text-gray-400 ml-1">Ekskul</span>
                        </div>
                    </div>
                    <div
                        class="pt-4 border-t border-gray-100 flex items-center justify-between text-xs font-mono font-bold text-gray-600">
                        <span>AKREDITASI A</span>
                        <span>•</span>
                        <span>STANDAR NASIONAL</span>
                    </div>
                </div>

            </div>

        </div>

        {{-- TABEL OKUPANSI & PROFIL SEKOLAH GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- Left: Rombel Capacity Table (8 Cols) --}}
            <div class="lg:col-span-8 bg-white rounded-3xl p-8 border border-black/10 shadow-xs">

                <div
                    class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-gray-100 mb-6">
                    <div>
                        <span class="text-xs font-mono font-bold uppercase tracking-widest text-gray-400">Tabel Distribusi
                            Rombel</span>
                        <h3 class="text-xl font-black text-void tracking-tight mt-1">OKUPANSI & WALI KELAS</h3>
                    </div>

                    @if(($userRole ?? session('role') ?? '') == 'admin')
                        <a href="{{ route('admin.pembagian-kelas.index') }}"
                            class="px-4 py-2.5 rounded-xl bg-void text-white font-mono font-bold text-xs hover:bg-signal transition-colors inline-flex items-center gap-2">
                            <span>ATUR DISTRIBUSI</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    @endif
                </div>

                @if(!empty($distribusiKelas) && count($distribusiKelas) > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left font-mono">
                            <thead>
                                <tr
                                    class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                                    <th class="py-3 pl-3">Kelas</th>
                                    <th class="py-3">Wali Kelas</th>
                                    <th class="py-3 text-center">Okupansi</th>
                                    <th class="py-3 text-right pr-3">Persentase</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                                @foreach($distribusiKelas as $dk)
                                    @php
                                        $jml = $dk->siswa_kelas_count ?? 0;
                                        $persen = min(round(($jml / 32) * 100), 100);
                                        $barColor = $persen > 90 ? 'bg-signal' : 'bg-cobalt';
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 pl-3 font-extrabold text-void flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-void text-white flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ preg_replace('/[^0-9]/', '', $dk->kelas->nama_kelas ?? '1') ?: 'SD' }}
                                            </div>
                                            <span
                                                class="text-sm font-bold">{{ strtoupper($dk->kelas->nama_kelas ?? 'KELAS') }}</span>
                                        </td>
                                        <td class="py-4 text-gray-700 font-sans font-semibold">
                                            {{ $dk->waliKelas->nama_lengkap ?? 'Belum Ditentukan' }}
                                        </td>
                                        <td class="py-4 text-center">
                                            <span class="px-2.5 py-1 rounded bg-gray-100 text-void font-bold text-xs">
                                                {{ $jml }} Siswa
                                            </span>
                                        </td>
                                        <td class="py-4 pr-3 w-40">
                                            <div class="flex items-center gap-3 justify-end">
                                                <div class="w-20 bg-gray-100 h-2.5 rounded-full overflow-hidden">
                                                    <div class="{{ $barColor }} h-full transition-all duration-500"
                                                        style="width: {{ $persen }}%"></div>
                                                </div>
                                                <span class="font-bold text-void w-10 text-right">{{ $persen }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="py-16 text-center font-mono">
                        <div
                            class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center mx-auto mb-3 text-gray-400">
                            <i class="bi bi-folder-x text-2xl"></i>
                        </div>
                        <p class="font-bold text-void uppercase">Belum Ada Data Rombel</p>
                        <p class="text-xs text-gray-500 mt-1">Sistem belum mendeteksi konfigurasi kelas aktif.</p>
                    </div>
                @endif

            </div>

            {{-- Right: School Identity (4 Cols) --}}
            <div class="lg:col-span-4 space-y-6 font-mono">

                <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                        <div>
                            <span class="block text-xs font-bold uppercase tracking-widest text-gray-400">Profil
                                Sekolah</span>
                            <h3 class="text-base font-black text-void font-sans mt-0.5">SDN 01 Durian Gadang</h3>
                        </div>
                        <span class="px-2.5 py-1 rounded bg-void text-white font-bold text-[10px] uppercase tracking-wider">
                            AKREDITASI A
                        </span>
                    </div>

                    <div class="space-y-3 text-xs font-bold text-gray-800">
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                            <span class="text-gray-400">NPSN SEKOLAH</span>
                            <span class="font-bold text-void">10304253</span>
                        </div>
                        <div class="flex justify-between items-start py-1.5 border-b border-gray-100 gap-4">
                            <span class="text-gray-400 shrink-0">ALAMAT</span>
                            <span class="text-right text-void font-sans font-semibold">Jorong Beringin Durian Gadang</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                            <span class="text-gray-400">KECAMATAN</span>
                            <span class="text-void">Akabiluru</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5 border-b border-gray-100">
                            <span class="text-gray-400">KABUPATEN</span>
                            <span class="text-void">Lima Puluh Kota</span>
                        </div>
                        <div class="flex justify-between items-center py-1.5">
                            <span class="text-gray-400">KURIKULUM</span>
                            <span class="font-bold text-cobalt flex items-center gap-1.5">
                                <i class="bi bi-patch-check-fill"></i> Merdeka
                            </span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection