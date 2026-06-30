@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-amber-500/10 via-orange-500/10 to-yellow-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 text-white flex items-center justify-center shadow-lg shadow-amber-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-calendar-range-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-amber-50/80 text-amber-700 ring-1 ring-amber-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-600"></span>
                    </span>
                    <span>Manajemen Kalender</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? 'Data Tahun Ajaran' }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-amber-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total <strong class="text-slate-700">{{ $tahunAjaran->total() }}</strong> Periode Terdaftar</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.tahun-ajaran.create') }}"
           class="group relative z-10 inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold text-xs shadow-lg shadow-amber-500/25 hover:shadow-xl hover:shadow-amber-500/30 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start">
            <span class="tracking-wide">Tambah Periode Baru</span>
            <div class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-sm font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         SEARCH & FILTER BAR (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-[2rem] p-4 sm:p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.tahun-ajaran.index') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="relative w-full sm:w-96">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari tahun (misal: 2024) atau semester..."
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 hover:bg-slate-100/70 focus:bg-white border border-slate-200/80 rounded-2xl text-xs font-bold text-slate-800 placeholder:text-slate-400 focus:outline-none focus:ring-4 focus:ring-amber-500/15 focus:border-amber-600 transition-all shadow-inner">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="bi bi-search text-sm"></i>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                @if(request('search'))
                    <a href="{{ route('admin.tahun-ajaran.index') }}"
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
                        <th class="pb-4">Tahun Pelajaran</th>
                        <th class="pb-4">Semester</th>
                        <th class="pb-4 text-center">Status Keaktifan</th>
                        <th class="pb-4 pr-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                    @forelse($tahunAjaran as $ta)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="py-4 pl-4 text-slate-400 font-semibold">
                            {{ $tahunAjaran->firstItem() + $loop->index }}
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-black text-sm shrink-0 group-hover:scale-110 transition-transform">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                                <span class="text-sm font-black text-slate-900">{{ $ta->tahun_mulai }} / {{ $ta->tahun_selesai }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black capitalize {{ $ta->semester == 'ganjil' ? 'bg-sky-50 text-sky-700 ring-1 ring-sky-200' : 'bg-purple-50 text-purple-700 ring-1 ring-purple-200' }}">
                                <i class="bi {{ $ta->semester == 'ganjil' ? 'bi-1-circle-fill' : 'bi-2-circle-fill' }}"></i>
                                Semester {{ $ta->semester }}
                            </span>
                        </td>
                        <td class="py-4 text-center">
                            @if($ta->status == 'aktif')
                                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/30 font-black text-[11px] shadow-2xs">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                                    </span>
                                    Aktif Sekarang
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-500 font-bold text-[11px]">
                                    <i class="bi bi-clock-history"></i> Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="py-4 pr-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.tahun-ajaran.edit', $ta->id_tahun_ajaran) }}"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-amber-500/20 active:scale-95"
                                   title="Edit Tahun Ajaran">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id_tahun_ajaran) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus tahun ajaran ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95" title="Hapus Tahun Ajaran">
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
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <span>Data tahun ajaran belum tersedia atau tidak ditemukan.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-8 pt-6 border-t border-slate-100">
            <x-pagination :paginator="$tahunAjaran" />
        </div>
    </div>

</div>

@endsection