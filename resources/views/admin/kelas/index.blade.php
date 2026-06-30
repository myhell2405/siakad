@extends('admin.layout')

@section('content')

<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION (Floating Elevation)
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-8 sm:p-10 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03] transition-all duration-500 hover:shadow-[0_20px_60px_-15px_rgba(0,0,0,0.08)]">
        
        {{-- Background Orb --}}
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-emerald-500/10 via-teal-500/10 to-cyan-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-600 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 shrink-0 transition-transform duration-300 hover:scale-105 hover:rotate-3">
                <i class="bi bi-door-open-fill text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-emerald-50/80 text-emerald-700 ring-1 ring-emerald-500/20 mb-1 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-600"></span>
                    </span>
                    <span>Direktori Rombongan Belajar</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    {{ $title ?? 'Manajemen Kelas' }}
                </h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span><i class="bi bi-building text-emerald-500"></i> SDN 01 Durian Gadang</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span>Total <strong class="text-slate-700">{{ $kelas->count() }}</strong> Kelas Terdaftar</span>
                </p>
            </div>
        </div>

        <a href="{{ route('admin.kelas.create') }}"
           class="group relative z-10 inline-flex items-center gap-4 pl-6 pr-2 py-2 rounded-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 transition-all duration-300 active:scale-[0.98] w-full sm:w-auto justify-between sm:justify-start">
            <span class="tracking-wide">Tambah Kelas Baru</span>
            <div class="w-8 h-8 rounded-full bg-white/20 group-hover:bg-white/30 flex items-center justify-center transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                <i class="bi bi-plus-lg text-sm font-black"></i>
            </div>
        </a>
    </div>

    {{-- ================================================
         TABLE SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.5rem] p-6 sm:p-8 shadow-[0_15px_50px_-15px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="pb-4 pl-4 w-16">No</th>
                        <th class="pb-4">Nama Kelas</th>
                        <th class="pb-4">Tingkat Kelas</th>
                        <th class="pb-4 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80 text-xs font-semibold text-slate-700">
                    @forelse($kelas as $item)
                    <tr class="hover:bg-emerald-50/40 transition-colors group">
                        <td class="py-4 pl-4 font-mono font-bold text-slate-400">{{ $loop->iteration }}</td>
                        <td class="py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-black text-sm shadow-md shrink-0 group-hover:scale-105 transition-transform">
                                    {{ $item->tingkat_kelas }}
                                </div>
                                <span class="font-black text-slate-900 group-hover:text-emerald-600 transition-colors text-base">{{ $item->nama_kelas }}</span>
                            </div>
                        </td>
                        <td class="py-4">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black uppercase bg-emerald-50 text-emerald-700">
                                <i class="bi bi-layers-fill"></i> Tingkat {{ $item->tingkat_kelas }}
                            </span>
                        </td>
                        
                        <td class="py-4 pr-4 text-right">
                            <div class="inline-flex items-center justify-end gap-1.5">
                                <button
                                    onclick="openDetail(this)"
                                    data-nama="{{ $item->nama_kelas }}"
                                    data-tingkat="{{ $item->tingkat_kelas }}"
                                    class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-emerald-600 hover:to-teal-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-emerald-500/20 active:scale-95"
                                    title="Lihat Detail Kelas">
                                    <i class="bi bi-eye-fill text-xs"></i>
                                </button>

                                {{-- EDIT BUTTON --}}
                                <a href="{{ route('admin.kelas.edit', $item->id_kelas) }}"
                                   class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-amber-500 hover:to-orange-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-amber-500/20 active:scale-95"
                                   title="Edit Kelas">
                                    <i class="bi bi-pencil-fill text-xs"></i>
                                </a>

                                {{-- DELETE BUTTON --}}
                                <form action="{{ route('admin.kelas.destroy', $item->id_kelas) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-xl bg-slate-100 hover:bg-gradient-to-r hover:from-rose-600 hover:to-red-600 text-slate-700 hover:text-white flex items-center justify-center transition-all shadow-2xs hover:shadow-md hover:shadow-rose-500/20 active:scale-95" title="Hapus Kelas">
                                        <i class="bi bi-trash3-fill text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-12">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="bi bi-folder2-open text-4xl mb-2"></i>
                                <span class="font-bold text-sm">Belum Ada Data Kelas Terdaftar</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ================================================
     SLIDE-OVER DRAWER DETAIL KELAS (Linear / Stripe Admin Style)
     ================================================ --}}
<div id="detailModal" class="fixed inset-0 z-50 overflow-hidden hidden font-sans">
    {{-- Backdrop --}}
    <div id="drawerBackdrop"
         onclick="closeDetail()"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 transition-opacity duration-300 ease-out"></div>

    <div class="fixed inset-y-0 right-0 pl-10 max-w-full flex">
        {{-- Drawer Panel --}}
        <div id="drawerPanel"
             class="w-screen max-w-md bg-white shadow-2xl flex flex-col translate-x-full transition-transform duration-500 cubic-bezier(0.16,1,0.3,1)">

            {{-- DRAWER HEADER --}}
            <div class="p-6 sm:p-8 bg-slate-900 text-white relative overflow-hidden shrink-0">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-gradient-to-br from-emerald-500/20 to-teal-500/0 rounded-full blur-2xl pointer-events-none"></div>

                <div class="flex items-start justify-between relative z-10">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center font-black text-2xl shadow-lg shadow-emerald-500/30 shrink-0">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                        <div>
                            <div class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[10px] font-black uppercase tracking-widest bg-emerald-500/20 text-emerald-300 ring-1 ring-emerald-500/30 mb-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Rombongan Belajar</span>
                            </div>
                            <h3 id="k_nama" class="text-xl font-black text-white tracking-tight leading-snug">Detail Kelas</h3>
                        </div>
                    </div>
                    <button onclick="closeDetail()"
                            class="w-9 h-9 rounded-xl bg-white/10 hover:bg-rose-500/20 text-slate-300 hover:text-rose-300 flex items-center justify-center transition active:scale-95 text-base">
                        ✕
                    </button>
                </div>
            </div>

            {{-- DRAWER BODY (Scrollable) --}}
            <div class="flex-1 overflow-y-auto p-6 sm:p-8 space-y-6 bg-slate-50/50">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-5 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Nama Kelas</span>
                        <span class="text-lg font-black text-slate-900 mt-1 break-words leading-snug" id="m_nama_kelas">-</span>
                    </div>
                    <div class="bg-white p-5 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex flex-col justify-between">
                        <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Tingkat Kelas</span>
                        <span class="text-lg font-black text-emerald-600 mt-1 break-words leading-snug" id="m_tingkat">-</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-2xl shadow-2xs ring-1 ring-slate-900/[0.03] flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <h5 class="text-xs font-black text-slate-800">Status Kurikulum Merdeka</h5>
                        <p class="text-[11px] text-slate-400 mt-0.5 break-words leading-snug">Kelas aktif terdaftar pada Tahun Ajaran Berjalan.</p>
                    </div>
                </div>
            </div>

            {{-- DRAWER FOOTER --}}
            <div class="p-6 bg-white border-t border-slate-100 flex items-center justify-end shrink-0 shadow-[0_-10px_20px_-10px_rgba(0,0,0,0.02)]">
                <button onclick="closeDetail()"
                        class="px-7 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-full transition shadow-md hover:shadow-lg active:scale-95">
                    Tutup Panel
                </button>
            </div>

        </div>
    </div>
</div>

{{-- MODAL JS --}}
<script>
    function openDetail(btn) {
        const modal = document.getElementById('detailModal');
        const backdrop = document.getElementById('drawerBackdrop');
        const panel = document.getElementById('drawerPanel');

        document.getElementById('k_nama').innerText = btn.dataset.nama || '-';
        document.getElementById('m_nama_kelas').innerText = btn.dataset.nama || '-';
        document.getElementById('m_tingkat').innerText = "Tingkat " + (btn.dataset.tingkat || '-');

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('translate-x-full');
            panel.classList.add('translate-x-0');
        }, 10);
    }

    function closeDetail() {
        const modal = document.getElementById('detailModal');
        const backdrop = document.getElementById('drawerBackdrop');
        const panel = document.getElementById('drawerPanel');

        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('translate-x-0');
        panel.classList.add('translate-x-full');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('detailModal');
            if (!modal.classList.contains('hidden')) {
                closeDetail();
            }
        }
    });
</script>

@endsection