@extends('admin.layout')

@section('content')
<div class="space-y-10 font-sans text-slate-800 pb-16">

    {{-- ================================================
         HERO HEADER SECTION
         ================================================ --}}
    <div class="bg-white rounded-[2.2rem] p-8 sm:p-10 shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] relative overflow-hidden flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 ring-1 ring-slate-900/[0.03]">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-gradient-to-br from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-600 text-white flex items-center justify-center shadow-lg shadow-blue-500/25 shrink-0">
                <i class="bi bi-person-vcard text-3xl"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-[10px] uppercase tracking-[0.15em] font-black bg-blue-50 text-blue-700 ring-1 ring-blue-500/20 shadow-2xs">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                    </span>
                    <span>Laporan Sekolah</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">Identitas Peserta Didik</h1>
                <p class="text-xs text-slate-400 font-bold flex items-center gap-2 pt-0.5">
                    <span>Pilih Tahun Ajaran dan Kelas untuk menampilkan atau mencetak lembar identitas</span>
                </p>
            </div>
        </div>
    </div>

    {{-- ================================================
         FILTER FORM CARD
         ================================================ --}}
    <div class="bg-white rounded-3xl p-6 shadow-[0_10px_35px_-10px_rgba(0,0,0,0.05)] ring-1 ring-slate-900/[0.03]">
        <form action="{{ route('admin.laporan.identitas-siswa') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Tahun Ajaran</label>
                <select name="id_ta" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ ucfirst($ta->semester) }}) {{ $ta->status == 'Aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-black uppercase tracking-wider text-slate-500">Kelas Target</label>
                <select name="id_kelas" class="w-full bg-slate-50 hover:bg-slate-100/70 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs font-bold text-slate-800 focus:bg-white focus:outline-none focus:ring-4 focus:ring-blue-500/15 focus:border-blue-600 transition-all shadow-inner disabled:opacity-50 disabled:cursor-not-allowed" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ $k->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg shadow-blue-500/25 transition-all flex items-center justify-center gap-2 text-xs active:scale-[0.98]">
                    <i class="bi bi-funnel-fill"></i> Filter Data Siswa
                </button>
            </div>
        </form>
    </div>

    {{-- ================================================
         DATA CONTENT SECTION
         ================================================ --}}
    @if ($id_kelas)
        <div class="bg-white rounded-3xl shadow-[0_12px_45px_-10px_rgba(0,0,0,0.06)] ring-1 ring-slate-900/[0.03] overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/60">
                <h3 class="font-black text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
                    <i class="bi bi-people-fill text-blue-600"></i> Daftar Peserta Didik
                </h3>
                <span class="text-[11px] bg-blue-50 text-blue-700 px-3 py-1 rounded-full font-black ring-1 ring-blue-500/20">Total: {{ $siswaList->count() }} Siswa</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-400 text-[10px] font-black uppercase tracking-widest border-b border-slate-100">
                            <th class="py-4 px-6 w-16 text-center">No</th>
                            <th class="py-4 px-6">NISN</th>
                            <th class="py-4 px-6">Nama Siswa</th>
                            <th class="py-4 px-6 text-center">L/P</th>
                            <th class="py-4 px-6">Nama Orang Tua / Wali</th>
                            <th class="py-4 px-6 text-center w-40">Aksi Cetak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-semibold">
                        @forelse ($siswaList as $index => $sk)
                            <tr class="hover:bg-slate-50/80 transition duration-150">
                                <td class="py-4 px-6 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-mono text-slate-500 font-bold">{{ $sk->siswa->nisn ?? '-' }}</td>
                                <td class="py-4 px-6 font-extrabold text-slate-900">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                <td class="py-4 px-6 text-center font-bold text-slate-600">{{ $sk->siswa->jenis_kelamin ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-700 font-bold">{{ $sk->siswa->waliSiswa->first()?->nama_wali ?? '-' }} <span class="text-slate-400 font-medium">({{ $sk->siswa->waliSiswa->first()?->hubungan ?? '-' }})</span></td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('admin.laporan.identitas-siswa', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'id_siswa' => $sk->id_siswa, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-500/20 active:scale-95">
                                        <i class="bi bi-printer-fill"></i> Cetak Lembar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-slate-400 font-medium">
                                    <i class="bi bi-inbox text-3xl block mb-2 text-slate-300"></i>
                                    Belum ada siswa yang terdaftar di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl ring-1 ring-slate-900/[0.03] shadow-[0_10px_35px_-10px_rgba(0,0,0,0.04)]">
            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 font-black shadow-inner">
                <i class="bi bi-funnel text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-slate-800">Menunggu Pilihan Filter</h3>
            <p class="text-xs text-slate-400 font-semibold mt-1">Silakan pilih Tahun Ajaran dan Kelas di atas terlebih dahulu untuk memunculkan data siswa.</p>
        </div>
    @endif

</div>
@endsection
