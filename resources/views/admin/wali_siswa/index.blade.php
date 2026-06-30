@extends('admin.layout')

@section('content')

<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-indigo-500/10 via-purple-500/10 to-pink-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-600 to-purple-600 text-white flex items-center justify-center shadow-lg shadow-indigo-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-people text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-indigo-50/80 text-indigo-700 ring-1 ring-indigo-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                    </span>
                    <span>Direktori Wali & Orang Tua</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? 'Manajemen Wali Siswa' }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-indigo-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total <strong class="text-slate-700">{{ $waliSiswa->total() }}</strong> Wali Terdaftar</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.wali-siswa.create') }}"
           class="group relative z-10 inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold text-xs shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start">
            <span class="tracking-wide">Tambah Wali Siswa</span>
            <div class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-sm font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         FILTER & SEARCH BAR (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-3xl p-4 sm:p-5 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.wali-siswa.index') }}" method="GET" id="searchForm" class="relative">
            <div class="relative flex items-center">
                <div class="absolute left-4 w-9 h-9 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold pointer-events-none">
                    <i class="bi bi-search text-sm"></i>
                </div>
                <input
                    id="searchInput"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Ketik NISN, nama siswa, wali, atau pekerjaan untuk mencari..."
                    class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl pl-16 pr-28 py-3.5 text-xs font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-500/15 focus:border-indigo-600 transition-all shadow-inner">
                @if(request('search'))
                    <a href="{{ route('admin.wali-siswa.index') }}" class="absolute right-3 bg-slate-200/80 hover:bg-rose-50 hover:text-rose-600 text-slate-700 transition px-4 py-2 rounded-xl text-xs font-extrabold flex items-center gap-1.5 shadow-2xs">
                        <i class="bi bi-x-circle-fill text-xs"></i> Reset
                    </a>
                @endif
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
                        <th class="pb-4 pl-4">Wali & Hubungan</th>
                        <th class="pb-4">Siswa Terkait</th>
                        <th class="pb-4">NISN</th>
                        <th class="pb-4">Pekerjaan</th>
                        <th class="pb-4">Telepon / HP</th>
                        <th class="pb-4 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-xs font-semibold text-slate-700">
                    @forelse($waliSiswa as $item)
                    <tr class="hover:bg-indigo-50/40 transition-colors group">
                        <td class="py-4 pl-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black text-xs shadow-md shrink-0 group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($item->nama_wali, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block font-black text-slate-900 group-hover:text-indigo-600 transition-colors text-sm">{{ $item->nama_wali }}</span>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded-md text-[10px] font-extrabold uppercase bg-indigo-50 text-indigo-600">{{ $item->hubungan }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 font-bold text-slate-800">
                            {{ $item->siswa->nama_siswa ?? '-' }}
                        </td>
                        <td class="py-4 font-mono font-bold text-slate-500">{{ $item->nisn }}</td>
                        <td class="py-4 font-bold text-slate-600">{{ $item->pekerjaan ?: '-' }}</td>
                        <td class="py-4 font-mono text-slate-600">{{ $item->telepon ?: '-' }}</td>
                        
                        <td class="py-4 pr-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <button
                                    onclick="openDetail(this)"
                                    data-wali="{{ $item->nama_wali }}"
                                    data-hubungan="{{ $item->hubungan }}"
                                    data-pekerjaan="{{ $item->pekerjaan ?: '-' }}"
                                    data-telepon="{{ $item->telepon ?: '-' }}"
                                    data-alamat="{{ $item->alamat ?: '-' }}"
                                    data-siswa="{{ $item->siswa->nama_siswa ?? '-' }}"
                                    data-nisn="{{ $item->nisn }}"
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-indigo-500/20 active:scale-95"
                                    title="Lihat Detail Wali">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.wali-siswa.edit', $item->id_wali) }}"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-amber-500/20 active:scale-95"
                                   title="Edit Wali Siswa">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.wali-siswa.destroy', $item->id_wali) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data wali siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95" title="Hapus Wali Siswa">
                                        <i class="bi bi-trash3-fill text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4 shadow-inner">
                                    <i class="bi bi-person-x text-3xl"></i>
                                </div>
                                <h4 class="font-black text-slate-800 text-base">Belum Ada Data Wali Siswa Terdaftar</h4>
                                <p class="text-xs text-slate-400 mt-1 font-medium max-w-sm">Daftar wali peserta didik masih kosong. Klik tombol Tambah Wali Siswa di atas untuk mulai memasukkan data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($waliSiswa->hasPages())
            {{ $waliSiswa->links('components.pagination') }}
        @endif
    </div>

</div>

{{-- ================================================
     SLIDE-OVER DRAWER DETAIL WALI SISWA (Linear / Stripe Admin Style)
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
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-3xl font-black shadow-lg shadow-indigo-500/30 shrink-0">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] uppercase font-black tracking-widest bg-indigo-50 text-indigo-600 mb-1 ring-1 ring-indigo-500/15">
                            <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span> Profil Wali Resmi
                        </div>
                        <h2 class="text-2xl font-black tracking-tight text-slate-900" id="w_nama">Detail Wali Siswa</h2>
                        <p class="text-xs font-extrabold text-indigo-600 mt-0.5" id="w_hubungan">Hubungan: -</p>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 flex items-center justify-center transition font-bold text-base shadow-2xs">
                    ✕
                </button>
            </div>

            {{-- Drawer Body: Bento Grid Micro-Cards --}}
            <div class="flex-1 overflow-y-auto p-8 space-y-6">
                
                {{-- Section 1: Siswa Terkait --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Informasi Siswa Terkait
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Nama Siswa</span>
                            <span class="text-base font-black text-slate-900 mt-1" id="w_siswa">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">NISN Siswa</span>
                            <span class="font-mono text-base font-black text-indigo-600 mt-1" id="w_nisn">-</span>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Data Wali --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-purple-500"></span> Profil & Pekerjaan Wali
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Pekerjaan</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="w_pekerjaan">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">No. Telepon / WhatsApp</span>
                            <span class="text-sm font-black text-slate-900 mt-1 font-mono" id="w_telepon">-</span>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Alamat --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span> Domisili
                    </h4>
                    <div class="bg-slate-50/80 p-5 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03]">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 block mb-1">Alamat Lengkap</span>
                        <span class="text-sm font-black text-slate-900 leading-relaxed" id="w_alamat">-</span>
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

{{-- SEARCH & MODAL JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimeout = null;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            if (searchInput.value.length > 0 && document.activeElement === searchInput) {
                const len = searchInput.value.length;
                searchInput.setSelectionRange(len, len);
            }
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 500);
            });
        }
    });

    function openDetail(btn) {
        document.getElementById('w_nama').innerText = btn.dataset.wali || '-';
        document.getElementById('w_hubungan').innerText = "Hubungan: " + (btn.dataset.hubungan || '-');
        document.getElementById('w_pekerjaan').innerText = btn.dataset.pekerjaan || '-';
        document.getElementById('w_telepon').innerText = btn.dataset.telepon || '-';
        document.getElementById('w_alamat').innerText = btn.dataset.alamat || '-';
        document.getElementById('w_siswa').innerText = btn.dataset.siswa || '-';
        document.getElementById('w_nisn').innerText = btn.dataset.nisn || '-';

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

    function closeDetail() {
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
</script>

@endsection