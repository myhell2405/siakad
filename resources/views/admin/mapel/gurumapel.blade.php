@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-people-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>ALOKASI TENAGA PENDIDIK</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    DAFTAR GURU PENGAMPU
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>MATA PELAJARAN: <strong class="text-void font-black">{{ strtoupper($mapel->nama_mapel) }}</strong></span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.mapel.index') }}"
           class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white hover:bg-gray-50 text-void border border-black/10 font-mono font-bold text-xs transition shadow-2xs uppercase">
            <i class="bi bi-arrow-left text-sm"></i>
            <span>KEMBALI KE KURIKULUM</span>
        </a>
    </div>

    {{-- FLASH MESSAGES --}}
    @if(session('success'))
        <div class="bg-white border border-black/10 text-void p-5 rounded-3xl shadow-xs flex items-center gap-3.5 font-mono text-xs font-bold">
            <div class="w-8 h-8 rounded-xl bg-void text-signal flex items-center justify-center shrink-0">
                <i class="bi bi-check-lg text-base"></i>
            </div>
            <span class="uppercase">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-900 p-5 rounded-3xl shadow-xs flex items-center gap-3.5 font-mono text-xs font-bold">
            <div class="w-8 h-8 rounded-xl bg-signal text-white flex items-center justify-center shrink-0">
                <i class="bi bi-exclamation-triangle-fill text-base"></i>
            </div>
            <span class="uppercase">{{ session('error') }}</span>
        </div>
    @endif

    {{-- FORM TAMBAH GURU PENGAMPU --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs space-y-6">
        <div class="flex items-center gap-3.5 pb-5 border-b border-gray-100">
            <div class="w-11 h-11 rounded-xl bg-void text-white flex items-center justify-center font-bold text-lg shrink-0">
                <i class="bi bi-person-plus-fill text-signal"></i>
            </div>
            <div>
                <h3 class="text-base font-black text-void uppercase tracking-tight font-sans">TAMBAHKAN GURU PENGAMPU</h3>
                <p class="text-xs text-gray-400 font-mono">Pilih guru yang bertugas mengajar mata pelajaran ini</p>
            </div>
        </div>

        <form action="{{ route('admin.mapel.guru.store', $mapel->id_mapel) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-4 font-mono text-xs">
            @csrf

            <div class="relative w-full flex-1">
                <select name="id_guru" required
                        class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-5 py-4 font-bold text-void focus:bg-white focus:outline-none focus:border-void transition-all appearance-none">
                    <option value="">-- PILIH GURU PENGAMPU DARI DAFTAR --</option>
                    @foreach($availableGuru as $g)
                        <option value="{{ $g->id }}">{{ strtoupper($g->nama_lengkap) }} (NIP: {{ $g->nip }})</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400">
                    <i class="bi bi-chevron-down text-xs"></i>
                </div>
            </div>

            <button type="submit"
                    class="px-8 py-4 rounded-xl bg-void hover:bg-black text-white font-bold shadow-md transition w-full sm:w-auto shrink-0 inline-flex items-center justify-center gap-2 uppercase">
                <span>TAMBAHKAN GURU</span>
                <i class="bi bi-plus-lg text-signal"></i>
            </button>
        </form>
    </div>

    {{-- TABEL DAFTAR GURU PENGAMPU --}}
    <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs overflow-hidden space-y-6">
        <div class="flex items-center justify-between px-2 font-mono">
            <h3 class="text-sm font-black text-void uppercase tracking-wider font-sans">DAFTAR GURU TERDAFTAR</h3>
            <span class="px-3 py-1 rounded-lg bg-gray-100 text-void font-bold text-xs">{{ $guruMapel->count() }} GURU</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono">
                <thead>
                    <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        <th class="py-3.5 pl-3 text-center w-16">NO</th>
                        <th class="py-3.5">NAMA GURU</th>
                        <th class="py-3.5">NIP</th>
                        <th class="py-3.5">JABATAN</th>
                        <th class="py-3.5 pr-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                    @forelse($guruMapel as $guru)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-3 text-center text-gray-400">
                            {{ $loop->iteration }}
                        </td>
                        <td class="py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-void text-white flex items-center justify-center font-black text-xs shrink-0">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <span class="font-black text-void group-hover:text-cobalt transition-colors text-base font-sans uppercase">{{ $guru->nama_lengkap }}</span>
                            </div>
                        </td>
                        <td class="py-4 text-gray-500">
                            {{ $guru->nip }}
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg bg-gray-100 border border-black/5 text-[10px] font-bold text-void uppercase">
                                {{ $guru->jabatan_guru ?? '-' }}
                            </span>
                        </td>
                        <td class="py-4 pr-3 text-right">
                            <form action="{{ route('admin.mapel.guru.destroy', [$mapel->id_mapel, $guru->id]) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus guru ini dari pengampu mata pelajaran {{ $mapel->nama_mapel }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 hover:bg-signal hover:text-white text-void font-bold text-xs transition">
                                    <i class="bi bi-trash3-fill text-[11px]"></i> HAPUS
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mb-3">
                                    <i class="bi bi-people text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-sm uppercase">BELUM ADA GURU PENGAMPU DITUGASKAN</h4>
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