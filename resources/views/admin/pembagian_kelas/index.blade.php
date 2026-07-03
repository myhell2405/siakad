@extends('admin.layout')

@section('content')

<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-grid-1x2-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>MANAJEMEN ROMBONGAN BELAJAR</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title) }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL MASTER KELAS: <strong class="text-void font-black">{{ $masterKelasCount }}</strong> ROMBEL</span>
                </p>
            </div>
        </div>

        @if($taAktif)
        <form action="{{ route('admin.pembagian-kelas.generate') }}" method="POST" class="relative z-10 w-full sm:w-auto" onsubmit="return confirm('Apakah Anda yakin ingin membuatkan kelas otomatis untuk semua master kelas yang belum terdaftar di TA Aktif ini?');">
            @csrf
            <button type="submit"
                    class="px-6 py-3.5 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs shadow-md transition w-full inline-flex items-center justify-center gap-3 uppercase tracking-wider">
                <i class="bi bi-magic text-signal"></i>
                <span>+ GENERATE ROMBEL TA AKTIF</span>
            </button>
        </form>
        @endif
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

    @if(session('info'))
        <div class="bg-gray-100 border border-black/10 text-void p-5 rounded-3xl shadow-xs flex items-center gap-3.5 font-mono text-xs font-bold">
            <div class="w-8 h-8 rounded-xl bg-cobalt text-white flex items-center justify-center shrink-0">
                <i class="bi bi-info-circle-fill text-base"></i>
            </div>
            <span class="uppercase">{{ session('info') }}</span>
        </div>
    @endif

    {{-- STATUS TAHUN AJARAN BANNER --}}
    @if(!$taAktif)
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-black/10 shadow-xs text-center space-y-5 font-mono">
            <div class="w-16 h-16 rounded-2xl bg-signal text-white flex items-center justify-center text-3xl mx-auto shadow-md">
                <i class="bi bi-calendar-x-fill"></i>
            </div>
            <div class="max-w-md mx-auto space-y-2">
                <h3 class="text-xl font-black text-void uppercase font-sans">BELUM ADA TAHUN AJARAN AKTIF</h3>
                <p class="text-xs font-bold text-gray-500 leading-relaxed uppercase">
                    Sistem pembagian kelas membutuhkan Tahun Ajaran yang berstatus aktif. Silakan aktifkan salah satu periode terlebih dahulu melalui menu kalender akademik.
                </p>
            </div>
            <div class="pt-2">
                <a href="{{ route('admin.tahun-ajaran.index') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-void hover:bg-black text-white font-bold text-xs transition uppercase">
                    <i class="bi bi-calendar-check text-signal font-black"></i> KE MENU TAHUN AJARAN
                </a>
            </div>
        </div>
    @else
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 font-mono">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-void text-white flex items-center justify-center text-xl font-black shrink-0">
                    <i class="bi bi-calendar2-range text-signal"></i>
                </div>
                <div>
                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">PERIODE AKADEMIK AKTIF</span>
                    <h2 class="text-lg font-black text-void flex items-center gap-2 pt-0.5 font-sans uppercase">
                        <span>{{ $taAktif->tahun_mulai }} / {{ $taAktif->tahun_selesai }}</span>
                        <span class="px-2.5 py-0.5 rounded-lg text-[10px] font-bold font-mono uppercase bg-gray-100 text-void border border-black/10">
                            SEMESTER {{ $taAktif->semester }}
                        </span>
                    </h2>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto justify-end text-xs">
                <div class="px-4 py-2.5 rounded-xl bg-surface text-void border border-black/10 flex items-center gap-2 font-bold uppercase">
                    <span class="w-2 h-2 rounded-full bg-signal inline-block"></span>
                    <span>STATUS: AKTIF</span>
                </div>
                <div class="px-4 py-2.5 rounded-xl bg-gray-100 text-void font-bold flex items-center gap-2 uppercase">
                    <i class="bi bi-layers-fill text-cobalt"></i>
                    <span>{{ $kelasTaList->count() }} ROMBEL TERBUAT</span>
                </div>
            </div>
        </div>

        {{-- TABLE SECTION --}}
        <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs overflow-hidden space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 px-2">
                <div>
                    <h3 class="text-base font-black text-void uppercase font-sans tracking-tight">DAFTAR PENUGASAN WALI KELAS & ROMBEL</h3>
                    <p class="text-xs text-gray-400 font-mono uppercase">Ubah wali kelas langsung pada dropdown di bawah atau klik tombol Atur Kelas</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left font-mono">
                    <thead>
                        <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                            <th class="py-3.5 pl-3 text-center w-16">NO</th>
                            <th class="py-3.5">ROMBONGAN BELAJAR</th>
                            <th class="py-3.5">PENUGASAN WALI KELAS</th>
                            <th class="py-3.5 text-center">JUMLAH SISWA</th>
                            <th class="py-3.5 pr-3 text-right">AKSI MANAJEMEN</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                        @forelse($kelasTaList as $idx => $item)
                        <tr class="hover:bg-gray-50/80 transition-colors group">
                            <td class="py-4 pl-3 text-center text-gray-400">
                                {{ $idx + 1 }}
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-black text-sm shrink-0">
                                        {{ $item->kelas->tingkat_kelas ?? '-' }}
                                    </div>
                                    <div>
                                        <span class="text-base font-black text-void font-sans block uppercase">{{ $item->kelas->nama_kelas ?? '-' }}</span>
                                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">TINGKAT KELAS {{ $item->kelas->tingkat_kelas ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                {{-- INLINE WALI KELAS FORM --}}
                                <form action="{{ route('admin.pembagian-kelas.update-wali-kelas', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="id_wali_kelas" onchange="this.form.submit()"
                                            class="bg-gray-50 hover:bg-gray-100/80 focus:bg-white border border-black/10 rounded-xl px-3.5 py-2 font-bold text-void focus:outline-none focus:border-void transition max-w-xs uppercase">
                                        @foreach($guruList as $g)
                                        <option value="{{ $g->id }}" {{ $item->id_wali_kelas == $g->id ? 'selected' : '' }}>
                                            {{ strtoupper($g->nama_lengkap) }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <noscript>
                                        <button type="submit" class="px-3 py-2 bg-void text-white rounded-xl text-xs font-bold uppercase">SIMPAN</button>
                                    </noscript>
                                </form>
                            </td>
                            <td class="py-4 text-center">
                                @php $countSiswa = $item->siswaKelas->count(); @endphp
                                @if($countSiswa > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gray-100 border border-black/5 text-void font-bold text-[10px] uppercase">
                                        <i class="bi bi-people-fill text-cobalt"></i> {{ $countSiswa }} SISWA
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-red-50 text-red-700 border border-red-200 font-bold text-[10px] uppercase">
                                        <i class="bi bi-exclamation-circle text-signal"></i> KOSONG
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 pr-3 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    {{-- ATUR KELAS BUTTON --}}
                                    <a href="{{ route('admin.kelas-ta.detail', $item->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-void hover:bg-black text-white font-bold text-xs shadow-sm transition uppercase"
                                       title="Atur Kelas Rombel">
                                        <i class="bi bi-person-lines-fill text-signal"></i> ATUR KELAS
                                    </a>

                                    {{-- DELETE BUTTON --}}
                                    <form action="{{ route('admin.kelas-ta.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus pembagian rombel {{ $item->kelas->nama_kelas ?? '' }} dari TA Aktif ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 hover:bg-signal hover:text-white text-void flex items-center justify-center transition" title="Hapus Rombel">
                                            <i class="bi bi-trash3-fill text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-16 text-center font-mono">
                                <div class="flex flex-col items-center justify-center gap-4 max-w-sm mx-auto">
                                    <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-gray-400 text-2xl border border-black/5">
                                        <i class="bi bi-grid-1x2"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <h4 class="text-sm font-black text-void uppercase font-sans">ROMBONGAN BELAJAR BELUM TERBUAT</h4>
                                        <p class="text-xs text-gray-400 uppercase">Silakan klik tombol <strong class="text-void font-bold">+ GENERATE ROMBEL TA AKTIF</strong> di atas untuk menyalin otomatis seluruh data master kelas.</p>
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
