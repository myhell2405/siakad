@extends('admin.layout')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Akademik Kepala Sekolah</h1>
            <p class="text-sm text-gray-600 mt-1">Rekap nilai akademik per kelas, statistik kenaikan kelas, dan peringkat siswa terbaik.</p>
        </div>
        @if ($id_ta)
            <a href="{{ route('admin.laporan.monitoring', ['id_ta' => $id_ta, 'print' => 1]) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold shadow transition-colors inline-flex items-center gap-2">
                <i class="bi bi-printer-fill"></i> Cetak Laporan Rekap
            </a>
        @endif
    </div>

    <!-- Filter Form -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
        <form action="{{ route('admin.laporan.monitoring') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tahun Ajaran</label>
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
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors flex items-center gap-2">
                    <i class="bi bi-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>

    @if ($id_ta && $rekapKelas->count() > 0)
        <!-- Tabel 1: Rekap Nilai Per Kelas -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                <h3 class="font-bold text-gray-800">REKAP NILAI PER KELAS</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-100/70 text-gray-600 uppercase text-xs font-semibold">
                            <th class="py-3 px-6 text-left w-16">No</th>
                            <th class="py-3 px-6 text-left">Kelas</th>
                            <th class="py-3 px-6 text-left">Wali Kelas</th>
                            <th class="py-3 px-6 text-center">Jumlah Siswa</th>
                            <th class="py-3 px-6 text-center">Nilai Rata-rata</th>
                            <th class="py-3 px-6 text-center text-green-600">Tertinggi</th>
                            <th class="py-3 px-6 text-center text-red-600">Terendah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @foreach ($rekapKelas as $idx => $rk)
                            <tr class="hover:bg-blue-50/30">
                                <td class="py-4 px-6">{{ $idx + 1 }}</td>
                                <td class="py-4 px-6 font-bold text-gray-800">{{ $rk['nama_kelas'] }}</td>
                                <td class="py-4 px-6">{{ $rk['wali_kelas'] }}</td>
                                <td class="py-4 px-6 text-center font-medium">{{ $rk['jumlah_siswa'] }} Siswa</td>
                                <td class="py-4 px-6 text-center font-bold text-blue-600">{{ $rk['rata_rata'] }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-green-600">{{ $rk['tertinggi'] }}</td>
                                <td class="py-4 px-6 text-center font-semibold text-red-600">{{ $rk['terendah'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Tabel 2: Data Kenaikan Kelas -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-800">DATA KENAIKAN KELAS</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100/70 text-gray-600 uppercase text-xs font-semibold">
                                <th class="py-3 px-4 text-left w-12">No</th>
                                <th class="py-3 px-4 text-left">Kelas</th>
                                <th class="py-3 px-4 text-center">Jml Siswa</th>
                                <th class="py-3 px-4 text-center text-green-600">Naik / Lulus</th>
                                <th class="py-3 px-4 text-center text-red-600">Tidak Naik</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @foreach ($rekapKelas as $idx => $rk)
                                <tr class="hover:bg-blue-50/30">
                                    <td class="py-3 px-4">{{ $idx + 1 }}</td>
                                    <td class="py-3 px-4 font-bold">{{ $rk['nama_kelas'] }}</td>
                                    <td class="py-3 px-4 text-center">{{ $rk['jumlah_siswa'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-green-600">{{ $rk['naik_kelas'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-red-600">{{ $rk['tidak_naik'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabel 3: Peringkat Siswa Terbaik -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800">PERINGKAT SISWA TERBAIK</h3>
                    <span class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded font-semibold">Top 5 Sekolah</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-100/70 text-gray-600 uppercase text-xs font-semibold">
                                <th class="py-3 px-4 text-left w-12">No</th>
                                <th class="py-3 px-4 text-left">Nama Siswa</th>
                                <th class="py-3 px-4 text-center">Kelas</th>
                                <th class="py-3 px-4 text-center">Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-gray-700">
                            @forelse ($topSiswa as $idx => $ts)
                                <tr class="hover:bg-blue-50/30">
                                    <td class="py-3 px-4 font-bold text-amber-600">#{{ $idx + 1 }}</td>
                                    <td class="py-3 px-4 font-bold uppercase text-gray-800">{{ $ts['siswa']->nama_siswa ?? '-' }}</td>
                                    <td class="py-3 px-4 text-center font-medium">{{ $ts['kelas_nama'] }}</td>
                                    <td class="py-3 px-4 text-center font-bold text-blue-600">{{ $ts['rata_rata'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-500">Belum ada data nilai.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <i class="bi bi-bar-chart-line text-4xl text-blue-400 mb-3 block"></i>
            <p class="text-gray-600 font-medium">Silakan pilih Tahun Ajaran untuk melihat rekap monitoring akademik.</p>
        </div>
    @endif
@endsection
