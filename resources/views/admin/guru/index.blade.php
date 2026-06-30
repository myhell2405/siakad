@extends('admin.layout')

@section('content')

<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Kinetic Glow Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-person-workspace text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50/80 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Master Data Pendidik</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? 'Manajemen Guru & Staf' }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-blue-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total <strong class="text-slate-800 font-black">{{ $guru->total() }}</strong> Pendidik Terdaftar</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.guru.create') }}"
           class="group relative z-10 inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start">
            <span class="tracking-wide">Tambah Pendidik Baru</span>
            <div class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-sm font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         ALERT SUCCESS
         ================================================ --}}
    @if(session('success'))
        <div class="bg-emerald-50 ring-1 ring-emerald-500/20 text-emerald-900 p-4 rounded-2xl shadow-sm flex items-center justify-between text-xs font-bold animate-fade-in">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shadow-emerald-500/20">
                    <i class="bi bi-check-lg text-sm font-black"></i>
                </div>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="w-7 h-7 rounded-lg hover:bg-emerald-100 text-emerald-600 flex items-center justify-center transition">
                <i class="bi bi-x-lg text-xs font-bold"></i>
            </button>
        </div>
    @endif

    {{-- ================================================
         FILTER & SEARCH BAR (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-3xl p-4 sm:p-5 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.guru.index') }}" method="GET" id="searchForm" class="relative">
            <div class="relative flex items-center">
                <div class="absolute left-4 w-9 h-9 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold pointer-events-none">
                    <i class="bi bi-search text-sm"></i>
                </div>
                <input
                    id="searchInput"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Ketik nama pendidik, NIP, atau NUPTK untuk mencari..."
                    class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl pl-16 pr-28 py-3.5 text-xs font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                @if(request('search'))
                    <a href="{{ route('admin.guru.index') }}" class="absolute right-3 bg-slate-200/80 hover:bg-rose-50 hover:text-rose-600 text-slate-700 transition px-4 py-2 rounded-xl text-xs font-extrabold flex items-center gap-1.5 shadow-2xs">
                        <i class="bi bi-x-circle-fill text-xs"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- ================================================
         TABLE DATA GURU (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                        <th class="py-4 pl-8 pr-3 w-16 text-center">No</th>
                        <th class="py-4 px-4">Identitas Pendidik</th>
                        <th class="py-4 px-4">NIP / NUPTK</th>
                        <th class="py-4 px-4">Pendidikan</th>
                        <th class="py-4 px-4">Jabatan & Golongan</th>
                        <th class="py-4 px-4 text-center">Status</th>
                        <th class="py-4 pl-3 pr-8 text-center w-36">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100/80 text-xs font-bold text-slate-700">
                @forelse($guru as $g)
                    <tr class="hover:bg-blue-50/40 transition-colors duration-200 group">
                        
                        {{-- NO --}}
                        <td class="py-4 pl-8 pr-3 text-center text-slate-400 font-black">
                            {{ ($guru->currentPage() - 1) * $guru->perPage() + $loop->iteration }}
                        </td>

                        {{-- IDENTITAS --}}
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-11 h-11 rounded-2xl {{ $g->jenis_kelamin == 'P' ? 'bg-gradient-to-br from-rose-500 to-pink-600 shadow-rose-500/20' : 'bg-gradient-to-br from-blue-600 to-indigo-600 shadow-blue-500/20' }} text-white flex items-center justify-center font-black text-sm shrink-0 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-3 shadow-md">
                                    {{ substr(preg_replace('/[^A-Za-z]/', '', $g->nama_lengkap ?? 'G'), 0, 2) }}
                                </div>
                                <div>
                                    <span class="block font-extrabold text-slate-900 text-sm group-hover:text-blue-600 transition-colors">
                                        {{ $g->nama_lengkap }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-[11px] text-slate-400 font-semibold mt-0.5">
                                        <i class="bi {{ $g->jenis_kelamin == 'P' ? 'bi-gender-female text-rose-500 font-bold' : 'bi-gender-male text-blue-500 font-bold' }}"></i>
                                        {{ $g->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        {{-- NIP / NUPTK --}}
                        <td class="py-4 px-4 font-mono">
                            <div class="text-slate-900 font-black tracking-tight">{{ $g->nip ?: '-' }}</div>
                            <div class="text-[11px] text-slate-400 font-sans font-medium mt-0.5">NUPTK: <span class="font-mono font-bold text-slate-600">{{ $g->nuptk ?: '-' }}</span></div>
                        </td>

                        {{-- PENDIDIKAN --}}
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-slate-100 group-hover:bg-white ring-1 ring-slate-200/80 text-slate-800 font-extrabold text-[11px] transition-colors shadow-2xs">
                                <i class="bi bi-mortarboard-fill text-blue-500"></i>
                                {{ $g->pendidikan_terakhir ?: 'S1' }}
                            </span>
                        </td>

                        {{-- JABATAN & PANGKAT --}}
                        <td class="py-4 px-4">
                            <div class="font-extrabold text-slate-900">{{ $g->jabatan_guru ?: 'Guru Kelas' }}</div>
                            <div class="text-[11px] text-slate-400 font-semibold mt-0.5">{{ $g->pangkat_gol ?: '-' }}</div>
                        </td>

                        {{-- STATUS --}}
                        <td class="py-4 px-4 text-center">
                            @if($g->status == "Aktif")
                                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20 font-black text-[11px] shadow-2xs">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                    </span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-rose-50 text-rose-600 ring-1 ring-rose-500/20 font-bold text-[11px]">
                                    <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                    Non-Aktif
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="py-4 pl-3 pr-8 text-center">
                            <div class="flex items-center justify-center gap-1.5">
                                {{-- DETAIL --}}
                                <button
                                    title="Detail Profil"
                                    onclick='openDetail({
                                                nip: "{{ $g->nip }}",
                                                nuptk: "{{ $g->nuptk }}",
                                                nama_lengkap: "{{ addslashes($g->nama_lengkap) }}",
                                                tempat_lahir: "{{ addslashes($g->tempat_lahir) }}",
                                                tanggal_lahir: "{{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->format('d/m/Y') : '-' }}",
                                                jenis_kelamin: "{{ $g->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}",
                                                pendidikan_terakhir: "{{ addslashes($g->pendidikan_terakhir) }}",
                                                jabatan_guru: "{{ addslashes($g->jabatan_guru) }}",
                                                pangkat_gol: "{{ addslashes($g->pangkat_gol) }}",
                                                alamat: "{{ addslashes($g->alamat) }}",
                                                provinsi: "{{ addslashes($g->provinsi) }}",
                                                kab_kota: "{{ addslashes($g->kab_kota) }}",
                                                kecamatan: "{{ addslashes($g->kecamatan) }}",
                                                kenagarian: "{{ addslashes($g->kenagarian) }}",
                                                no_telepon: "{{ $g->no_telepon }}",
                                                email: "{{ $g->email }}",
                                                status: "{{ $g->status }}"
                                            })'
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-blue-500/20 active:scale-95">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>

                                {{-- EDIT --}}
                                <a href="{{ route('admin.guru.edit', $g->id) }}"
                                   title="Edit Data"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-amber-500/20 active:scale-95">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- HAPUS --}}
                                <form action="{{ route('admin.guru.destroy', $g->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            title="Hapus Data"
                                            class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95">
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
                                <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4 shadow-inner">
                                    <i class="bi bi-person-x text-3xl"></i>
                                </div>
                                <h4 class="font-black text-slate-800 text-base">Belum Ada Data Guru</h4>
                                <p class="text-xs text-slate-400 mt-1 font-medium max-w-sm">Daftar tenaga pendidik masih kosong. Klik tombol Tambah Pendidik Baru di atas untuk mulai memasukkan data.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($guru->hasPages())
            {{ $guru->links('components.pagination') }}
        @endif
    </div>
</div>

{{-- ================================================
     SLIDE-OVER DRAWER DETAIL (Linear / Stripe Admin Style)
     ================================================ --}}
<div id="detailModal" class="fixed inset-0 z-50 overflow-hidden hidden font-sans">
    {{-- Backdrop --}}
    <div id="drawerBackdrop" onclick="closeDetail()" class="absolute inset-0 bg-slate-900/40 backdrop-blur-xs opacity-0 transition-opacity duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]"></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        {{-- Drawer Panel --}}
        <div id="drawerPanel" class="w-screen max-w-xl bg-white shadow-[0_0_80px_rgba(0,0,0,0.25)] border-l border-slate-100 flex flex-col translate-x-full transition-transform duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] relative z-10">
            
            {{-- Drawer Header --}}
            <div class="p-8 pb-6 border-b border-slate-100/80 flex items-center justify-between bg-slate-50/50">
                <div class="flex items-center gap-5">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center text-3xl font-black shadow-lg shadow-blue-500/30 shrink-0">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] uppercase font-black tracking-widest bg-blue-50 text-blue-600 mb-1 ring-1 ring-blue-500/15">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span> Profil Pendidik Resmi
                        </div>
                        <h2 class="text-2xl font-black tracking-tight text-slate-900" id="modalNama">Detail Pendidik</h2>
                        <p class="font-mono text-xs font-bold text-slate-400 mt-0.5" id="modalNip">NIP: -</p>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 flex items-center justify-center transition font-bold text-base shadow-2xs">
                    ✕
                </button>
            </div>

            {{-- Drawer Body: Bento Grid Micro-Cards --}}
            <div class="flex-1 overflow-y-auto p-8 space-y-6">
                
                {{-- Section 1: Akademik --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Informasi Akademik & Pribadi
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">NUPTK</span>
                            <span class="font-mono text-sm font-black text-slate-900 mt-1" id="mNuptk">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Jenis Kelamin</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="mJk">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Tempat, Tanggal Lahir</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="mTtl">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between items-start">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Pendidikan Terakhir</span>
                            <span class="text-xs font-black text-blue-700 bg-blue-100/60 px-3 py-1 rounded-xl mt-1" id="mPendidikan">-</span>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Kepegawaian --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Status Kepegawaian
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Jabatan</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="mJabatan">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Pangkat / Golongan</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="mPangkat">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] sm:col-span-2 flex flex-col justify-between items-start">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Status Aktif</span>
                            <span class="mt-1 inline-block" id="mStatus">-</span>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Kontak & Alamat --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Domisili & Kontak
                    </h4>
                    <div class="space-y-3.5">
                        <div class="bg-slate-50/80 p-4.5 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03]">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Alamat Lengkap</span>
                            <span class="text-sm font-black text-slate-900 leading-relaxed" id="mAlamat">-</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03]">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Nagari</span>
                                <span class="text-sm font-black text-slate-900 mt-1 block break-words leading-snug" id="mKel">-</span>
                            </div>
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03]">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Kecamatan</span>
                                <span class="text-sm font-black text-slate-900 mt-1 block break-words leading-snug" id="mKec">-</span>
                            </div>
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03]">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Kabupaten</span>
                                <span class="text-sm font-black text-slate-900 mt-1 block break-words leading-snug" id="mKab">-</span>
                            </div>
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03]">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block">Provinsi</span>
                                <span class="text-sm font-black text-slate-900 mt-1 block break-words leading-snug" id="mProv">-</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">No. Telepon / WhatsApp</span>
                                <span class="text-sm font-black text-slate-900 mt-1 font-mono break-words" id="mTelp">-</span>
                            </div>
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Alamat Email</span>
                                <span class="text-sm font-black text-slate-900 mt-1 break-all leading-snug" id="mEmail">-</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Drawer Footer --}}
            <div class="p-6 border-t border-slate-100 bg-slate-50/50 flex justify-end">
                <button onclick="closeDetail()" class="px-8 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-full transition shadow-md active:scale-95">
                    Tutup Panel
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ================= JS ================= --}}
<script>
function openDetail(g){
    document.getElementById("modalNama").innerText = g.nama_lengkap || 'Pendidik';
    document.getElementById("modalNip").innerText = "NIP: " + (g.nip || '-');
    
    document.getElementById("mNuptk").innerText = g.nuptk || '-';
    document.getElementById("mJk").innerText = g.jenis_kelamin || '-';
    document.getElementById("mTtl").innerText = (g.tempat_lahir || '-') + ", " + (g.tanggal_lahir || '-');
    document.getElementById("mPendidikan").innerText = g.pendidikan_terakhir || '-';
    
    document.getElementById("mJabatan").innerText = g.jabatan_guru || '-';
    document.getElementById("mPangkat").innerText = g.pangkat_gol || '-';
    
    const stEl = document.getElementById("mStatus");
    if(g.status == "Aktif"){
        stEl.innerHTML = '<span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-emerald-500/20 font-black text-xs shadow-2xs"><span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span></span>Aktif Mengajar</span>';
    } else {
        stEl.innerHTML = '<span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-rose-50 text-rose-600 ring-1 ring-rose-500/20 font-bold text-xs"><span class="w-2 h-2 rounded-full bg-rose-500"></span>Non-Aktif</span>';
    }

    document.getElementById("mAlamat").innerText = g.alamat || '-';
    document.getElementById("mKel").innerText = g.kenagarian || '-';
    document.getElementById("mKec").innerText = g.kecamatan || '-';
    document.getElementById("mKab").innerText = g.kab_kota || '-';
    document.getElementById("mProv").innerText = g.provinsi || '-';
    
    document.getElementById("mTelp").innerText = g.no_telepon || '-';
    document.getElementById("mEmail").innerText = g.email || '-';

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

    setTimeout(() => {
        document.getElementById("detailModal").classList.add("hidden");
    }, 450);
}

document.addEventListener('DOMContentLoaded', function () {
    let searchTimeout = null;
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        if (searchInput.value.length > 0 && document.activeElement === searchInput) {
            const len = searchInput.value.length;
            searchInput.setSelectionRange(len, len);
        }
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    }
});
</script>

@endsection