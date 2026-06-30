@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03]">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0">
                <i class="bi bi-display text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Laporan & Eksekutif</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Monitoring Akademik</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Rekap nilai akademik per kelas, statistik kenaikan kelas, dan peringkat siswa terbaik</span>
                </p>
            </div>
        </div>

        @if ($id_ta)
            <div class="relative z-10 shrink-0">
                <a href="{{ route('admin.laporan.monitoring', ['id_ta' => $id_ta, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-2xl text-xs font-bold transition-all shadow-md shadow-indigo-500/20 active:scale-95">
                    <i class="bi bi-printer-fill"></i> Cetak Laporan Rekap
                </a>
            </div>
        @endif
    </div>

    {{-- ================================================
         FILTER FORM CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.laporan.monitoring') }}" method="GET" class="flex flex-col sm:flex-row gap-5 items-end">
            <div class="flex-1 space-y-1.5 w-full">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Pilih Tahun Ajaran</label>
                <select name="id_ta" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ ucfirst($ta->semester) }}) {{ $ta->status == 'Aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-8 rounded-2xl shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
                    <i class="bi bi-funnel-fill"></i> Tampilkan Rekap
                </button>
            </div>
        </form>
    </div>

    @if ($id_ta && $rekapKelas->count() > 0)
        <!-- Tabel 1: Rekap Nilai Per Kelas -->
        <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black shadow-md shadow-blue-500/20">
                        <i class="bi bi-bar-chart-line-fill"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider">Rekap Nilai Per Kelas</h3>
                        <p class="text-xs text-slate-400 font-semibold">Rata-rata serta capaian tertinggi dan terendah</p>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">Kelas</th>
                            <th class="py-4 px-6">Wali Kelas</th>
                            <th class="py-4 px-6 text-center">Jumlah Siswa</th>
                            <th class="py-4 px-6 text-center">Nilai Rata-rata</th>
                            <th class="py-4 px-6 text-center text-emerald-600">Tertinggi</th>
                            <th class="py-4 px-6 text-center text-rose-600">Terendah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                        @foreach ($rekapKelas as $idx => $rk)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-4 px-6 text-center font-bold text-slate-400">{{ $idx + 1 }}</td>
                                <td class="py-4 px-6 font-extrabold text-slate-900 text-sm">{{ $rk['nama_kelas'] }}</td>
                                <td class="py-4 px-6 font-bold text-slate-700">{{ $rk['wali_kelas'] }}</td>
                                <td class="py-4 px-6 text-center font-extrabold text-slate-800">
                                    <span class="px-2.5 py-1 bg-slate-100 text-slate-700 rounded-lg text-xs">{{ $rk['jumlah_siswa'] }} Siswa</span>
                                </td>
                                <td class="py-4 px-6 text-center font-black text-blue-600 text-sm">{{ $rk['rata_rata'] }}</td>
                                <td class="py-4 px-6 text-center font-black text-emerald-600 text-sm bg-emerald-50/30">{{ $rk['tertinggi'] }}</td>
                                <td class="py-4 px-6 text-center font-black text-rose-600 text-sm bg-rose-50/30">{{ $rk['terendah'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Tabel 2: Data Kenaikan Kelas -->
            <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 bg-slate-50/60 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black shadow-md shadow-emerald-500/20">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider">Data Kenaikan Kelas</h3>
                        <p class="text-xs text-slate-400 font-semibold">Distribusi kelulusan dan kenaikan</p>
                    </div>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                                <th class="py-4 px-4 text-center w-12">No</th>
                                <th class="py-4 px-4">Kelas</th>
                                <th class="py-4 px-4 text-center">Jml Siswa</th>
                                <th class="py-4 px-4 text-center text-emerald-600">Naik / Lulus</th>
                                <th class="py-4 px-4 text-center text-rose-600">Tidak Naik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                            @foreach ($rekapKelas as $idx => $rk)
                                <tr class="hover:bg-slate-50/80 transition duration-150">
                                    <td class="py-4 px-4 text-center font-bold text-slate-400">{{ $idx + 1 }}</td>
                                    <td class="py-4 px-4 font-extrabold text-slate-900">{{ $rk['nama_kelas'] }}</td>
                                    <td class="py-4 px-4 text-center font-bold text-slate-700">{{ $rk['jumlah_siswa'] }}</td>
                                    <td class="py-4 px-4 text-center font-black text-emerald-600 bg-emerald-50/30">
                                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-md">{{ $rk['naik_kelas'] }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center font-black text-rose-600 bg-rose-50/30">
                                        <span class="px-2.5 py-1 bg-rose-100 text-rose-800 rounded-md">{{ $rk['tidak_naik'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel 3: Peringkat Siswa Terbaik -->
            <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 bg-slate-50/60 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-black shadow-md shadow-amber-500/20">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-900 text-sm uppercase tracking-wider">Peringkat Siswa Terbaik</h3>
                            <p class="text-xs text-slate-400 font-semibold">Berdasarkan akumulasi nilai rata-rata</p>
                        </div>
                    </div>
                    <span class="text-[10px] uppercase tracking-wider font-black bg-amber-50 text-amber-700 ring-1 ring-amber-500/20 px-3 py-1 rounded-full">Top 5 Sekolah</span>
                </div>
                <div class="overflow-x-auto flex-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                                <th class="py-4 px-4 text-center w-12">Rank</th>
                                <th class="py-4 px-4">Nama Siswa</th>
                                <th class="py-4 px-4 text-center">Kelas</th>
                                <th class="py-4 px-4 text-center">Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                            @forelse ($topSiswa as $idx => $ts)
                                <tr class="hover:bg-slate-50/80 transition duration-150">
                                    <td class="py-4 px-4 text-center font-black text-amber-500 text-sm">
                                        @if($idx === 0) 🥇
                                        @elseif($idx === 1) 🥈
                                        @elseif($idx === 2) 🥉
                                        @else #{{ $idx + 1 }}
                                        @endif
                                    </td>
                                    <td class="py-4 px-4 font-extrabold uppercase text-slate-900">{{ $ts['siswa']->nama_siswa ?? '-' }}</td>
                                    <td class="py-4 px-4 text-center">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-bold rounded-lg text-[11px]">{{ $ts['kelas_nama'] }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-center font-black text-blue-600 text-sm">{{ $ts['rata_rata'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-slate-400 italic font-medium">Belum ada data nilai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl ring-1 ring-slate-900/[0.03] shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)]">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 font-black shadow-inner">
                <i class="bi bi-bar-chart-line text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-slate-800">Menunggu Pilihan Filter</h3>
            <p class="text-xs text-slate-400 font-semibold mt-1">Silakan pilih Tahun Ajaran di atas untuk melihat rekap monitoring akademik kepala sekolah.</p>
        </div>
    @endif

</div>
@endsection
