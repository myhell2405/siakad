@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16">

    @if(strtolower(session('role')) === 'siswa')
        {{-- ================================================
             HERO HEADER SISWA
             ================================================ --}}
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03]">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-teal-500/10 via-cyan-500/10 to-blue-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

            <div class="flex items-center gap-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-600 to-cyan-600 text-white flex items-center justify-center shadow-lg shadow-teal-500/25 shrink-0">
                    <i class="bi bi-award-fill text-3xl"></i>
                </div>
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-teal-50 text-teal-700 ring-1 ring-teal-500/20 shadow-2xs">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-600"></span>
                        </span>
                        <span>Portal Akademik Siswa</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Transkrip Nilai Saya</h1>
                    <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                        <span>Daftar nilai tugas, UTS, dan UAS di seluruh mata pelajaran</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                <h2 class="text-sm font-black text-slate-800 uppercase tracking-wider flex items-center gap-2">
                    <i class="bi bi-journal-bookmark text-teal-600"></i> Rekapitulasi Nilai Akademik
                </h2>
                <span class="text-[11px] bg-teal-50 text-teal-700 px-3 py-1 rounded-full font-black ring-1 ring-teal-500/20">Total: {{ $nilaisSiswa->count() }} Mapel</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                            <th class="py-4 px-6">Mata Pelajaran</th>
                            <th class="py-4 px-6 text-center">KKM</th>
                            <th class="py-4 px-6 text-center">Tugas</th>
                            <th class="py-4 px-6 text-center">UTS</th>
                            <th class="py-4 px-6 text-center">UAS</th>
                            <th class="py-4 px-6 text-center">Nilai Akhir</th>
                            <th class="py-4 px-6">Catatan Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                        @forelse($nilaisSiswa as $n)
                        <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                            <td class="py-4 px-6 text-center text-slate-400 font-bold">{{ $n->mapel->kkm ?? 75 }}</td>
                            <td class="py-4 px-6 text-center text-slate-600">{{ $n->nilai_tugas ?? '-' }}</td>
                            <td class="py-4 px-6 text-center text-slate-600">{{ $n->nilai_uts ?? '-' }}</td>
                            <td class="py-4 px-6 text-center text-slate-600">{{ $n->nilai_uas ?? '-' }}</td>
                            <td class="py-4 px-6 text-center font-black text-blue-600 text-sm">
                                <span class="bg-blue-50 px-2.5 py-1 rounded-lg ring-1 ring-blue-500/20">{{ $n->nilai_akhir ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-6 text-slate-500 italic">"{{ $n->catatan_guru ?? 'Tetap semangat belajar.' }}"</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-16 text-center text-slate-400 font-medium">
                                <i class="bi bi-inbox text-3xl block mb-2 text-slate-300"></i>
                                Belum ada entri nilai yang tercatat.
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
        <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03]">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

            <div class="flex items-center gap-5 relative z-10">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0">
                    <i class="bi bi-journal-check text-3xl"></i>
                </div>
                <div class="space-y-1.5">
                    <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                        </span>
                        <span>Akademik & Evaluasi</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Kelola Nilai Siswa <span class="text-xs sm:text-sm font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full ring-1 ring-blue-500/20 align-middle ml-1">Massal</span></h1>
                    <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                        <span>Pilih Tahun Ajaran, Kelas, dan Mata Pelajaran untuk mengisi nilai siswa</span>
                    </p>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
            <div class="bg-emerald-50 ring-1 ring-emerald-500/20 text-emerald-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                        <i class="bi bi-check-lg text-sm font-black"></i>
                    </div>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs font-bold"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 ring-1 ring-rose-500/20 text-rose-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 text-white flex items-center justify-center shadow-md shadow-rose-500/20">
                        <i class="bi bi-exclamation-triangle-fill text-sm font-black"></i>
                    </div>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-rose-100 text-rose-600 flex items-center justify-center transition">
                    <i class="bi bi-x-lg text-xs font-bold"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-50 ring-1 ring-rose-500/20 text-rose-900 p-4 rounded-2xl shadow-sm text-xs font-bold space-y-1">
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
        <div class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
            <form method="GET" action="{{ route('admin.nilai.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">
                
                <!-- Pilih Tahun Ajaran -->
                <div class="md:col-span-3 min-w-0 space-y-1.5">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Tahun Ajaran</label>
                    <select name="id_tahun_ajaran" onchange="this.form.submit()" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                        @foreach($taList as $ta)
                            <option value="{{ $ta->id_tahun_ajaran }}" {{ $selectedTaId == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                                {{ $ta->tahun_ajaran }} {{ $ta->semester ? '('.$ta->semester.')' : '' }} {{ $ta->status == 'aktif' ? '[Aktif]' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Kelas -->
                <div class="md:col-span-3 min-w-0 space-y-1.5">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Kelas Target</label>
                    <select name="id_kelas_ta" required onchange="this.form.submit()" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                        <option value="">-- Pilih Kelas --</option>
                        @foreach($kelasTaList as $kta)
                            <option value="{{ $kta->id }}" {{ $selectedKelasTaId == $kta->id ? 'selected' : '' }}>
                                {{ $kta->kelas->nama_kelas ?? '-' }} (Wali: {{ $kta->waliKelas->nama_lengkap ?? 'Belum ada' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Pilih Mapel -->
                <div class="md:col-span-3 min-w-0 space-y-1.5">
                    <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Mata Pelajaran</label>
                    <select name="id_mapel" onchange="this.form.submit()" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                        <option value="">-- Semua Mata Pelajaran --</option>
                        @foreach($mapelList as $mapel)
                            <option value="{{ $mapel->id_mapel }}" {{ $selectedMapelId == $mapel->id_mapel ? 'selected' : '' }}>
                                {{ $mapel->nama_mapel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tombol Filter -->
                <div class="md:col-span-3">
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
                        <i class="bi bi-funnel-fill"></i> Tampilkan Data Siswa
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
                    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
                        <div class="p-6 border-b border-slate-100 bg-slate-50/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black shadow-md shadow-blue-500/20">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div>
                                    <h2 class="text-base font-black text-slate-900">
                                        Input Nilai: {{ $mapelItem->nama_mapel ?? '-' }}
                                    </h2>
                                    <p class="text-xs text-slate-400 font-semibold">
                                        Kelas: <strong class="text-slate-700">{{ $selectedKelasTa->kelas->nama_kelas ?? '-' }}</strong> | Total Siswa: <strong class="text-slate-700">{{ $siswaKelasList->count() }}</strong>
                                    </p>
                                </div>
                            </div>
                            <div class="text-[11px] font-bold text-indigo-700 bg-indigo-50/80 px-3.5 py-2 rounded-xl ring-1 ring-indigo-500/15 flex items-center gap-2">
                                <i class="bi bi-lightning-charge-fill text-indigo-500"></i> Nilai Akhir dihitung otomatis rata-rata (Tugas, UTS, UAS).
                            </div>
                        </div>

                        @if($siswaKelasList->isEmpty())
                            <div class="p-16 text-center text-slate-400 font-medium">
                                <i class="bi bi-people text-4xl block mb-2 text-slate-300"></i>
                                Belum ada siswa yang terdaftar di kelas ini pada tahun ajaran terpilih.
                            </div>
                        @else
                            <form method="POST" action="{{ route('admin.nilai.store') }}">
                                @csrf
                                <input type="hidden" name="id_kelas_ta" value="{{ $selectedKelasTaId }}">
                                <input type="hidden" name="id_mapel" value="{{ $mapelId }}">

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                                                <th class="py-4 px-4 w-12 text-center">No</th>
                                                <th class="py-4 px-4 w-28">NISN</th>
                                                <th class="py-4 px-4">Nama Siswa</th>
                                                <th class="py-4 px-3 w-24 text-center">Tugas</th>
                                                <th class="py-4 px-3 w-24 text-center">UTS</th>
                                                <th class="py-4 px-3 w-24 text-center">UAS</th>
                                                <th class="py-4 px-4 w-24 text-center">Akhir</th>
                                                <th class="py-4 px-6">Catatan Guru</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                                            @foreach($siswaKelasList as $index => $sk)
                                                @php
                                                    $siswaId = $sk->id_siswa;
                                                    $nilai = $existingNilaiForMapel->get($siswaId);
                                                @endphp
                                                <tr class="hover:bg-slate-50/80 transition duration-150">
                                                    <td class="py-3.5 px-4 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                                    <td class="py-3.5 px-4 text-slate-500 font-bold">{{ $sk->siswa->nisn ?? '-' }}</td>
                                                    <td class="py-3.5 px-4 font-extrabold text-slate-900">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                                    
                                                    <!-- Nilai Tugas -->
                                                    <td class="py-3.5 px-2 text-center">
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               name="nilais[{{ $siswaId }}][tugas]" 
                                                               value="{{ $nilai ? $nilai->nilai_tugas : '' }}" 
                                                               placeholder="0"
                                                               class="w-20 text-center rounded-xl border border-slate-200 px-2 py-1.5 shadow-2xs focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 text-xs font-bold bg-slate-50 focus:bg-white transition">
                                                    </td>

                                                    <!-- Nilai UTS -->
                                                    <td class="py-3.5 px-2 text-center">
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               name="nilais[{{ $siswaId }}][uts]" 
                                                               value="{{ $nilai ? $nilai->nilai_uts : '' }}" 
                                                               placeholder="0"
                                                               class="w-20 text-center rounded-xl border border-slate-200 px-2 py-1.5 shadow-2xs focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 text-xs font-bold bg-slate-50 focus:bg-white transition">
                                                    </td>

                                                    <!-- Nilai UAS -->
                                                    <td class="py-3.5 px-2 text-center">
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               name="nilais[{{ $siswaId }}][uas]" 
                                                               value="{{ $nilai ? $nilai->nilai_uas : '' }}" 
                                                               placeholder="0"
                                                               class="w-20 text-center rounded-xl border border-slate-200 px-2 py-1.5 shadow-2xs focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 text-xs font-bold bg-slate-50 focus:bg-white transition">
                                                    </td>

                                                    <!-- Nilai Akhir (Live / Saved) -->
                                                    <td class="py-3.5 px-4 text-center font-black text-blue-600 text-sm">
                                                        <span class="bg-blue-50 px-2.5 py-1 rounded-lg ring-1 ring-blue-500/20">
                                                            {{ $nilai && $nilai->nilai_akhir !== null ? $nilai->nilai_akhir : '-' }}
                                                        </span>
                                                    </td>

                                                    <!-- Catatan Guru -->
                                                    <td class="py-3.5 px-6">
                                                        <input type="text" 
                                                               name="nilais[{{ $siswaId }}][catatan]" 
                                                               value="{{ $nilai ? $nilai->catatan_guru : '' }}" 
                                                               placeholder="Catatan perkembangan siswa..."
                                                               class="w-full rounded-xl border border-slate-200 px-3.5 py-1.5 shadow-2xs focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 text-xs font-medium bg-slate-50 focus:bg-white transition">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-6 bg-slate-50/80 border-t border-slate-100 flex justify-end">
                                    <button type="submit" class="bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-emerald-500/25 transition-all flex items-center gap-2 text-xs active:scale-[0.98]">
                                        <i class="bi bi-save2-fill"></i> Simpan Nilai {{ $mapelItem->nama_mapel }}
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
