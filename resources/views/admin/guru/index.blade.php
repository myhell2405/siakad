@extends('admin.layout')

@section('content')

<div class="space-y-8 font-sans text-gray-900 pb-16">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-person-workspace text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>MASTER DATA PENDIDIK</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? 'MANAJEMEN GURU & STAF') }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL <strong class="text-void font-black">{{ $guru->total() }}</strong> PENDIDIK TERDAFTAR</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.guru.create') }}"
           class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase">
            <span>TAMBAH PENDIDIK BARU</span>
            <i class="bi bi-plus-lg text-signal font-bold text-sm"></i>
        </a>
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
        <form action="{{ route('admin.guru.index') }}" method="GET" id="searchForm" class="relative font-mono text-xs">
            <div class="relative flex items-center">
                <div class="absolute left-4 text-gray-400">
                    <i class="bi bi-search"></i>
                </div>
                <input
                    id="searchInput"
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="Cari nama pendidik, NIP, atau NUPTK..."
                    class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl pl-11 pr-24 py-3 text-xs font-mono font-bold text-void placeholder:text-gray-400 focus:bg-white focus:outline-none focus:border-void transition-all">
                @if(request('search'))
                    <a href="{{ route('admin.guru.index') }}" class="absolute right-3 bg-gray-200 hover:bg-signal hover:text-white transition px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABLE DATA GURU --}}
    <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono">
                <thead>
                    <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        <th class="py-3.5 pl-3 text-center w-14">NO</th>
                        <th class="py-3.5">IDENTITAS PENDIDIK</th>
                        <th class="py-3.5">NIP / NUPTK</th>
                        <th class="py-3.5">PENDIDIKAN</th>
                        <th class="py-3.5">JABATAN & GOL</th>
                        <th class="py-3.5 text-center">STATUS</th>
                        <th class="py-3.5 pr-3 text-right w-36">AKSI</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                @forelse($guru as $g)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-3 text-center text-gray-400">{{ ($guru->currentPage() - 1) * $guru->perPage() + $loop->iteration }}</td>
                        <td class="py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-void text-white flex items-center justify-center font-black text-xs shrink-0">
                                    {{ substr(preg_replace('/[^A-Za-z]/', '', $g->nama_lengkap ?? 'G'), 0, 2) }}
                                </div>
                                <div>
                                    <span class="block font-black text-void group-hover:text-cobalt transition-colors text-sm font-sans uppercase">
                                        {{ $g->nama_lengkap }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 text-[10px] text-gray-400 font-mono mt-0.5 uppercase">
                                        <i class="bi {{ $g->jenis_kelamin == 'P' ? 'bi-gender-female text-signal' : 'bi-gender-male text-cobalt' }}"></i>
                                        {{ $g->jenis_kelamin == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 font-mono">
                            <div class="text-void font-bold">{{ $g->nip ?: '-' }}</div>
                            <div class="text-[10px] text-gray-400 mt-0.5">NUPTK: <span class="text-gray-600">{{ $g->nuptk ?: '-' }}</span></div>
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-void font-bold text-[10px] uppercase">
                                <i class="bi bi-mortarboard-fill text-cobalt"></i>
                                {{ strtoupper($g->pendidikan_terakhir ?: 'S1') }}
                            </span>
                        </td>
                        <td class="py-4 font-sans">
                            <div class="font-bold text-void text-xs uppercase">{{ $g->jabatan_guru ?: 'GURU KELAS' }}</div>
                            <div class="text-[10px] text-gray-400 font-mono mt-0.5 uppercase">{{ $g->pangkat_gol ?: '-' }}</div>
                        </td>
                        <td class="py-4 text-center">
                            @if($g->status == "Aktif")
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-800 border border-emerald-200 font-bold text-[10px] uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span> AKTIF
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-gray-100 text-gray-600 border border-gray-200 font-bold text-[10px] uppercase">
                                    NON-AKTIF
                                </span>
                            @endif
                        </td>
                        <td class="py-4 pr-3 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <button
                                    title="Detail Profil"
                                    onclick='openDetail({
                                                nip: "{{ $g->nip }}",
                                                nuptk: "{{ $g->nuptk }}",
                                                nama_lengkap: "{{ addslashes($g->nama_lengkap) }}",
                                                tempat_lahir: "{{ addslashes($g->tempat_lahir) }}",
                                                tanggal_lahir: "{{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->format('d/m/Y') : '-' }}",
                                                jenis_kelamin: "{{ $g->jenis_kelamin == 'P' ? 'PEREMPUAN' : 'LAKI-LAKI' }}",
                                                pendidikan_terakhir: "{{ strtoupper(addslashes($g->pendidikan_terakhir)) }}",
                                                jabatan_guru: "{{ strtoupper(addslashes($g->jabatan_guru)) }}",
                                                pangkat_gol: "{{ strtoupper(addslashes($g->pangkat_gol)) }}",
                                                alamat: "{{ strtoupper(addslashes($g->alamat)) }}",
                                                no_telepon: "{{ $g->no_telepon }}",
                                                email: "{{ $g->email }}",
                                                status: "{{ strtoupper($g->status) }}"
                                            })'
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void text-void hover:text-white flex items-center justify-center transition">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>
                                <a href="{{ route('admin.laporan.identitas-guru', ['id_guru' => $g->id, 'print' => 1]) }}" target="_blank"
                                   title="Cetak Lembar Identitas"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-blue-600 hover:text-white text-void flex items-center justify-center transition">
                                    <i class="bi bi-printer-fill text-xs"></i>
                                </a>
                                <a href="{{ route('admin.guru.edit', $g->id) }}"
                                   title="Edit Data"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white text-void flex items-center justify-center transition">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>
                                <form action="{{ route('admin.guru.destroy', $g->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus data guru ini?')">
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
                                    <i class="bi bi-person-x text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-sm uppercase">BELUM ADA DATA GURU</h4>
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
                        <h2 class="text-xl font-black tracking-tight text-void uppercase font-sans" id="modalNama">DETAIL PENDIDIK</h2>
                        <p class="text-xs font-bold text-cobalt mt-0.5 font-mono uppercase" id="modalSub">NIP: - • NUPTK: -</p>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-9 h-9 rounded-xl bg-white hover:bg-gray-200 text-void flex items-center justify-center transition font-bold border border-black/10">
                    ✕
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 space-y-8 text-xs">
                {{-- INFORMASI PROFESI & AKADEMIK --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-briefcase-fill text-cobalt"></i> INFORMASI PROFESI & AKADEMIK
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">NIP</span>
                            <span class="font-bold text-void mt-1 block font-mono text-sm" id="mNip">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">NUPTK</span>
                            <span class="font-bold text-cobalt mt-1 block font-mono text-sm" id="mNuptk">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">JABATAN</span>
                            <span class="font-bold text-void mt-1 block" id="mJabatan">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">PANGKAT / GOLONGAN</span>
                            <span class="font-bold text-void mt-1 block font-mono" id="mPangkat">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">PENDIDIKAN TERAKHIR</span>
                            <span class="font-bold text-void mt-1 block" id="mPendidikan">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase">STATUS KEPEGAWAIAN</span>
                            <span class="font-bold text-void mt-1 block" id="mStatus">-</span>
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
                            <span class="text-[10px] text-gray-400 block uppercase">TEMPAT, TGL LAHIR</span>
                            <span class="font-bold text-void mt-1 block" id="mTtl">-</span>
                        </div>
                    </div>
                </div>

                {{-- KONTAK & DOMISILI --}}
                <div>
                    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <i class="bi bi-geo-alt-fill text-cobalt"></i> KONTAK & DOMISILI
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase mb-1">NO. TELEPON / HP</span>
                            <span class="font-bold text-void block font-mono" id="mTelp">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5">
                            <span class="text-[10px] text-gray-400 block uppercase mb-1">EMAIL</span>
                            <span class="font-bold text-void block font-mono lowercase" id="mEmail">-</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-xl border border-black/5 sm:col-span-2">
                            <span class="text-[10px] text-gray-400 block uppercase mb-1">ALAMAT LENGKAP DOMISILI</span>
                            <span class="font-bold text-void block leading-relaxed" id="mAlamat">-</span>
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
function openDetail(g){
    document.getElementById("modalNama").innerText = g.nama_lengkap || 'PENDIDIK';
    document.getElementById("modalSub").innerText = "NIP: " + (g.nip || '-') + " • NUPTK: " + (g.nuptk || '-');
    
    document.getElementById("mNip").innerText = g.nip || '-';
    document.getElementById("mNuptk").innerText = g.nuptk || '-';
    document.getElementById("mJabatan").innerText = g.jabatan_guru || '-';
    document.getElementById("mPangkat").innerText = g.pangkat_gol || '-';
    document.getElementById("mPendidikan").innerText = g.pendidikan_terakhir || '-';
    document.getElementById("mStatus").innerText = g.status || '-';

    document.getElementById("mJk").innerText = g.jenis_kelamin || '-';
    document.getElementById("mTtl").innerText = (g.tempat_lahir || '-') + ", " + (g.tanggal_lahir || '-');

    document.getElementById("mTelp").innerText = g.no_telepon || '-';
    document.getElementById("mEmail").innerText = g.email || '-';
    document.getElementById("mAlamat").innerText = g.alamat || '-';

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