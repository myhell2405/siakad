@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-slate-800">

    {{-- ================================================
         HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-cyan-500/10 via-teal-500/10 to-emerald-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-600 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-cyan-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-grid-1x2-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-cyan-50/80 text-cyan-700 ring-1 ring-cyan-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-600"></span>
                    </span>
                    <span>Manajemen Rombongan Belajar</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-cyan-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total Master Kelas: <strong class="text-slate-700">{{ $masterKelasCount }}</strong> Rombel</span>
                </p>
            </div>
        </div>

        @if($taAktif)
        <form action="{{ route('admin.pembagian-kelas.generate') }}" method="POST" class="relative z-10 w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin membuatkan kelas otomatis untuk semua master kelas yang belum terdaftar di TA Aktif ini?');">
            @csrf
            <button type="submit"
                    class="group inline-flex items-center justify-center gap-3.5 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-bold text-xs shadow-lg shadow-cyan-500/25 hover:shadow-xl hover:shadow-cyan-500/30 transition-all duration-300 active:scale-[0.98] w-full">
                <div class="w-7 h-7 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform group-hover:rotate-90 duration-300">
                    <i class="bi bi-magic text-xs font-black"></i>
                </div>
                <span class="tracking-wide">+ Generate Rombel TA Aktif</span>
            </button>
        </form>
        @endif
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

    @if(session('info'))
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 ring-1 ring-blue-500/30 text-blue-900 p-5 rounded-3xl shadow-sm flex items-center gap-3.5 animate-fade-in font-bold text-xs">
            <div class="w-8 h-8 rounded-xl bg-blue-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-500/20">
                <i class="bi bi-info-circle-fill text-base font-black"></i>
            </div>
            <span>{{ session('info') }}</span>
        </div>
    @endif

    {{-- ================================================
         STATUS TAHUN AJARAN BANNER
         ================================================ --}}
    @if(!$taAktif)
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-[2.5rem] p-8 sm:p-12 ring-1 ring-amber-500/30 shadow-md text-center space-y-5">
            <div class="w-16 h-16 rounded-3xl bg-amber-500 text-white flex items-center justify-center text-3xl mx-auto shadow-lg shadow-amber-500/30 animate-bounce">
                <i class="bi bi-calendar-x-fill"></i>
            </div>
            <div class="max-w-md mx-auto space-y-2">
                <h3 class="text-xl font-black text-amber-900">Belum Ada Tahun Ajaran Aktif</h3>
                <p class="text-xs font-semibold text-amber-700 leading-relaxed">
                    Sistem pembagian kelas membutuhkan Tahun Ajaran yang berstatus aktif. Silakan aktifkan salah satu periode terlebih dahulu melalui menu kalender akademik.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('admin.tahun-ajaran.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow-md shadow-amber-600/25 transition active:scale-95">
                    <i class="bi bi-calendar-check font-black"></i> Ke Menu Tahun Ajaran
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-[2rem] p-6 sm:p-8 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)] ring-1 ring-slate-900/[0.03] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl font-black shrink-0">
                    <i class="bi bi-calendar2-range"></i>
                </div>
                <div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-400">Periode Akademik Aktif</span>
                    <h2 class="text-lg font-black text-slate-900 flex items-center gap-2 pt-0.5">
                        <span>{{ $taAktif->tahun_mulai }} / {{ $taAktif->tahun_selesai }}</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase bg-cyan-100 text-cyan-800 ring-1 ring-cyan-500/20">
                            Semester {{ $taAktif->semester }}
                        </span>
                    </h2>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end">
                <div class="px-4 py-2.5 rounded-2xl bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/30 flex items-center gap-2 font-black text-xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                    </span>
                    <span>Status: Aktif</span>
                </div>
                <div class="px-4 py-2.5 rounded-2xl bg-slate-100 text-slate-700 font-black text-xs flex items-center gap-2">
                    <i class="bi bi-layers-fill text-slate-500"></i>
                    <span>{{ $kelasTaList->count() }} Rombel Terbuat</span>
                </div>
            </div>
        </div>

        {{-- ================================================
             TABLE SECTION
             ================================================ --}}
        <div class="bg-white rounded-[2.5rem] p-6 sm:p-8 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03] overflow-hidden space-y-6">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-2">
                <div>
                    <h3 class="text-base font-black text-slate-900">Daftar Penugasan Wali Kelas & Rombel</h3>
                    <p class="text-xs text-slate-400 font-semibold">Ubah wali kelas langsung pada dropdown di bawah atau klik tombol Atur Siswa</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="pb-4 pl-4 w-16">No</th>
                            <th class="pb-4">Rombongan Belajar</th>
                            <th class="pb-4">Penugasan Wali Kelas</th>
                            <th class="pb-4 text-center">Jumlah Siswa</th>
                            <th class="pb-4 pr-4 text-right">Aksi Manajemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-bold text-slate-700">
                        @forelse($kelasTaList as $idx => $item)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="py-4 pl-4 text-slate-400 font-semibold">
                                {{ $idx + 1 }}
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan-50 to-teal-50 text-cyan-600 ring-1 ring-cyan-500/20 flex items-center justify-center font-black text-sm shrink-0 group-hover:scale-110 transition-transform">
                                        {{ $item->kelas->tingkat_kelas ?? '-' }}
                                    </div>
                                    <div>
                                        <span class="text-sm font-black text-slate-900 block">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                        <span class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Tingkat Kelas {{ $item->kelas->tingkat_kelas ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                {{-- INLINE WALI KELAS FORM --}}
                                <form action="{{ route('admin.pembagian-kelas.update-wali-kelas', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="id_wali_kelas" onchange="this.form.submit()"
                                            class="bg-slate-50 hover:bg-slate-100/80 focus:bg-white border border-slate-200/80 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition shadow-2xs max-w-xs">
                                        @foreach($guruList as $g)
                                        <option value="{{ $g->id }}" {{ $item->id_wali_kelas == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama_lengkap }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <noscript>
                                        <button type="submit" class="px-3 py-2 bg-cyan-600 text-white rounded-xl text-xs font-bold">Simpan</button>
                                    </noscript>
                                </form>
                            </td>
                            <td class="py-4 text-center">
                                @php $countSiswa = $item->siswaKelas->count(); @endphp
                                @if($countSiswa > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/30 font-black text-[11px]">
                                        <i class="bi bi-people-fill text-[10px]"></i> {{ $countSiswa }} Siswa
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full bg-rose-50 text-rose-600 ring-1 ring-rose-200 font-bold text-[11px]">
                                        <i class="bi bi-exclamation-circle"></i> Kosong
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 pr-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    {{-- ATUR SISWA BUTTON --}}
                                    <a href="{{ route('admin.kelas-ta.detail', $item->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gradient-to-r from-cyan-600 to-teal-600 hover:from-cyan-700 hover:to-teal-700 text-white font-black text-xs shadow-md shadow-cyan-500/20 hover:shadow-lg transition-all active:scale-95"
                                       title="Atur Siswa Rombel">
                                        <i class="bi bi-person-lines-fill"></i> Atur Siswa
                                    </a>

                                    {{-- DELETE BUTTON --}}
                                    <form action="{{ route('admin.kelas-ta.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pembagian rombel {{ $item->kelas->nama_kelas ?? '' }} dari TA Aktif ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95" title="Hapus Rombel">
                                            <i class="bi bi-trash3-fill text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center text-slate-400 font-medium">
                                <div class="flex flex-col items-center justify-center gap-4 max-w-sm mx-auto">
                                    <div class="w-20 h-20 rounded-full bg-cyan-50 flex items-center justify-center text-cyan-500 text-3xl shadow-inner animate-pulse">
                                        <i class="bi bi-grid-1x2"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-sm font-black text-slate-800">Rombongan Belajar Belum Terbuat</h4>
                                        <p class="text-xs text-slate-400">Silakan klik tombol <strong class="text-cyan-600">+ Generate Rombel TA Aktif</strong> di atas untuk menyalin otomatis seluruh data master kelas.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection
