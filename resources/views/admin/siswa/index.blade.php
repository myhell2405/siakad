@extends('admin.layout')

@section('content')

<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-people-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50/80 text-blue-700 ring-1 ring-blue-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Direktori Peserta Didik</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    Manajemen Siswa
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-blue-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total <strong class="text-slate-700">{{ $siswa->total() }}</strong> Siswa Terdaftar</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.siswa.create') }}"
           class="group relative z-10 inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-xs shadow-lg shadow-blue-500/25 hover:shadow-xl hover:shadow-blue-500/30 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start">
            <span class="tracking-wide">Tambah Siswa Baru</span>
            <div class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-sm font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         FILTER & SEARCH BAR (Floating Elevation Card)
         ================================================ --}}
    <div class="bg-white rounded-3xl p-4 sm:p-5 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.siswa.index') }}" method="GET" id="searchForm" class="relative">
            <div class="relative flex items-center">
                <div class="absolute left-4 w-9 h-9 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold pointer-events-none">
                    <i class="bi bi-search text-sm"></i>
                </div>
                <input
                    id="searchInput"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Ketik nama siswa atau NISN untuk mencari..."
                    class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl pl-16 pr-28 py-3.5 text-xs font-bold text-slate-800 placeholder:text-slate-400 placeholder:font-medium focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner">
                @if(request('search'))
                    <a href="{{ route('admin.siswa.index') }}" class="absolute right-3 bg-slate-200/80 hover:bg-rose-50 hover:text-rose-600 text-slate-700 transition px-4 py-2 rounded-xl text-xs font-extrabold flex items-center gap-1.5 shadow-2xs">
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
                        <th class="pb-4 pl-4">Peserta Didik</th>
                        <th class="pb-4">NISN</th>
                        <th class="pb-4">Gender</th>
                        <th class="pb-4">Tanggal Lahir</th>
                        <th class="pb-4">Kontak / HP</th>
                        <th class="pb-4 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-xs font-semibold text-slate-700">
                    @forelse($siswa as $s)
                    <tr class="hover:bg-blue-50/40 transition-colors group">
                        <td class="py-4 pl-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br {{ $s->jenis_kelamin == 'L' ? 'from-blue-500 to-indigo-600' : 'from-rose-500 to-pink-600' }} text-white flex items-center justify-center font-black text-xs shadow-md shrink-0 group-hover:scale-105 transition-transform">
                                    {{ strtoupper(substr($s->nama_siswa, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block font-black text-slate-900 group-hover:text-blue-600 transition-colors text-sm">{{ $s->nama_siswa }}</span>
                                    <span class="text-[11px] font-bold text-slate-400">{{ $s->sekolah_asal ?: 'SDN 01 Durian Gadang' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 font-mono font-bold text-slate-600">{{ $s->nisn }}</td>
                        <td class="py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase {{ $s->jenis_kelamin == 'L' ? 'bg-blue-50 text-blue-700' : 'bg-rose-50 text-rose-700' }}">
                                <i class="bi {{ $s->jenis_kelamin == 'L' ? 'bi-gender-male' : 'bi-gender-female' }}"></i>
                                {{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="py-4 font-bold text-slate-600">
                            {{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d/m/Y') }}
                        </td>
                        <td class="py-4 font-mono text-slate-600">{{ $s->telp_siswa ?: '-' }}</td>
                        
                        <td class="py-4 pr-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <button
                                    onclick="openDetail(this)"
                                    data-nisn="{{ $s->nisn }}"
                                    data-nama="{{ $s->nama_siswa }}"
                                    data-tempat="{{ $s->tempat_lahir }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d F Y') }}"
                                    data-jenis="{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}"
                                    data-agama="{{ $s->agama }}"
                                    data-status="{{ $s->status_keluarga }}"
                                    data-anak="{{ $s->anak_ke }}"
                                    data-alamat="{{ $s->alamat_siswa }}"
                                    data-telp="{{ $s->telp_siswa }}"
                                    data-sekolah="{{ $s->sekolah_asal }}"
                                    data-diterima="{{ $s->tanggal_diterima ? \Carbon\Carbon::parse($s->tanggal_diterima)->format('d F Y') : '-' }}"
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-blue-600 hover:to-indigo-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-blue-500/20 active:scale-95"
                                    title="Lihat Detail">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-amber-500/20 active:scale-95"
                                   title="Edit Siswa">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95" title="Hapus Siswa">
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
                                <h4 class="font-black text-slate-800 text-base">Belum Ada Data Siswa Terdaftar</h4>
                                <p class="text-xs text-slate-400 mt-1 font-medium max-w-sm">Daftar peserta didik masih kosong. Klik tombol Tambah Siswa Baru di atas untuk mulai memasukkan data.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($siswa->hasPages())
            {{ $siswa->links('components.pagination') }}
        @endif
    </div>

</div>

{{-- ================================================
     SLIDE-OVER DRAWER DETAIL SISWA (Linear / Stripe Admin Style)
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
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center text-3xl font-black shadow-lg shadow-blue-500/30 shrink-0">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div>
                        <div class="inline-flex items-center gap-1.5 rounded-full px-3 py-1 text-[10px] uppercase font-black tracking-widest bg-blue-50 text-blue-600 mb-1 ring-1 ring-blue-500/15">
                            <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span> Profil Peserta Didik
                        </div>
                        <h2 class="text-2xl font-black tracking-tight text-slate-900" id="d_nama">Detail Siswa</h2>
                        <p class="font-mono text-xs font-bold text-slate-400 mt-0.5">NISN: <span id="d_nisn">-</span></p>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-10 h-10 rounded-full bg-slate-100 hover:bg-rose-50 hover:text-rose-600 text-slate-500 flex items-center justify-center transition font-bold text-base shadow-2xs">
                    ✕
                </button>
            </div>

            {{-- Drawer Body: Bento Grid Micro-Cards --}}
            <div class="flex-1 overflow-y-auto p-8 space-y-6">
                
                {{-- Section 1: Data Pribadi --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span> Data Pribadi Siswa
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Tempat Lahir</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_tempat">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Tanggal Lahir</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_tanggal">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Jenis Kelamin</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_jenis">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Agama</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_agama">-</span>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Keluarga & Sekolah Asal --}}
                <div>
                    <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span> Status & Riwayat
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Status Keluarga</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_status">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Anak Ke</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_anak">-</span>
                        </div>
                        <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                            <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Tanggal Diterima</span>
                            <span class="text-sm font-black text-slate-900 mt-1" id="d_diterima">-</span>
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
                            <span class="text-sm font-black text-slate-900 leading-relaxed" id="d_alamat">-</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">No. HP / Telepon</span>
                                <span class="text-sm font-black text-slate-900 mt-1 font-mono" id="d_telp">-</span>
                            </div>
                            <div class="bg-slate-50/80 p-4 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Sekolah Asal</span>
                                <span class="text-sm font-black text-slate-900 mt-1 break-words leading-snug" id="d_sekolah">-</span>
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
        document.getElementById('d_nisn').innerText = btn.dataset.nisn || '-';
        document.getElementById('d_nama').innerText = btn.dataset.nama || '-';
        document.getElementById('d_tempat').innerText = btn.dataset.tempat || '-';
        document.getElementById('d_tanggal').innerText = btn.dataset.tanggal || '-';
        document.getElementById('d_jenis').innerText = btn.dataset.jenis || '-';
        document.getElementById('d_agama').innerText = btn.dataset.agama || '-';
        document.getElementById('d_status').innerText = btn.dataset.status || '-';
        document.getElementById('d_anak').innerText = btn.dataset.anak || '-';
        document.getElementById('d_alamat').innerText = btn.dataset.alamat || '-';
        document.getElementById('d_telp').innerText = btn.dataset.telp || '-';
        document.getElementById('d_sekolah').innerText = btn.dataset.sekolah || '-';
        document.getElementById('d_diterima').innerText = btn.dataset.diterima || '-';

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