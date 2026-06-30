@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-book-half text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50/80 text-blue-700 ring-1 ring-blue-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Kurikulum & Akademik</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? 'Data Mata Pelajaran' }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-blue-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total <strong class="text-slate-700">{{ $mapel->total() }}</strong> Mapel Terdaftar</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.mapel.create') }}"
           class="group relative z-10 inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start">
            <span class="tracking-wide">Tambah Mapel Baru</span>
            <div class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-sm font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         SEARCH & FILTER BAR (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-[2rem] p-4 sm:p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.mapel.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-96">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama mata pelajaran..."
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 hover:bg-slate-100/70 focus:bg-white border border-slate-200/80 rounded-2xl text-xs font-bold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="bi bi-search text-sm"></i>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if(request('search'))
                    <a href="{{ route('admin.mapel.index') }}"
                       class="px-5 py-3 rounded-2xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold transition flex items-center gap-2">
                        <i class="bi bi-x-circle-fill"></i> Reset
                    </a>
                @endif
                <button type="submit"
                        class="px-7 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-2xl transition shadow-md active:scale-95 w-full sm:w-auto flex items-center justify-center gap-2">
                    <i class="bi bi-filter"></i> Filter Cari
                </button>
            </div>
        </form>
    </div>

    {{-- ================================================
         TABLE SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-8 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="pb-4 pl-4 w-16">No</th>
                        <th class="pb-4">Nama Mata Pelajaran</th>
                        <th class="pb-4 text-center">KKM</th>
                        <th class="pb-4 text-center">Guru Pengampu</th>
                        <th class="pb-4 pr-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                    @forelse($mapel as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="py-4 pl-4 text-slate-400 font-semibold">
                            {{ $mapel->firstItem() + $loop->index }}
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-sm shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-book"></i>
                                </div>
                                <span class="text-sm font-black text-slate-900">{{ $item->nama_mapel }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-black bg-slate-100 text-slate-800 ring-1 ring-slate-200">
                                {{ $item->kkm }}
                            </span>
                        </td>
                        <td class="py-4 text-center">
                            @if($item->guru && $item->guru->count() > 0)
                                <div class="flex flex-wrap gap-1.5 justify-center">
                                    @foreach($item->guru->take(2) as $g)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 font-bold text-[11px] ring-1 ring-blue-500/20">
                                            <i class="bi bi-person-check-fill text-[10px]"></i> {{ $g->nama_lengkap }}
                                        </span>
                                    @endforeach
                                    @if($item->guru->count() > 2)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full bg-slate-100 text-slate-600 font-black text-[10px] ring-1 ring-slate-200" title="{{ $item->guru->slice(2)->pluck('nama_lengkap')->implode(', ') }}">
                                            +{{ $item->guru->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-slate-400 italic font-medium text-xs">Belum ada pengampu</span>
                            @endif
                        </td>
                        <td class="py-4 pr-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                {{-- ATUR GURU BUTTON --}}
                                <a href="{{ route('admin.mapel.guru.index', $item->id_mapel) }}"
                                   class="w-8 h-8 rounded-xl bg-indigo-50 hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-600 text-indigo-600 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-indigo-500/20 active:scale-95"
                                   title="Atur Guru Pengampu">
                                    <i class="bi bi-people-fill text-xs"></i>
                                </a>

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.mapel.edit', $item->id_mapel) }}"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-amber-500/20 active:scale-95"
                                   title="Edit Mapel">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.mapel.destroy', $item->id_mapel) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95" title="Hapus Mapel">
                                        <i class="bi bi-trash3-fill text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-50 flex items-center justify-center text-slate-300 text-2xl">
                                    <i class="bi bi-book"></i>
                                </div>
                                <span>Data mata pelajaran belum tersedia atau tidak ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-8 pt-6 border-t border-slate-100">
            <x-pagination :paginator="$mapel" />
        </div>
    </div>

</div>

@endsection