@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-person-badge-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>LAPORAN SEKOLAH</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">IDENTITAS GURU KELAS</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    PILIH TAHUN AJARAN DAN KELAS UNTUK MELIHAT ATAU MENCETAK PROFIL WALI KELAS YANG BERTUGAS
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER FORM CARD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs">
        <form action="{{ route('admin.laporan.identitas-guru') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
            <div class="space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">TAHUN AJARAN</label>
                <select name="id_ta" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase" onchange="this.form.submit()">
                    <option value="">-- PILIH TAHUN AJARAN --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ strtoupper($ta->semester) }}) {{ strtolower($ta->status) == 'aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">KELAS TARGET</label>
                <select name="id_kelas" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all disabled:opacity-50 uppercase" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- PILIH KELAS --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ strtoupper($k->kelas->nama_kelas ?? '-') }} (WALI: {{ strtoupper($k->waliKelas->nama_lengkap ?? '-') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-void hover:bg-black text-white font-mono font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase">
                    <i class="bi bi-funnel-fill text-signal"></i> FILTER DATA GURU
                </button>
            </div>
        </form>
    </div>

    {{-- DATA CONTENT SECTION --}}
    @if ($selectedKelas)
        @php
            $g = $selectedKelas->waliKelas;
        @endphp
        <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden max-w-3xl mx-auto">
            <div class="p-6 border-b border-black/10 flex justify-between items-center bg-gray-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-bold shadow-xs">
                        <i class="bi bi-person-workspace text-signal"></i>
                    </div>
                    <div>
                        <h3 class="font-black text-void text-base uppercase">PRATINJAU PROFIL WALI KELAS</h3>
                        <p class="text-xs text-gray-500 font-mono uppercase">KELAS: <strong class="text-void">{{ strtoupper($selectedKelas->kelas->nama_kelas ?? '-') }}</strong> | TA: <strong class="text-void">{{ $selectedKelas->tahunAjaran->tahun_ajaran ?? '-' }}</strong></p>
                    </div>
                </div>
                @if ($g)
                    <a href="{{ route('admin.laporan.identitas-guru', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-void hover:bg-black text-white rounded-xl text-xs font-mono font-bold transition-all shadow-md active:scale-95 uppercase">
                        <i class="bi bi-printer-fill text-signal"></i> CETAK LEMBAR RESMI
                    </a>
                @endif
            </div>

            <div class="p-8">
                @if ($g)
                    <div class="divide-y divide-black/5 text-xs">
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">NAMA LENGKAP</span>
                            <span class="col-span-2 font-black text-void text-sm uppercase">{{ $g->nama_lengkap }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">NIP</span>
                            <span class="col-span-2 font-mono font-bold text-gray-700">{{ $g->nip ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">NUPTK</span>
                            <span class="col-span-2 font-mono font-bold text-gray-700">{{ $g->nuptk ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">TEMPAT, TGL LAHIR</span>
                            <span class="col-span-2 font-bold text-gray-700 uppercase">{{ $g->tempat_lahir ?? '-' }}, {{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">PENDIDIKAN TERAKHIR</span>
                            <span class="col-span-2 font-bold text-gray-700 uppercase">{{ $g->pendidikan_terakhir ?? 'S1. PGSD' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">JABATAN GURU</span>
                            <span class="col-span-2 font-mono font-black text-cobalt bg-gray-100 px-3 py-1 rounded border border-black/5 w-fit uppercase">GURU KELAS</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">PANGKAT / GOL</span>
                            <span class="col-span-2 font-bold text-gray-700 uppercase">{{ $g->pangkat_gol ?? 'AHLI PERTAMA, IX' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 py-3.5">
                            <span class="font-mono font-bold uppercase text-gray-400">TUGAS MENGAJAR KLS</span>
                            <span class="col-span-2 font-black text-void uppercase">{{ $selectedKelas->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12 text-void bg-surface rounded-2xl border border-black p-6 font-mono">
                        <i class="bi bi-exclamation-triangle-fill text-3xl mb-2 block text-signal"></i>
                        <span class="font-bold text-xs block uppercase">BELUM ADA GURU YANG DITUGASKAN SEBAGAI WALI KELAS UNTUK KELAS INI.</span>
                        <span class="text-[11px] text-gray-500 mt-1 block uppercase">Silakan atur wali kelas terlebih dahulu di menu Pembagian Kelas Aktif.</span>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-black/10 shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-void text-signal flex items-center justify-center mx-auto mb-4 font-black shadow-md border border-black">
                <i class="bi bi-person-badge text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-void uppercase">MENUNGGU PILIHAN FILTER</h3>
            <p class="text-xs text-gray-500 font-mono uppercase mt-1">Silakan pilih Tahun Ajaran dan Kelas di atas untuk melihat identitas guru kelas.</p>
        </div>
    @endif

</div>
@endsection
