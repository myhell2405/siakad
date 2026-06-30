@extends('admin.layout')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto font-sans pb-16 text-gray-900">

    {{-- HERO HEADER --}}
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-black/10 shadow-xs relative flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
        <div class="flex items-center gap-5 relative z-10">
            <div class="w-16 h-16 rounded-2xl bg-void text-white flex items-center justify-center border border-black shadow-md shrink-0">
                <i class="bi bi-person-vcard text-3xl text-signal"></i>
            </div>
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 rounded-md px-2.5 py-1 text-[10px] uppercase tracking-[0.2em] font-mono font-bold bg-surface text-void border border-black/10 mb-1">
                    <span class="w-2 h-2 rounded-full bg-signal animate-pulse inline-block"></span>
                    <span>LAPORAN SEKOLAH</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-black text-void tracking-tight uppercase">IDENTITAS PESERTA DIDIK</h1>
                <p class="text-xs text-gray-500 font-mono uppercase">
                    PILIH TAHUN AJARAN DAN KELAS UNTUK MENAMPILKAN ATAU MENCETAK LEMBAR IDENTITAS RESMI
                </p>
            </div>
        </div>
    </div>

    {{-- FILTER FORM CARD --}}
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-black/10 shadow-xs">
        <form action="{{ route('admin.laporan.identitas-siswa') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
            <div class="space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">TAHUN AJARAN</label>
                <select name="id_ta" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all uppercase" onchange="this.form.submit()">
                    <option value="">-- PILIH TAHUN AJARAN --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ strtoupper($ta->semester) }}) {{ strtolower($ta->status) == 'aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-mono font-bold uppercase tracking-wider text-void">KELAS TARGET</label>
                <select name="id_kelas" class="w-full bg-gray-50 hover:bg-gray-100/70 border border-black/10 rounded-xl px-4 py-3 text-xs font-mono font-bold text-void focus:bg-white focus:outline-none focus:ring-2 focus:ring-void transition-all disabled:opacity-50 uppercase" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- PILIH KELAS --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ strtoupper($k->kelas->nama_kelas ?? '-') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-void hover:bg-black text-white font-mono font-bold py-3 px-6 rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-xs uppercase">
                    <i class="bi bi-funnel-fill text-signal"></i> FILTER DATA SISWA
                </button>
            </div>
        </form>
    </div>

    {{-- DATA CONTENT SECTION --}}
    @if ($id_kelas)
        <div class="bg-white rounded-3xl border border-black/10 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-black/10 flex justify-between items-center bg-gray-50">
                <h3 class="font-black text-void text-sm uppercase flex items-center gap-2">
                    <i class="bi bi-people-fill text-cobalt text-base"></i> DAFTAR PESERTA DIDIK
                </h3>
                <span class="text-[10px] font-mono font-bold uppercase bg-void text-white px-3 py-1 rounded">TOTAL: {{ $siswaList->count() }} SISWA</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface text-void font-mono text-[10px] uppercase tracking-wider border-b border-black/10">
                            <th class="py-4 pl-6 w-16 text-center">NO</th>
                            <th class="py-4 px-6">NISN</th>
                            <th class="py-4 px-6">NAMA SISWA</th>
                            <th class="py-4 px-6 text-center">L/P</th>
                            <th class="py-4 px-6">NAMA ORANG TUA / WALI</th>
                            <th class="py-4 pr-6 text-center w-44">AKSI CETAK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/5 text-xs font-semibold text-gray-700">
                        @forelse ($siswaList as $index => $sk)
                            <tr class="hover:bg-gray-50/80 transition duration-150">
                                <td class="py-4 pl-6 text-center font-mono font-bold text-gray-400">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-mono font-bold text-gray-600">{{ $sk->siswa->nisn ?? '-' }}</td>
                                <td class="py-4 px-6 font-bold text-void uppercase">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                <td class="py-4 px-6 text-center font-mono font-bold text-gray-600">{{ $sk->siswa->jenis_kelamin ?? '-' }}</td>
                                <td class="py-4 px-6 text-void font-bold uppercase">{{ $sk->siswa->waliSiswa->first()?->nama_wali ?? '-' }} <span class="text-gray-400 font-mono text-[11px]">({{ strtoupper($sk->siswa->waliSiswa->first()?->hubungan ?? '-') }})</span></td>
                                <td class="py-4 pr-6 text-center">
                                    <a href="{{ route('admin.laporan.identitas-siswa', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'id_siswa' => $sk->id_siswa, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-void hover:bg-black text-white rounded-lg text-xs font-mono font-bold transition-all shadow-md active:scale-95 uppercase">
                                        <i class="bi bi-printer-fill text-signal"></i> CETAK LEMBAR
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center text-gray-400 font-mono uppercase">
                                    <i class="bi bi-inbox text-3xl block mb-2 text-gray-300"></i>
                                    BELUM ADA SISWA YANG TERDAFTAR DI KELAS INI.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-3xl border border-black/10 shadow-xs">
            <div class="w-16 h-16 rounded-2xl bg-void text-signal flex items-center justify-center mx-auto mb-4 font-black shadow-md border border-black">
                <i class="bi bi-funnel text-2xl"></i>
            </div>
            <h3 class="text-base font-black text-void uppercase">MENUNGGU PILIHAN FILTER</h3>
            <p class="text-xs text-gray-500 font-mono uppercase mt-1">Silakan pilih Tahun Ajaran dan Kelas di atas terlebih dahulu untuk memunculkan data siswa.</p>
        </div>
    @endif

</div>
@endsection
