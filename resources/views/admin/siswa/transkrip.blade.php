@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    <div class="mb-4 flex items-center justify-between">
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 text-xs font-bold font-mono text-gray-500 hover:text-void transition-colors uppercase">
            <i class="bi bi-arrow-left"></i> KEMBALI KE DIREKTORI SISWA
        </a>
        <a href="{{ route('admin.laporan.transkrip', ['id_siswa' => $siswa->id]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-void text-white rounded-lg hover:bg-black transition-colors font-bold font-mono text-xs uppercase shadow-sm">
            <i class="bi bi-printer-fill"></i> CETAK TRANSKRIP
        </a>
    </div>

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
                    <span>TRANSKRIP NILAI SISWA</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">{{ $siswa->nama_siswa ?? $siswa->nama_lengkap }}</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    NIS/NISN: <strong class="text-void">{{ $siswa->nis ?: '-' }} / {{ $siswa->nisn ?: '-' }}</strong> &bull; 
                    DAFTAR NILAI TUGAS, UTS, DAN UAS DI SELURUH MATA PELAJARAN
                </p>
            </div>
        </div>
    </div>

        <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
            @php
                $groupedNilai = $nilaisSiswa->groupBy(function($n) {
                    $ta = $n->kelasTahunAjaran->tahunAjaran ?? null;
                    $kelas = $n->kelasTahunAjaran->kelas ?? null;
                    $taName = $ta ? $ta->tahun_ajaran . ' - ' . strtoupper($ta->semester) : 'SEMESTER TIDAK DIKETAHUI';
                    $kelasName = $kelas ? strtoupper($kelas->nama_kelas) : 'KELAS TIDAK DIKETAHUI';
                    return $taName . ' (' . $kelasName . ')';
                })->sortKeysDesc();
            @endphp

            @forelse($groupedNilai as $semester => $nilais)
                <div class="p-6 border-b border-black/10 flex items-center justify-between bg-gray-50">
                    <h2 class="text-sm font-black text-void uppercase tracking-wider font-mono flex items-center gap-2">
                        <i class="bi bi-calendar3 text-cobalt text-base"></i> {{ $semester }}
                    </h2>
                    <span class="text-[10px] bg-void text-white px-3 py-1 rounded font-mono font-bold uppercase">TOTAL: {{ $nilais->count() }} MAPEL</span>
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
                            @foreach($nilais as $n)
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <div class="py-16 text-center">
                    <div class="flex flex-col items-center justify-center">
                        <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 border border-black/5">
                            <i class="bi bi-inbox text-3xl"></i>
                        </div>
                        <h4 class="font-bold text-void text-base uppercase font-mono">BELUM ADA ENTRI NILAI</h4>
                        <p class="text-xs text-gray-500 mt-1 max-w-sm">Daftar nilai akademik belum dicatat oleh guru mata pelajaran.</p>
                    </div>
                </div>
            @endforelse
        </div>

</div>
@endsection
