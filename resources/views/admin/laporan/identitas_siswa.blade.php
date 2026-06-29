@extends('admin.layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Identitas Peserta Didik</h1>
        <p class="text-sm text-gray-600 mt-1">Pilih Tahun Ajaran dan Kelas untuk menampilkan atau mencetak lembar identitas peserta didik.</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
        <form action="{{ route('admin.laporan.identitas-siswa') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tahun Ajaran</label>
                <select name="id_ta" class="w-full border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700" onchange="this.form.submit()">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    @foreach ($tahunAjaranList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $id_ta == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} ({{ ucfirst($ta->semester) }}) {{ $ta->status == 'Aktif' ? '- AKTIF' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kelas</label>
                <select name="id_kelas" class="w-full border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700" onchange="this.form.submit()" {{ !$id_ta ? 'disabled' : '' }}>
                    <option value="">-- Pilih Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ $id_kelas == $k->id ? 'selected' : '' }}>
                            {{ $k->kelas->nama_kelas ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                    <i class="bi bi-filter"></i> Filter Data
                </button>
            </div>
        </form>
    </div>

    @if ($id_kelas)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-gray-800">Daftar Peserta Didik (Total: {{ $siswaList->count() }} siswa)</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100/70 text-gray-600 uppercase text-xs font-semibold">
                            <th class="py-3 px-6 text-left w-16">No</th>
                            <th class="py-3 px-6 text-left">NISN</th>
                            <th class="py-3 px-6 text-left">Nama Siswa</th>
                            <th class="py-3 px-6 text-left">L/P</th>
                            <th class="py-3 px-6 text-left">Nama Orang Tua/Wali</th>
                            <th class="py-3 px-6 text-center w-36">Aksi Cetak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse ($siswaList as $index => $sk)
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <td class="py-4 px-6">{{ $index + 1 }}</td>
                                <td class="py-4 px-6 font-mono text-gray-600">{{ $sk->siswa->nisn ?? '-' }}</td>
                                <td class="py-4 px-6 font-semibold text-gray-800">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                <td class="py-4 px-6">{{ $sk->siswa->jenis_kelamin ?? '-' }}</td>
                                <td class="py-4 px-6">{{ $sk->siswa->waliSiswa->first()?->nama_wali ?? '-' }} ({{ $sk->siswa->waliSiswa->first()?->hubungan ?? '-' }})</td>
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('admin.laporan.identitas-siswa', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'id_siswa' => $sk->id_siswa, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-medium transition-colors shadow-sm">
                                        <i class="bi bi-printer-fill"></i> Cetak Lembar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-500">
                                    Belum ada siswa yang terdaftar di kelas ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <i class="bi bi-arrow-up-circle text-4xl text-blue-400 mb-3 block"></i>
            <p class="text-gray-600 font-medium">Silakan pilih Tahun Ajaran dan Kelas di atas terlebih dahulu.</p>
        </div>
    @endif
@endsection
