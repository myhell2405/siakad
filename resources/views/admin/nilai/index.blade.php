@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    @if(strtolower(session('role')) === 'siswa')
        {{-- ================================================
             HERO HEADER SISWA
             ================================================ --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                    <i class="bi bi-award-fill text-3xl text-signal"></i>
                </div>
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                        <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                        <span>PORTAL AKADEMIK SISWA</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">TRANSKRIP NILAI SAYA</h1>
                    <p class="text-xs text-gray-500 font-mono uppercase">
                        DAFTAR NILAI TUGAS, UTS, DAN UAS DI SELURUH MATA PELAJARAN
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-black/10 flex items-center justify-between bg-gray-50">
                <h2 class="text-sm font-black text-void uppercase tracking-wider font-mono flex items-center gap-2">
                    <i class="bi bi-journal-bookmark text-cobalt text-base"></i> REKAPITULASI NILAI AKADEMIK
                </h2>
                <span class="text-[10px] bg-void text-white px-3 py-1 rounded font-mono font-bold uppercase">TOTAL: {{ $nilaisSiswa->count() }} MAPEL</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface border-b border-black/10 text-void font-mono text-[10px] uppercase tracking-wider">
                            <th class="py-4 pl-6">MATA PELAJARAN</th>
                            <th class="py-4 text-center">KKM</th>
                            <th class="py-4 text-center">TUGAS</th>
                            <th class="py-4 text-center">UTS</th>
                            <th class="py-4 text-center">UAS</th>
                            <th class="py-4 text-center">NILAI AKHIR</th>
                            <th class="py-4 pr-6">CATATAN GURU</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                        @forelse($nilaisSiswa as $n)
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="py-4 pl-6 font-bold text-void uppercase">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                            <td class="py-4 text-center text-gray-400 font-mono font-bold">{{ $n->mapel->kkm ?? 75 }}</td>
                            <td class="py-4 text-center font-mono text-gray-600">{{ $n->nilai_tugas ?? '-' }}</td>
                            <td class="py-4 text-center font-mono text-gray-600">{{ $n->nilai_uts ?? '-' }}</td>
                            <td class="py-4 text-center font-mono text-gray-600">{{ $n->nilai_uas ?? '-' }}</td>
                            <td class="py-4 text-center font-mono font-black text-cobalt text-sm">
                                <span class="bg-gray-100 px-2.5 py-1 rounded border border-black/5">{{ $n->nilai_akhir ?? '-' }}</span>
                            </td>
                            <td class="py-4 pr-6 text-gray-500 italic uppercase font-mono">"{{ $n->catatan_guru ?? 'TETAP SEMANGAT BELAJAR.' }}"</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 border border-black/5">
                                        <i class="bi bi-inbox text-3xl"></i>
                                    </div>
                                    <h4 class="font-bold text-void text-base uppercase font-mono">BELUM ADA ENTRI NILAI</h4>
                                    <p class="text-xs text-gray-500 mt-1 max-w-sm">Daftar nilai akademik belum dicatat oleh guru mata pelajaran.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        {{-- ================================================
             HERO HEADER SECTION (Admin/Guru/Walas)
             ================================================ --}}
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div class="flex items-center gap-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                    <i class="bi bi-journal-check text-3xl text-signal"></i>
                </div>
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                        <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                        <span>AKADEMIK & EVALUASI</span>
                    </div>
                    <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                        KELOLA NILAI SISWA <span class="text-xs sm:text-sm font-mono font-bold text-void bg-signal px-2.5 py-1 rounded align-middle ml-1 border border-black">MASSAL</span>
                    </h1>
                    <p class="text-xs text-gray-500 font-mono uppercase">
                        PILIH TAHUN AJARAN, KELAS, DAN MATA PELAJARAN UNTUK MENGISI NILAI SISWA
                    </p>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-500/30 text-emerald-900 p-4 rounded-2xl shadow-xs flex items-center justify-between text-xs font-mono font-bold uppercase">
                <div class="flex items-center gap-3">
                    <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">
                    ✕
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-500/30 text-red-900 p-4 rounded-2xl shadow-xs flex items-center justify-between text-xs font-mono font-bold uppercase">
                <div class="flex items-center gap-3">
                    <i class="bi bi-exclamation-triangle-fill text-red-600 text-base"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-red-100 text-red-600 flex items-center justify-center transition">
                    ✕
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-500/30 text-red-900 p-4 rounded-2xl shadow-xs text-xs font-mono font-bold space-y-1 uppercase">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ================================================
             FILTER FORM CARD
             ================================================ --}}
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs">
            <form method="GET" action="{{ route('admin.nilai.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                
                <!-- Pilih Tahun Ajaran -->
                <div class="md:col-span-3 min-w-0 space-y-2">
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">TAHUN AJARAN</label>
                    <select name="id_tahun_ajaran" onchange="this.form.submit()" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        @foreach($taList as $ta)
                            <option value="{{ $ta->id_tahun_ajaran }}" {{ $selectedTaId == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                                {{ $ta->tahun_ajaran }} {{ $ta->semester ? '('.strtoupper($ta->semester).')' : '' }} {{ strtolower($ta->status) == 'aktif' ? '[AKTIF]' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Kelas -->
                <div class="md:col-span-3 min-w-0 space-y-2">
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">KELAS TARGET</label>
                    <select name="id_kelas_ta" required onchange="this.form.submit()" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        <option value="">-- PILIH KELAS --</option>
                        @foreach($kelasTaList as $kta)
                            <option value="{{ $kta->id }}" {{ $selectedKelasTaId == $kta->id ? 'selected' : '' }}>
                                {{ strtoupper($kta->kelas->nama_kelas ?? '-') }} (WALI: {{ strtoupper($kta->waliKelas->nama_lengkap ?? 'BELUM ADA') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Mapel -->
                <div class="md:col-span-3 min-w-0 space-y-2">
                    <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">MATA PELAJARAN</label>
                    <select name="id_mapel" onchange="this.form.submit()" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase">
                        <option value="">-- SEMUA MATA PELAJARAN --</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id_mapel }}" {{ $selectedMapelId == $mapel->id_mapel ? 'selected' : '' }}>
                                {{ strtoupper($mapel->nama_mapel) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Filter -->
                <div class="md:col-span-3">
                    <button type="submit" class="w-full bg-void hover:bg-black text-white font-mono font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase">
                        <i class="bi bi-funnel-fill text-signal"></i> TAMPILKAN DATA SISWA
                    </button>
                </div>

            </form>
        </div>

        {{-- Tabel Input Nilai --}}
        @if($selectedKelasTaId && isset($activeMapels) && $activeMapels->isNotEmpty())
            <div class="space-y-8">
                @foreach($activeMapels as $mapelItem)
                    @php
                        $mapelId = $mapelItem->id_mapel;
                        $existingNilaiForMapel = $allExistingNilai->where('id_mapel', $mapelId)->keyBy('siswa_id');
                    @endphp
                    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
                        <div class="p-6 border-b border-black/10 bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                                    <i class="bi bi-book text-signal"></i>
                                </div>
                                <div>
                                    <h2 class="text-base font-black text-void uppercase">
                                        INPUT NILAI: {{ strtoupper($mapelItem->nama_mapel ?? '-') }}
                                    </h2>
                                    <p class="text-xs text-gray-500 font-mono uppercase">
                                        KELAS: <strong class="text-void">{{ strtoupper($selectedKelasTa->kelas->nama_kelas ?? '-') }}</strong> | TOTAL SISWA: <strong class="text-void">{{ $siswaKelasList->count() }}</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="text-[11px] font-mono font-bold text-void bg-surface px-3.5 py-2 rounded-xl border border-black/10 flex items-center gap-2 uppercase">
                                <i class="bi bi-lightning-charge-fill text-signal"></i> Nilai Akhir dihitung otomatis rata-rata (Tugas, UTS, UAS).
                            </div>
                        </div>

                        @if($siswaKelasList->isEmpty())
                            <div class="p-16 text-center text-gray-400 font-mono">
                                <i class="bi bi-people text-4xl block mb-2 text-gray-300"></i>
                                BELUM ADA SISWA YANG TERDAFTAR DI KELAS INI PADA TAHUN AJARAN TERPILIH.
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.nilai.store') }}">
                                @csrf
                                <input type="hidden" name="id_kelas_ta" value="{{ $selectedKelasTaId }}">
                                <input type="hidden" name="id_mapel" value="{{ $mapelId }}">

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-surface border-b border-black/10 text-void font-mono text-[10px] uppercase tracking-wider">
                                                <th class="py-4 pl-6 w-14 text-center">NO</th>
                                                <th class="py-4 px-4 w-32">NISN</th>
                                                <th class="py-4 px-4">NAMA SISWA</th>
                                                <th class="py-4 px-3 w-24 text-center">TUGAS</th>
                                                <th class="py-4 px-3 w-24 text-center">UTS</th>
                                                <th class="py-4 px-3 w-24 text-center">UAS</th>
                                                <th class="py-4 px-4 w-24 text-center">AKHIR</th>
                                                <th class="py-4 pr-6">CATATAN GURU</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                                            @foreach($siswaKelasList as $index => $sk)
                                                @php
                                                    $siswaId = $sk->id_siswa;
                                                    $nilai = $existingNilaiForMapel->get($siswaId);
                                                @endphp
                                                <tr class="hover:bg-gray-50/80 transition duration-150">
                                                    <td class="py-3.5 pl-6 text-center font-mono font-bold text-gray-400">{{ $index + 1 }}</td>
                                                    <td class="py-3.5 px-4 font-mono font-bold text-gray-600">{{ $sk->siswa->nisn ?? '-' }}</td>
                                                    <td class="py-3.5 px-4 font-bold text-void uppercase">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                                    
                                                    <!-- Nilai Tugas -->
                                                    <td class="py-3.5 px-2 text-center">
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               name="nilais[{{ $siswaId }}][tugas]" 
                                                               value="{{ $nilai ? $nilai->nilai_tugas : '' }}" 
                                                               placeholder="0"
                                                               class="w-20 text-center rounded-xl border border-black/10 px-2 py-1.5 font-mono font-bold text-xs bg-gray-50 focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                                                    </td>

                                                    <!-- Nilai UTS -->
                                                    <td class="py-3.5 px-2 text-center">
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               name="nilais[{{ $siswaId }}][uts]" 
                                                               value="{{ $nilai ? $nilai->nilai_uts : '' }}" 
                                                               placeholder="0"
                                                               class="w-20 text-center rounded-xl border border-black/10 px-2 py-1.5 font-mono font-bold text-xs bg-gray-50 focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                                                    </td>

                                                    <!-- Nilai UAS -->
                                                    <td class="py-3.5 px-2 text-center">
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               name="nilais[{{ $siswaId }}][uas]" 
                                                               value="{{ $nilai ? $nilai->nilai_uas : '' }}" 
                                                               placeholder="0"
                                                               class="w-20 text-center rounded-xl border border-black/10 px-2 py-1.5 font-mono font-bold text-xs bg-gray-50 focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition">
                                                    </td>

                                                    <!-- Nilai Akhir (Live / Saved) -->
                                                    <td class="py-3.5 px-4 text-center font-mono font-black text-cobalt text-sm">
                                                        <span class="bg-gray-100 px-2.5 py-1 rounded border border-black/5">
                                                            {{ $nilai && $nilai->nilai_akhir !== null ? $nilai->nilai_akhir : '-' }}
                                                        </span>
                                                    </td>

                                                    <!-- Catatan Guru -->
                                                    <td class="py-3.5 pr-6">
                                                        <input type="text" 
                                                               name="nilais[{{ $siswaId }}][catatan]" 
                                                               value="{{ $nilai ? $nilai->catatan_guru : '' }}" 
                                                               placeholder="Catatan perkembangan siswa..."
                                                               class="w-full rounded-xl border border-black/10 px-3.5 py-1.5 font-mono font-bold text-xs bg-gray-50 focus:bg-white focus:ring-2 focus:ring-void focus:outline-none transition uppercase">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-6 bg-gray-50 border-t border-black/10 flex justify-end">
                                    <button type="submit" class="bg-void hover:bg-black text-white font-mono font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center gap-2 text-xs uppercase">
                                        <i class="bi bi-save2-fill text-signal"></i> SIMPAN NILAI {{ strtoupper($mapelItem->nama_mapel) }}
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    @endif

</div>
@endsection
