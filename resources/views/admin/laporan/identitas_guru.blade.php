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
                <i class="bi bi-person-badge-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Laporan Sekolah</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Identitas Guru Kelas</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Pilih Tahun Ajaran dan Kelas untuk melihat atau mencetak profil wali kelas yang bertugas</span>
                </p>
            </div>
        </div>
    </div>

    {{-- ================================================
         FILTER FORM CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.laporan.identitas-guru') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Tahun Ajaran</label>
                <select name="id_ta" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ ucfirst($ta->semester) }}) {{ $ta->status == 'Aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Kelas Target</label>
                <select name="id_kelas" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner disabled:opacity-50 disabled:cursor-not-allowed" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ $k->kelas->nama_kelas ?? '-' }} (Wali: {{ $k->waliKelas->nama_lengkap ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
                    <i class="bi bi-funnel-fill"></i> Filter Data Guru
                </button>
            </div>
        </form>
    </div>

    {{-- ================================================
         DATA CONTENT SECTION
         ================================================ --}}
    @if ($selectedKelas)
        @php
            $g = $selectedKelas->waliKelas;
        @endphp
        <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden max-w-3xl mx-auto">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/60">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black shadow-md shadow-blue-500/20">
                        <i class="bi bi-person-workspace"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base">Pratinjau Profil Wali Kelas</h3>
                        <p class="text-xs text-slate-400 font-semibold">Kelas: <strong class="text-slate-700">{{ $selectedKelas->kelas->nama_kelas ?? '-' }}</strong> | TA: <strong class="text-slate-700">{{ $selectedKelas->tahunAjaran->tahun_ajaran ?? '-' }}</strong></p>
                    </div>
                </div>
                @if ($g)
                    <a href="{{ route('admin.laporan.identitas-guru', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-500/20 active:scale-95">
                        <i class="bi bi-printer-fill"></i> Cetak Lembar Resmi
                    </a>
                @endif
            </div>

            <div class="p-8">
                @if ($g)
                    <div class="divide-y divide-slate-100 text-xs">
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">Nama Lengkap</span>
                            <span class="col-span-2 font-black text-slate-900 text-sm uppercase">{{ $g->nama_lengkap }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">NIP</span>
                            <span class="col-span-2 font-mono font-bold text-slate-700">{{ $g->nip ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">NUPTK</span>
                            <span class="col-span-2 font-mono font-bold text-slate-700">{{ $g->nuptk ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">Tempat, Tgl Lahir</span>
                            <span class="col-span-2 font-bold text-slate-700">{{ $g->tempat_lahir ?? '-' }}, {{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">Pendidikan Terakhir</span>
                            <span class="col-span-2 font-bold text-slate-700">{{ $g->pendidikan_terakhir ?? 'S1. PGSD' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">Jabatan Guru</span>
                            <span class="col-span-2 font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-lg w-fit ring-1 ring-blue-500/20">Guru Kelas</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">Pangkat / Gol</span>
                            <span class="col-span-2 font-bold text-slate-700">{{ $g->pangkat_gol ?? 'Ahli Pertama, IX' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-black uppercase tracking-wider text-slate-400">Tugas Mengajar Kls</span>
                            <span class="col-span-2 font-extrabold text-slate-900">{{ $selectedKelas->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 text-amber-600 bg-amber-50/50 rounded-2xl ring-1 ring-amber-500/20">
                        <i class="bi bi-exclamation-triangle-fill text-3xl mb-2 block"></i>
                        <span class="font-bold text-xs block">Belum ada Guru yang ditugaskan sebagai Wali Kelas untuk kelas ini.</span>
                        <span class="text-[11px] text-amber-500 font-medium">Silakan atur wali kelas terlebih dahulu di menu Pembagian Kelas Aktif.</span>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl ring-1 ring-slate-900/[0.03] shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)]">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 font-black shadow-inner">
                <i class="bi bi-person-badge text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-slate-800">Menunggu Pilihan Filter</h3>
            <p class="text-xs text-slate-400 font-semibold mt-1">Silakan pilih Tahun Ajaran dan Kelas di atas untuk melihat identitas guru kelas.</p>
        </div>
    @endif

</div>
@endsection
