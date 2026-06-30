@extends('admin.layout')

@section('content')

<div class="space-y-8 font-sans text-gray-900 pb-16">

    {{-- HERO HEADER SECTION --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-door-open-fill text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>DIREKTORI ROMBONGAN BELAJAR</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">
                    {{ strtoupper($title ?? 'MANAJEMEN KELAS') }}
                </h1>
                <p class="text-xs text-gray-500 font-mono flex items-center gap-2 pt-0.5 uppercase">
                    <span>SDN 01 DURIAN GADANG</span>
                    <span>•</span>
                    <span>TOTAL <strong class="text-void font-black">{{ $kelas->count() }}</strong> KELAS TERDAFTAR</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.kelas.create') }}"
           class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-void hover:bg-black text-white font-mono font-bold text-xs transition shadow-md uppercase">
            <span>TAMBAH KELAS BARU</span>
            <i class="bi bi-plus-lg text-signal font-bold text-sm"></i>
        </a>
    </div>

    {{-- TABLE SECTION --}}
    <div class="bg-white rounded-3xl p-8 border border-black/10 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left font-mono">
                <thead>
                    <tr class="border-b border-gray-200 text-[11px] font-bold text-gray-400 uppercase tracking-wider">
                        <th class="py-3.5 pl-3 text-center w-16">NO</th>
                        <th class="py-3.5">NAMA KELAS</th>
                        <th class="py-3.5">TINGKAT KELAS</th>
                        <th class="py-3.5 pr-3 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-xs font-bold text-gray-800">
                    @forelse($kelas as $item)
                    <tr class="hover:bg-gray-50/80 transition-colors group">
                        <td class="py-4 pl-3 text-center text-gray-400">{{ $loop->iteration }}</td>
                        <td class="py-4">
                            <div class="flex items-center gap-3.5">
                                <div class="w-9 h-9 rounded-xl bg-void text-white flex items-center justify-center font-black text-sm shrink-0">
                                    {{ $item->tingkat_kelas }}
                                </div>
                                <span class="font-black text-void group-hover:text-cobalt transition-colors text-base font-sans uppercase">{{ $item->nama_kelas }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-gray-100 text-void font-bold text-[11px] uppercase">
                                <i class="bi bi-layers-fill text-cobalt"></i> TINGKAT {{ $item->tingkat_kelas }}
                            </span>
                        </td>
                        <td class="py-4 pr-3 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <button
                                    onclick="openDetail(this)"
                                    data-nama="{{ strtoupper($item->nama_kelas) }}"
                                    data-tingkat="{{ $item->tingkat_kelas }}"
                                    class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-void text-void hover:text-white flex items-center justify-center transition"
                                    title="Lihat Detail Kelas">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>
                                <a href="{{ route('admin.kelas.edit', $item->id_kelas) }}"
                                   class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-amber-500 hover:text-white text-void flex items-center justify-center transition"
                                   title="Edit Kelas">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>
                                <form action="{{ route('admin.kelas.destroy', $item->id_kelas) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-signal hover:text-white text-void flex items-center justify-center transition" title="Hapus Kelas">
                                        <i class="bi bi-trash3-fill text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-14 h-14 rounded-2xl bg-gray-50 text-gray-400 flex items-center justify-center mb-3">
                                    <i class="bi bi-door-closed text-2xl"></i>
                                </div>
                                <h4 class="font-bold text-void text-sm uppercase">BELUM ADA DATA KELAS TERDAFTAR</h4>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- DRAWER DETAIL --}}
<div id="detailModal" class="fixed inset-0 z-50 overflow-hidden hidden font-mono">
    <div id="drawerBackdrop" onclick="closeDetail()" class="absolute inset-0 bg-black/50 opacity-0 transition-opacity duration-300"></div>
    <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div id="drawerPanel" class="w-screen max-w-md bg-white border-l border-black/10 flex flex-col translate-x-full transition-transform duration-300 relative z-10">
            <div class="p-8 pb-6 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-void text-white flex items-center justify-center font-black text-2xl shrink-0">
                        <i class="bi bi-door-open-fill text-signal"></i>
                    </div>
                    <div>
                        <h3 id="k_nama" class="text-xl font-black text-void uppercase font-sans">DETAIL KELAS</h3>
                    </div>
                </div>
                <button onclick="closeDetail()" class="w-9 h-9 rounded-xl bg-white hover:bg-gray-200 text-void flex items-center justify-center transition font-bold">
                    ✕
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 space-y-6 text-xs">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-5 rounded-xl border border-black/5 flex flex-col justify-between">
                        <span class="text-[10px] text-gray-400 block">NAMA KELAS</span>
                        <span class="text-lg font-bold text-void mt-1 font-sans uppercase" id="m_nama_kelas">-</span>
                    </div>
                    <div class="bg-gray-50 p-5 rounded-xl border border-black/5 flex flex-col justify-between">
                        <span class="text-[10px] text-gray-400 block">TINGKAT KELAS</span>
                        <span class="text-lg font-bold text-cobalt mt-1" id="m_tingkat">-</span>
                    </div>
                </div>
            </div>
            <div class="p-6 border-t border-gray-100 bg-gray-50 flex justify-end">
                <button onclick="closeDetail()" class="px-7 py-2.5 bg-void text-white font-bold text-xs rounded-xl hover:bg-black transition uppercase">TUTUP</button>
            </div>
        </div>
    </div>
</div>

<script>
function openDetail(btn) {
    document.getElementById('k_nama').innerText = btn.dataset.nama || '-';
    document.getElementById('m_nama_kelas').innerText = btn.dataset.nama || '-';
    document.getElementById('m_tingkat').innerText = "TINGKAT " + (btn.dataset.tingkat || '-');
    const modal = document.getElementById('detailModal');
    const backdrop = document.getElementById('drawerBackdrop');
    const panel = document.getElementById('drawerPanel');
    modal.classList.remove('hidden');
    void modal.offsetWidth;
    backdrop.classList.remove('opacity-0');
    backdrop.classList.add('opacity-100');
    panel.classList.remove('translate-x-full');
    panel.classList.add('translate-x-0');
}
function closeDetail() {
    const backdrop = document.getElementById('drawerBackdrop');
    const panel = document.getElementById('drawerPanel');
    backdrop.classList.remove('opacity-100');
    backdrop.classList.add('opacity-0');
    panel.classList.remove('translate-x-0');
    panel.classList.add('translate-x-full');
    setTimeout(() => { document.getElementById('detailModal').classList.add('hidden'); }, 300);
}
</script>

@endsection