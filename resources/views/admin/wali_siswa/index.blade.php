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
                    <span>DIREKTORI WALI & ORANG TUA</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? 'MANAJEMEN WALI SISWA') }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL <strong class="text-void font-black">{{ $waliSiswa->total() }}</strong> WALI TERDAFTAR</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.wali-siswa.create') }}"
           class="inline-flex items-center gap-3 px-6 py-3.5 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase">
            <i class="bi bi-plus-lg text-signal"></i> TAMBAH WALI SISWA
        </a>
    </div>

    {{-- FILTER & SEARCH BAR --}}
    <div class="bg-white rounded-2xl p-4 border border-black/10 shadow-xs">
        <form action="{{ route('admin.wali-siswa.index') }}" method="GET" id="searchForm" class="relative">
            <div class="relative flex items-center">
                <div class="absolute left-4 w-9 h-9 rounded-xl bg-gray-100 text-void flex items-center justify-center font-bold pointer-events-none">
                    <i class="bi bi-search text-sm"></i>
                </div>
                <input
                    id="searchInput"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Ketik NISN, nama siswa, wali, atau pekerjaan untuk mencari..."
                    class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl pl-16 pr-28 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all">
                @if(request('search'))
                    <a href="{{ route('admin.wali-siswa.index') }}" class="absolute right-3 bg-gray-200 hover:bg-signal hover:text-white text-void transition px-4 py-1.5 rounded-lg text-xs font-mono font-bold flex items-center gap-1.5 uppercase">
                        <i class="bi bi-x-circle-fill text-xs"></i> Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface border-b border-black/10 text-void font-mono text-[10px] uppercase tracking-wider">
                        <th class="py-4 pl-6">WALI & HUBUNGAN</th>
                        <th class="py-4">SISWA TERKAIT</th>
                        <th class="py-4">NISN</th>
                        <th class="py-4">PEKERJAAN</th>
                        <th class="py-4">TELEPON / HP</th>
                        <th class="py-4 text-right pr-6">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-black/5 text-xs font-medium text-gray-700">
                    @forelse($waliSiswa as $item)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-void text-white flex items-center justify-center font-mono font-bold text-xs shrink-0 shadow-xs">
                                    {{ strtoupper(substr($item->nama_wali, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block font-bold text-void uppercase text-sm">{{ $item->nama_wali }}</span>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-mono font-bold uppercase bg-gray-100 text-cobalt border border-black/5">{{ $item->hubungan }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 font-bold text-void uppercase">
                            {{ $item->siswa->nama_siswa ?? '-' }}
                        </td>
                        <td class="py-4 font-mono font-bold text-gray-600">{{ $item->nisn }}</td>
                        <td class="py-4 font-bold text-gray-700 uppercase">{{ $item->pekerjaan ?: '-' }}</td>
                        <td class="py-4 font-mono text-gray-700">{{ $item->telepon ?: '-' }}</td>
                        
                        <td class="py-4 pr-6 text-right">
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
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void text-void hover:text-white flex items-center justify-center transition"
                                    title="Lihat Detail Wali">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.wali-siswa.edit', $item->id_wali) }}"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-cobalt text-void hover:text-white flex items-center justify-center transition"
                                   title="Edit Wali Siswa">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.wali-siswa.destroy', $item->id_wali) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data wali siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-signal text-void hover:text-white flex items-center justify-center transition" title="Hapus Wali Siswa">
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
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 text-gray-400 flex items-center justify-center mb-4 border border-black/5">
                                    <i class="bi bi-person-x text-3xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-base uppercase font-mono">BELUM ADA DATA WALI SISWA</h4>
                                <p class="text-xs text-gray-500 mt-1 max-w-sm">Daftar wali peserta didik masih kosong. Klik tombol Tambah Wali Siswa di atas untuk mulai memasukkan data.</p>
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

{{-- DRAWER DETAIL WALI SISWA --}}
<div id="detailModal" class="fixed inset-0 z-50 overflow-hidden hidden font-mono">
    <div id="drawerBackdrop" onclick="closeDetail()" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>

    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div id="drawerPanel" class="w-screen max-w-xl bg-white border-l border-black/10 flex flex-col translate-x-full transition-transform duration-300 relative z-10">
            
            <div class="p-8 pb-6 border-b border-gray-100 flex items-center justify-between bg-gray-50">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-void text-white flex items-center justify-center text-2xl font-black shrink-0 shadow-xs">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <h2 class="text-xl font-black tracking-tight text-void uppercase font-sans" id="w_nama">DETAIL WALI SISWA</h2>
                        <p class="text-xs font-bold text-cobalt mt-0.5 uppercase" id="w_hubungan">HUBUNGAN: -</p>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-9 h-9 rounded-xl bg-white hover:bg-gray-200 text-void flex items-center justify-center transition font-bold border border-black/10">
                    ✕
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-8 space-y-8 text-xs">
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-person-badge-fill text-cobalt"></i> INFORMASI SISWA TERKAIT
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 flex flex-col justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">NAMA SISWA</span>
                            <span class="text-sm font-bold text-void mt-1 font-sans uppercase" id="w_siswa">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 flex flex-col justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">NISN SISWA</span>
                            <span class="font-mono text-sm font-bold text-cobalt mt-1" id="w_nisn">-</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-briefcase-fill text-cobalt"></i> PROFIL & PEKERJAAN WALI
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 flex flex-col justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">PEKERJAAN</span>
                            <span class="text-sm font-bold text-void mt-1 uppercase" id="w_pekerjaan">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 flex flex-col justify-between">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400">NO. TELEPON / WHATSAPP</span>
                            <span class="text-sm font-bold text-void mt-1 font-mono" id="w_telepon">-</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-cobalt"></i> DOMISILI
                    </h4>
                    <div class="bg-gray-50 p-5 rounded-xl border border-black/5">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-gray-400 block mb-1">ALAMAT LENGKAP</span>
                        <span class="text-sm font-bold text-void leading-relaxed uppercase" id="w_alamat">-</span>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button onclick="closeDetail()" class="px-7 py-2.5 bg-void text-white font-bold text-xs rounded-xl hover:bg-black transition uppercase shadow-xs">
                    TUTUP
                </button>
            </div>
        </div>
    </div>
</div>

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
        document.getElementById('w_hubungan').innerText = "HUBUNGAN: " + (btn.dataset.hubungan || '-');
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
        }, 300);
    }
</script>

@endsection