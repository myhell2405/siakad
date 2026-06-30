@extends('admin.layout')

@section('content')

<div class="space-y-8 font-sans text-gray-900 pb-16">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-people-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>DIREKTORI PESERTA DIDIK</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? 'MANAJEMEN SISWA') }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL <strong class="text-void font-black">{{ $siswa->total() }}</strong> SISWA TERDAFTAR</span>
                </p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full sm:w-auto">
            <a href="{{ route('admin.siswa.export') }}"
               class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white hover:bg-gray-50 text-void border border-black/10 font-mono font-bold text-xs transition shadow-2xs">
                <i class="bi bi-file-earmark-excel text-emerald-600 text-sm"></i>
                <span>EKSPORT EXCEL</span>
            </a>
            <a href="{{ route('admin.siswa.create') }}"
               class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase">
                <span>TAMBAH SISWA</span>
                <i class="bi bi-plus-lg text-signal font-bold text-sm"></i>
            </a>
        </div>
    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 p-4 rounded-2xl flex items-center justify-between text-xs font-mono font-bold">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center">
                    <i class="bi bi-check-lg text-sm font-black"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-700 flex items-center justify-center transition">
                ✕
            </button>
        </div>
    @endif

    {{-- FILTER & SEARCH BAR --}}
    <div class="bg-white rounded-3xl p-6 border border-black/10 shadow-xs">
        <form action="{{ route('admin.siswa.index') }}" method="GET" id="searchForm" class="flex flex-col md:flex-row items-center justify-between gap-4 font-mono text-xs">
            <div class="relative w-full md:w-96">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                    <i class="bi bi-search"></i>
                </div>
                <input
                    id="searchInput"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Cari nama siswa, NIS, atau NISN..."
                    class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl pl-11 pr-24 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                @if(request('search'))
                    <a href="{{ route('admin.siswa.index') }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-[10px] bg-gray-200 hover:bg-signal hover:text-white transition px-2.5 py-1 rounded-md font-bold uppercase">
                        Reset
                    </a>
                @endif
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full md:w-auto justify-end">
                <select name="kelas" onchange="this.form.submit()"
                        class="bg-gray-50 border border-black/10 rounded-xl px-4 py-3 text-xs font-bold text-void focus:outline-none focus:border-void transition">
                    <option value="">SEMUA KELAS</option>
                    @foreach($listKelas ?? [] as $k)
                        <option value="{{ $k->id_kelas ?? $k->id }}" {{ request('kelas') == ($k->id_kelas ?? $k->id) ? 'selected' : '' }}>
                            KELAS {{ strtoupper($k->nama_kelas) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    {{-- TABLE DATA SISWA --}}
    <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono">
                <thead>
                    <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        <th class="py-3.5 pl-3 text-center w-14">NO</th>
                        <th class="py-3.5">IDENTITAS SISWA</th>
                        <th class="py-3.5">NIS / NISN</th>
                        <th class="py-3.5">ROMBEL</th>
                        <th class="py-3.5">TEMPAT, TGL LAHIR</th>
                        <th class="py-3.5 pr-3 text-right w-36">AKSI</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                @forelse($siswa as $s)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-3 text-center text-gray-400">{{ ($siswa->currentPage() - 1) * $siswa->perPage() + $loop->iteration }}</td>
                        <td class="py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-void text-white flex items-center justify-center font-black text-xs shrink-0">
                                    {{ substr(preg_replace('/[^A-Za-z]/', '', $s->nama_siswa ?? $s->nama_lengkap ?? 'S'), 0, 2) }}
                                </div>
                                <div>
                                    <span class="block font-black text-void group-hover:text-cobalt transition-colors text-sm font-sans uppercase">
                                        {{ $s->nama_siswa ?? $s->nama_lengkap }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-gray-400 font-mono mt-0.5 uppercase">
                                        <i class="bi {{ $s->jenis_kelamin == 'P' ? 'bi-gender-female text-signal' : 'bi-gender-male text-cobalt' }}"></i>
                                        {{ $s->jenis_kelamin == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 font-mono">
                            <div class="text-void font-bold">{{ $s->nis ?: '-' }}</div>
                            <div class="text-[10px] text-gray-400 mt-0.5">NISN: <span class="text-gray-600">{{ $s->nisn ?: '-' }}</span></div>
                        </td>
                        <td class="py-4">
                            @php
                                $latestKelas = $s->siswaKelas->last()?->kelasTahunAjaran?->kelas?->nama_kelas;
                            @endphp
                            @if($latestKelas)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-void font-bold text-[11px] uppercase">
                                    <i class="bi bi-door-open-fill text-cobalt"></i>
                                    {{ $latestKelas }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-50 text-gray-400 font-bold text-[10px] uppercase border border-gray-200">
                                    BELUM DIATUR
                                </span>
                            @endif
                        </td>
                        <td class="py-4 font-mono text-gray-600">
                            {{ $s->tempat_lahir ?: '-' }}, <br>
                            <span class="text-gray-400 text-[11px]">{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '-' }}</span>
                        </td>
                        <td class="py-4 pr-3 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <button
                                    title="Detail Profil"
                                    onclick='openDetail({
                                                nisn: "{{ $s->nisn ?: '-' }}",
                                                nama_lengkap: "{{ addslashes($s->nama_siswa ?? $s->nama_lengkap ?? '') }}",
                                                rombel: "{{ addslashes($s->siswaKelas->last()?->kelasTahunAjaran?->kelas?->nama_kelas ?? 'BELUM DIATUR') }}",
                                                tempat_lahir: "{{ addslashes($s->tempat_lahir) }}",
                                                tanggal_lahir: "{{ $s->tanggal_lahir ? \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') : '-' }}",
                                                jenis_kelamin: "{{ $s->jenis_kelamin == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI' }}",
                                                agama: "{{ strtoupper($s->agama ?: '-') }}",
                                                status_keluarga: "{{ strtoupper(addslashes($s->status_keluarga ?: '-')) }}",
                                                anak_ke: "{{ $s->anak_ke ?: '-' }}",
                                                alamat: "{{ strtoupper(addslashes($s->alamat_siswa ?? $s->alamat ?? '-')) }}",
                                                telp_siswa: "{{ $s->telp_siswa ?: '-' }}",
                                                sekolah_asal: "{{ strtoupper(addslashes($s->sekolah_asal ?: '-')) }}",
                                                tanggal_diterima: "{{ $s->tanggal_diterima ? \Carbon\Carbon::parse($s->tanggal_diterima)->format('d/m/Y') : '-' }}",
                                                nama_wali: "{{ addslashes($s->waliSiswa->first()?->nama_wali ?? '-') }}",
                                                hubungan_wali: "{{ strtoupper(addslashes($s->waliSiswa->first()?->hubungan ?? '-')) }}",
                                                no_telepon_wali: "{{ $s->waliSiswa->first()?->telepon ?? '-' }}",
                                                pekerjaan_wali: "{{ strtoupper(addslashes($s->waliSiswa->first()?->pekerjaan ?? '-')) }}"
                                            })'
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void text-void hover:text-white flex items-center justify-center transition">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>
                                <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                   title="Edit Data"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white text-void flex items-center justify-center transition">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>
                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Data" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-signal hover:text-white text-void flex items-center justify-center transition">
                                        <i class="bi bi-trash3-fill text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mb-3">
                                    <i class="bi bi-people text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-sm uppercase">BELUM ADA DATA SISWA</h4>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($siswa->hasPages())
            {{ $siswa->links('components.pagination') }}
        @endif
    </div>
</div>

{{-- DRAWER DETAIL --}}
<div id="detailModal" class="fixed inset-0 z-50 overflow-hidden hidden font-mono">
    <div id="drawerBackdrop" onclick="closeDetail()" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>
    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div id="drawerPanel" class="w-screen max-w-2xl bg-white border-l border-black/10 flex flex-col translate-x-full transition-transform duration-300 relative z-10">
            <div class="p-8 pb-6 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-void text-white flex items-center justify-center text-2xl font-black shrink-0 shadow-xs">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-void uppercase font-sans" id="modalNama">DETAIL SISWA</h2>
                        <p class="text-xs font-bold text-cobalt mt-0.5 font-mono uppercase" id="modalSub">NISN: - • ROMBEL: -</p>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-9 h-9 rounded-xl bg-white hover:bg-gray-200 text-void flex items-center justify-center transition font-bold border border-black/10">
                    ✕
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 space-y-8 text-xs">
                {{-- INFORMASI AKADEMIK --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-mortarboard-fill text-cobalt"></i> INFORMASI AKADEMIK
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">NISN</span>
                            <span class="font-bold text-void mt-1 block font-mono text-sm" id="mNisn">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">ROMBEL SAAT INI</span>
                            <span class="font-bold text-cobalt mt-1 block font-mono text-sm" id="mRombel">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">SEKOLAH ASAL</span>
                            <span class="font-bold text-void mt-1 block" id="mSekolahAsal">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">TANGGAL DITERIMA</span>
                            <span class="font-bold text-void mt-1 block font-mono" id="mTglDiterima">-</span>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI PRIBADI --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-person-lines-fill text-cobalt"></i> INFORMASI PRIBADI
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">JENIS KELAMIN</span>
                            <span class="font-bold text-void mt-1 block" id="mJk">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">AGAMA</span>
                            <span class="font-bold text-void mt-1 block" id="mAgama">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 sm:col-span-2">
                            <span class="text-[10px] text-gray-400 block uppercase">TEMPAT, TGL LAHIR</span>
                            <span class="font-bold text-void mt-1 block" id="mTtl">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">STATUS DALAM KELUARGA</span>
                            <span class="font-bold text-void mt-1 block" id="mStatusKeluarga">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">ANAK KE-</span>
                            <span class="font-bold text-void mt-1 block" id="mAnakKe">-</span>
                        </div>
                    </div>
                </div>

                {{-- KONTAK & DOMISILI --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-cobalt"></i> KONTAK & DOMISILI
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 sm:col-span-2">
                            <span class="text-[10px] text-gray-400 block uppercase mb-1">NO. TELEPON / HP SISWA</span>
                            <span class="font-bold text-void block font-mono" id="mTelpSiswa">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 sm:col-span-2">
                            <span class="text-[10px] text-gray-400 block uppercase mb-1">ALAMAT LENGKAP DOMISILI</span>
                            <span class="font-bold text-void block leading-relaxed" id="mAlamat">-</span>
                        </div>
                    </div>
                </div>

                {{-- INFORMASI WALI SISWA --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-people-fill text-cobalt"></i> INFORMASI WALI SISWA
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">NAMA WALI</span>
                            <span class="font-bold text-void mt-1 block" id="mNamaWali">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">HUBUNGAN</span>
                            <span class="font-bold text-void mt-1 block" id="mHubunganWali">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">NO. TELEPON WALI</span>
                            <span class="font-bold text-void mt-1 block font-mono" id="mTelpWali">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">PEKERJAAN WALI</span>
                            <span class="font-bold text-void mt-1 block" id="mPekerjaanWali">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button onclick="closeDetail()" class="px-7 py-2.5 bg-void text-white font-bold text-xs rounded-xl hover:bg-black transition uppercase shadow-xs">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<script>
function openDetail(s){
    document.getElementById("modalNama").innerText = s.nama_lengkap || 'SISWA';
    document.getElementById("modalSub").innerText = "NISN: " + (s.nisn || '-') + " • ROMBEL: " + (s.rombel || '-');
    
    document.getElementById("mNisn").innerText = s.nisn || '-';
    document.getElementById("mRombel").innerText = s.rombel || '-';
    document.getElementById("mSekolahAsal").innerText = s.sekolah_asal || '-';
    document.getElementById("mTglDiterima").innerText = s.tanggal_diterima || '-';

    document.getElementById("mJk").innerText = s.jenis_kelamin || '-';
    document.getElementById("mAgama").innerText = s.agama || '-';
    document.getElementById("mTtl").innerText = (s.tempat_lahir || '-') + ", " + (s.tanggal_lahir || '-');
    document.getElementById("mStatusKeluarga").innerText = s.status_keluarga || '-';
    document.getElementById("mAnakKe").innerText = (s.anak_ke && s.anak_ke !== '-') ? "ANAK KE-" + s.anak_ke : '-';

    document.getElementById("mTelpSiswa").innerText = s.telp_siswa || '-';
    document.getElementById("mAlamat").innerText = s.alamat || '-';

    document.getElementById("mNamaWali").innerText = s.nama_wali || '-';
    document.getElementById("mHubunganWali").innerText = s.hubungan_wali || '-';
    document.getElementById("mTelpWali").innerText = s.no_telepon_wali || '-';
    document.getElementById("mPekerjaanWali").innerText = s.pekerjaan_wali || '-';

    const modal = document.getElementById("detailModal");
    const backdrop = document.getElementById("drawerBackdrop");
    const panel = document.getElementById("drawerPanel");
    modal.classList.remove("hidden");
    void modal.offsetWidth;
    backdrop.classList.remove("opacity-0");
    backdrop.classList.add("opacity-100");
    panel.classList.remove("translate-x-full");
    panel.classList.add("translate-x-0");
}
function closeDetail(){
    const backdrop = document.getElementById("drawerBackdrop");
    const panel = document.getElementById("drawerPanel");
    backdrop.classList.remove("opacity-100");
    backdrop.classList.add("opacity-0");
    panel.classList.remove("translate-x-0");
    panel.classList.add("translate-x-full");
    setTimeout(() => { document.getElementById("detailModal").classList.add("hidden"); }, 300);
}
</script>

@endsection