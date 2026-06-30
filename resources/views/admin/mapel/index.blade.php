@extends('admin.layout')

@section('content')

<div class="space-y-8 font-sans text-gray-900 pb-16">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-book-half text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>KURIKULUM & AKADEMIK</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? 'DATA MATA PELAJARAN') }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL <strong class="text-void font-black">{{ $mapel->total() }}</strong> MAPEL TERDAFTAR</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.mapel.create') }}"
           class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase">
            <span>TAMBAH MAPEL BARU</span>
            <i class="bi bi-plus-lg text-signal font-bold text-sm"></i>
        </a>
    </div>

    {{-- SEARCH & FILTER BAR --}}
    <div class="bg-white rounded-3xl p-6 border border-black/10 shadow-xs">
        <form action="{{ route('admin.mapel.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4 font-mono text-xs">
            <div class="relative w-full sm:w-96">
                <div class="absolute left-4 text-gray-400">
                    <i class="bi bi-search"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama mata pelajaran..."
                       class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl pl-11 pr-24 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                @if(request('search'))
                    <a href="{{ route('admin.mapel.index') }}" class="absolute right-3 bg-gray-200 hover:bg-signal hover:text-white transition px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono">
                <thead>
                    <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        <th class="py-3.5 pl-3 text-center w-16">NO</th>
                        <th class="py-3.5">NAMA MATA PELAJARAN</th>
                        <th class="py-3.5 text-center">KKM</th>
                        <th class="py-3.5 text-center">GURU PENGAMPU</th>
                        <th class="py-3.5 pr-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                    @forelse($mapel as $item)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-3 text-center text-gray-400">
                            {{ $mapel->firstItem() + $loop->index }}
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-void text-white flex items-center justify-center font-black text-sm shrink-0">
                                    <i class="bi bi-book"></i>
                                </div>
                                <span class="font-black text-void group-hover:text-cobalt transition-colors text-base font-sans uppercase">{{ $item->nama_mapel }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-gray-100 border border-black/5 text-xs font-bold text-void">
                                {{ $item->kkm }}
                            </span>
                        </td>
                        <td class="py-4 text-center">
                            @if($item->guru && $item->guru->count() > 0)
                                <div class="flex flex-wrap gap-1.5 justify-center">
                                    @foreach($item->guru->take(2) as $g)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gray-100 text-void font-bold text-[10px] uppercase">
                                            <i class="bi bi-person-check-fill text-cobalt"></i> {{ strtoupper($g->nama_lengkap) }}
                                        </span>
                                    @endforeach
                                    @if($item->guru->count() > 2)
                                        <span class="inline-flex items-center px-2 py-1 rounded-lg bg-void text-white font-bold text-[10px]" title="{{ $item->guru->slice(2)->pluck('nama_lengkap')->implode(', ') }}">
                                            +{{ $item->guru->count() - 2 }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <span class="text-gray-400 italic font-medium text-[11px] uppercase">BELUM ADA PENGAMPU</span>
                            @endif
                        </td>
                        <td class="py-4 pr-3 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <a href="{{ route('admin.mapel.guru.index', $item->id_mapel) }}"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void text-void hover:text-white flex items-center justify-center transition"
                                   title="Atur Guru Pengampu">
                                    <i class="bi bi-people-fill text-xs"></i>
                                </a>
                                <a href="{{ route('admin.mapel.edit', $item->id_mapel) }}"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white text-void flex items-center justify-center transition"
                                   title="Edit Mapel">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>
                                <form action="{{ route('admin.mapel.destroy', $item->id_mapel) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-signal hover:text-white text-void flex items-center justify-center transition" title="Hapus Mapel">
                                        <i class="bi bi-trash3-fill text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mb-3">
                                    <i class="bi bi-book text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-sm uppercase">BELUM ADA DATA MATA PELAJARAN</h4>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($mapel->hasPages())
            {{ $mapel->links('components.pagination') }}
        @endif
    </div>

</div>

@endsection