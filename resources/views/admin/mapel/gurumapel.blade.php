@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-indigo-500/10 via-blue-500/10 to-cyan-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-blue-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-people-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-indigo-50/80 text-indigo-700 ring-1 ring-indigo-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>Alokasi Tenaga Pendidik</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    Daftar Guru Pengampu
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-book-half text-indigo-500"></i> Mata Pelajaran: <strong class="text-indigo-700 font-black">{{ $mapel->nama_mapel }}</strong></span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.mapel.index') }}"
           class="group relative z-10 inline-flex items-center gap-3 pl-5 pr-2 py-2 bg-slate-100 hover:bg-slate-900 text-slate-700 hover:text-white font-bold text-xs rounded-full transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start shadow-2xs">
            <span>Kembali ke Kurikulum</span>
            <div class="w-7 h-7 rounded-full bg-white group-hover:bg-white/20 flex items-center justify-center text-slate-800 group-hover:text-white transition-transform group-hover:-translate-x-0.5 shadow-2xs">
                <i class="bi bi-arrow-left text-xs font-black"></i>
            </div>
        </a>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 ring-1 ring-emerald-500/30 text-emerald-900 p-5 rounded-3xl shadow-sm flex items-center gap-3.5 animate-fade-in font-bold text-xs">
            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/20">
                <i class="bi bi-check-lg text-base font-black"></i>
            </div>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-gradient-to-r from-rose-50 to-red-50 ring-1 ring-rose-500/30 text-rose-900 p-5 rounded-3xl shadow-sm flex items-center gap-3.5 animate-fade-in font-bold text-xs">
            <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-rose-500/20">
                <i class="bi bi-exclamation-triangle-fill text-base font-black"></i>
            </div>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ================================================
         FORM TAMBAH GURU PENGAMPU (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] space-y-6">
        
        <div class="flex items-center gap-3.5 pb-5 border-b border-slate-100">
            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-600 text-white flex items-center justify-center font-bold shadow-md shadow-indigo-500/20">
                <i class="bi bi-person-plus-fill text-lg"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-slate-900 tracking-tight">Tambahkan Guru Pengampu</h3>
                <p class="text-xs text-slate-400 font-semibold">Pilih guru yang bertugas mengajar mata pelajaran ini</p>
            </div>
        </div>

        <form action="{{ route('admin.mapel.guru.store', $mapel->id_mapel) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4">
            @csrf
            
            <div class="relative w-full flex-1">
                <select name="id_guru" required
                        class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-5 py-4 text-xs font-bold text-slate-900 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner appearance-none">
                    <option value="">-- Pilih Guru Pengampu dari Daftar --</option>
                    @foreach($availableGuru as $g)
                        <option value="{{ $g->id }}">{{ $g->nama_lengkap }} (NIP: {{ $g->nip }})</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                    <i class="bi bi-chevron-down text-xs font-black"></i>
                </div>
            </div>

            <button type="submit"
                    class="group px-8 py-4 rounded-2xl bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white font-bold text-xs shadow-lg shadow-indigo-500/25 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-3">
                <span>Tambahkan Guru</span>
                <div class="w-6 h-6 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:translate-x-0.5">
                    <i class="bi bi-plus-lg text-xs font-black"></i>
                </div>
            </button>
        </form>
    </div>

    {{-- ================================================
         TABEL DAFTAR GURU PENGAMPU
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-8 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03] overflow-hidden space-y-6">
        
        <div class="flex items-center justify-between px-2">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-wider">Daftar Guru Terdaftar</h3>
            <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-black text-xs">{{ $guruMapel->count() }} Guru</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="pb-4 pl-4 w-16">No</th>
                        <th class="pb-4">Nama Guru</th>
                        <th class="pb-4">NIP</th>
                        <th class="pb-4">Jabatan</th>
                        <th class="pb-4 pr-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                    @forelse($guruMapel as $guru)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="py-4 pl-4 text-slate-400 font-semibold">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span class="text-sm font-black text-slate-900">{{ $guru->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-slate-500 font-semibold">
                            {{ $guru->nip }}
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-black bg-slate-100 text-slate-700">
                                {{ $guru->jabatan_guru ?? '-' }}
                            </span>
                        </td>
                        <td class="py-4 pr-4 text-right">
                            <form action="{{ route('admin.mapel.guru.destroy', [$mapel->id_mapel, $guru->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus guru ini dari pengampu mata pelajaran {{ $mapel->nama_mapel }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-rose-600 hover:text-white font-bold text-xs transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95">
                                    <i class="bi bi-trash3-fill text-[11px]"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 text-2xl">
                                    <i class="bi bi-people"></i>
                                </div>
                                <span>Belum ada guru pengampu yang ditugaskan pada mata pelajaran ini.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection