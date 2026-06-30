@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-calendar-range-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>KALENDER AKADEMIK</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? 'DATA TAHUN AJARAN') }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL <strong class="text-void font-black">{{ $tahunAjaran->total() }}</strong> PERIODE TERDAFTAR</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.tahun-ajaran.create') }}"
           class="inline-flex items-center gap-3 px-6 py-3.5 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase">
            <i class="bi bi-plus-lg text-signal"></i> TAMBAH PERIODE BARU
        </a>
    </div>

    {{-- SEARCH & FILTER BAR --}}
    <div class="bg-white rounded-2xl p-4 border border-black/10 shadow-xs">
        <form action="{{ route('admin.tahun-ajaran.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-96">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari tahun (misal: 2024) atau semester..."
                       class="w-full pl-11 pr-4 py-3 bg-gray-50 hover:bg-gray-100/70 focus:bg-white border border-black/10 rounded-xl text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-void transition-all">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                    <i class="bi bi-search text-sm"></i>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if(request('search'))
                    <a href="{{ route('admin.tahun-ajaran.index') }}"
                       class="px-5 py-2.5 rounded-xl bg-gray-200 hover:bg-signal hover:text-white text-void font-mono font-bold text-xs transition uppercase flex items-center gap-2">
                        <i class="bi bi-x-circle-fill"></i> RESET
                    </a>
                @endif
                <button type="submit"
                        class="px-7 py-2.5 bg-void hover:bg-black text-white font-mono font-bold text-xs rounded-xl transition shadow-xs uppercase flex items-center justify-center gap-2">
                    <i class="bi bi-filter text-signal"></i> FILTER CARI
                </button>
            </div>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface border-b border-black/10 text-void font-mono text-[10px] uppercase tracking-wider">
                        <th class="py-4 pl-6 w-16">NO</th>
                        <th class="py-4">TAHUN PELAJARAN</th>
                        <th class="py-4">SEMESTER</th>
                        <th class="py-4 text-center">STATUS KEAKTIFAN</th>
                        <th class="py-4 pr-6 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 text-xs font-medium text-gray-700">
                    @forelse($tahunAjaran as $ta)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-6 font-mono text-gray-400 font-bold">
                            {{ $tahunAjaran->firstItem() + $loop->index }}
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-void text-white flex items-center justify-center font-bold text-sm shrink-0 shadow-xs">
                                    <i class="bi bi-calendar3 text-signal"></i>
                                </div>
                                <span class="text-sm font-bold text-void font-mono">{{ $ta->tahun_mulai }} / {{ $ta->tahun_selesai }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-gray-100 text-void border border-black/5 text-xs font-mono font-bold uppercase">
                                <i class="bi {{ strtolower($ta->semester) == 'ganjil' ? 'bi-1-circle-fill text-cobalt' : 'bi-2-circle-fill text-signal' }}"></i>
                                SEMESTER {{ strtoupper($ta->semester) }}
                            </span>
                        </td>
                        <td class="py-4 text-center">
                            @if(strtolower($ta->status) == 'aktif')
                                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-void text-signal font-mono font-bold text-[10px] uppercase tracking-wider shadow-xs border border-black">
                                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                                    AKTIF SEKARANG
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded bg-gray-100 text-gray-500 font-mono font-bold text-[10px] uppercase border border-black/5">
                                    <i class="bi bi-clock-history"></i> TIDAK AKTIF
                                </span>
                            @endif
                        </td>
                        <td class="py-4 pr-6 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.tahun-ajaran.edit', $ta->id_tahun_ajaran) }}"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-cobalt text-void hover:text-white flex items-center justify-center transition"
                                   title="Edit Tahun Ajaran">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id_tahun_ajaran) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-signal text-void hover:text-white flex items-center justify-center transition" title="Hapus Tahun Ajaran">
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
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 border border-black/5">
                                    <i class="bi bi-calendar-x text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-base uppercase font-mono">BELUM ADA DATA TAHUN AJARAN</h4>
                                <p class="text-xs text-gray-500 mt-1 max-w-sm">Daftar periode kalender akademik masih kosong. Klik tombol Tambah Periode Baru di atas untuk mulai memasukkan data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tahunAjaran->hasPages())
            {{ $tahunAjaran->links('components.pagination') }}
        @endif
    </div>

</div>

@endsection