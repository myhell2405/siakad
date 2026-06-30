@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-display text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>LAPORAN EKSEKUTIF</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">MONITORING AKADEMIK</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    REKAP NILAI AKADEMIK PER KELAS, STATISTIK KENAIKAN KELAS, DAN PERINGKAT SISWA TERBAIK
                </p>
            </div>
        </div>

        @if ($id_ta)
            <div class="relative z-10 shrink-0">
                <a href="{{ route('admin.laporan.monitoring', ['id_ta' => $id_ta, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold transition-all shadow-md active:scale-95 uppercase">
                    <i class="bi bi-printer-fill text-signal"></i> CETAK LAPORAN REKAP
                </a>
            </div>
        @endif
    </div>

    {{-- FILTER FORM CARD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs">
        <form action="{{ route('admin.laporan.monitoring') }}" method="GET" class="flex flex-col sm:flex-row gap-5 items-end">
            <div class="flex-1 space-y-2 w-full">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">PILIH TAHUN AJARAN</label>
                <select name="id_ta" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase" onchange="this.form.submit()">
                    <option value="">-- PILIH TAHUN AJARAN --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ strtoupper($ta->semester) }}) {{ strtolower($ta->status) == 'aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto bg-void hover:bg-black text-white font-mono font-bold py-3 px-8 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase">
                    <i class="bi bi-funnel-fill text-signal"></i> TAMPILKAN REKAP
                </button>
            </div>
        </form>
    </div>

    @if ($id_ta && $rekapKelas->count() > 0)
        <!-- Tabel 1: Rekap Nilai Per Kelas -->
        <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-black/10 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                        <i class="bi bi-bar-chart-line-fill text-signal"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-void text-sm uppercase">REKAP NILAI PER KELAS</h3>
                        <p class="text-xs text-gray-500 font-mono uppercase">RATA-RATA SERTA CAPAIAN TERTINGGI DAN TERENDAH</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                            <th class="py-4 pl-6 text-center w-16">NO</th>
                            <th class="py-4 px-6">KELAS</th>
                            <th class="py-4 px-6">WALI KELAS</th>
                            <th class="py-4 px-6 text-center">JUMLAH SISWA</th>
                            <th class="py-4 px-6 text-center">NILAI RATA-RATA</th>
                            <th class="py-4 px-6 text-center">TERTINGGI</th>
                            <th class="py-4 pr-6 text-center">TERENDAH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                        @foreach ($rekapKelas as $idx => $rk)
                            <tr class="hover:bg-gray-50/80 transition duration-150">
                                <td class="py-4 pl-6 text-center font-mono font-bold text-gray-400">{{ $idx + 1 }}</td>
                                <td class="py-4 px-6 font-bold text-void uppercase text-sm">{{ $rk['nama_kelas'] }}</td>
                                <td class="py-4 px-6 font-bold text-gray-700 uppercase">{{ $rk['wali_kelas'] }}</td>
                                <td class="py-4 px-6 text-center font-mono font-bold text-void">
                                    <span class="px-2.5 py-1 bg-gray-100 text-void border border-black/10 rounded uppercase text-[11px]">{{ $rk['jumlah_siswa'] }} SISWA</span>
                                </td>
                                <td class="py-4 px-6 text-center font-mono font-black text-cobalt text-sm">{{ $rk['rata_rata'] }}</td>
                                <td class="py-4 px-6 text-center font-mono font-black text-emerald-700 text-sm bg-emerald-50/50">{{ $rk['tertinggi'] }}</td>
                                <td class="py-4 pr-6 text-center font-mono font-black text-red-600 text-sm bg-red-50/50">{{ $rk['terendah'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Tabel 2: Data Kenaikan Kelas -->
            <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden flex flex-col">
                <div class="p-6 border-b border-black/10 bg-gray-50 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                        <i class="bi bi-graph-up-arrow text-signal"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-void text-sm uppercase">DATA KENAIKAN KELAS</h3>
                        <p class="text-xs text-gray-500 font-mono uppercase">DISTRIBUSI KELULUSAN DAN KENAIKAN</p>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                                <th class="py-4 pl-6 text-center w-14">NO</th>
                                <th class="py-4 px-4">KELAS</th>
                                <th class="py-4 px-4 text-center">JML SISWA</th>
                                <th class="py-4 px-4 text-center">NAIK / LULUS</th>
                                <th class="py-4 pr-6 text-center">TIDAK NAIK</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                            @foreach ($rekapKelas as $idx => $rk)
                                <tr class="hover:bg-gray-50/80 transition duration-150">
                                    <td class="py-4 pl-6 text-center font-mono font-bold text-gray-400">{{ $idx + 1 }}</td>
                                    <td class="py-4 px-4 font-bold text-void uppercase">{{ $rk['nama_kelas'] }}</td>
                                    <td class="py-4 px-4 text-center font-mono font-bold text-gray-700">{{ $rk['jumlah_siswa'] }}</td>
                                    <td class="py-4 px-4 text-center font-mono font-black text-emerald-800 bg-emerald-50/50">
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 border border-emerald-300 rounded">{{ $rk['naik_kelas'] }}</span>
                                    </td>
                                    <td class="py-4 pr-6 text-center font-mono font-black text-red-700 bg-red-50/50">
                                        <span class="px-2.5 py-1 bg-void text-signal border border-black rounded">{{ $rk['tidak_naik'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel 3: Peringkat Siswa Terbaik -->
            <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden flex flex-col">
                <div class="p-6 border-b border-black/10 bg-gray-50 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                            <i class="bi bi-trophy-fill text-signal"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-void text-sm uppercase">PERINGKAT SISWA TERBAIK</h3>
                            <p class="text-xs text-gray-500 font-mono uppercase">BERDASARKAN AKUMULASI NILAI RATA-RATA</p>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase font-mono font-bold bg-surface text-void border border-black/10 px-3 py-1 rounded">TOP 5 SEKOLAH</span>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                                <th class="py-4 pl-6 text-center w-14">RANK</th>
                                <th class="py-4 px-4">NAMA SISWA</th>
                                <th class="py-4 px-4 text-center">KELAS</th>
                                <th class="py-4 pr-6 text-center">RATA-RATA</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                            @forelse ($topSiswa as $idx => $ts)
                                <tr class="hover:bg-gray-50/80 transition duration-150">
                                    <td class="py-4 pl-6 text-center font-mono font-black text-void text-sm">
                                        @if($idx === 0) 🥇
                                        @elseif($idx === 1) 🥈
                                        @elseif($idx === 2) 🥉
                                        @else #{{ $idx + 1 }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 font-bold uppercase text-void">{{ $ts['siswa']->nama_siswa ?? '-' }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2.5 py-1 bg-gray-100 text-void border border-black/10 font-mono font-bold rounded uppercase text-[10px]">{{ $ts['kelas_nama'] }}</span>
                                    </td>
                                    <td class="py-4 pr-6 text-center font-mono font-black text-cobalt text-sm">{{ $ts['rata_rata'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-gray-400 font-mono uppercase">BELUM ADA DATA NILAI.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-black/10 shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-void text-signal flex items-center justify-center mx-auto mb-4 font-black shadow-md border border-black">
                <i class="bi bi-bar-chart-line text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-void uppercase">MENUNGGU PILIHAN FILTER</h3>
            <p class="text-xs text-gray-500 font-mono uppercase mt-1">Silakan pilih Tahun Ajaran di atas untuk melihat rekap monitoring akademik kepala sekolah.</p>
        </div>
    @endif

</div>
@endsection
