@extends('admin.layout')

@section('content')
<div class="space-y-6">

    @if(strtolower(session('role')) === 'siswa')
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Transkrip Nilai Saya</h1>
                <p class="text-sm text-gray-500 mt-1">Daftar lengkap nilai tugas, ujian tengah semester, dan ujian akhir di seluruh mata pelajaran.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mt-6">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-800">Transkrip Nilai Akademik</h2>
                <span class="text-xs bg-blue-50 text-blue-600 px-3 py-1 rounded-full font-semibold border border-blue-100">Total: {{ $nilaisSiswa->count() }} Mapel</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold border-b border-gray-200">
                            <th class="py-4 px-6">Mata Pelajaran</th>
                            <th class="py-4 px-6 text-center">KKM</th>
                            <th class="py-4 px-6 text-center">Tugas</th>
                            <th class="py-4 px-6 text-center">UTS</th>
                            <th class="py-4 px-6 text-center">UAS</th>
                            <th class="py-4 px-6 text-center">Nilai Akhir</th>
                            <th class="py-4 px-6">Catatan Guru</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($nilaisSiswa as $n)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="py-4 px-6 font-semibold text-gray-800">{{ $n->mapel->nama_mapel ?? '-' }}</td>
                            <td class="py-4 px-6 text-center text-gray-400 font-semibold">{{ $n->mapel->kkm ?? 75 }}</td>
                            <td class="py-4 px-6 text-center text-gray-600">{{ $n->nilai_tugas ?? '-' }}</td>
                            <td class="py-4 px-6 text-center text-gray-600">{{ $n->nilai_uts ?? '-' }}</td>
                            <td class="py-4 px-6 text-center text-gray-600">{{ $n->nilai_uas ?? '-' }}</td>
                            <td class="py-4 px-6 text-center font-extrabold text-blue-600 text-base">{{ $n->nilai_akhir ?? '-' }}</td>
                            <td class="py-4 px-6 text-gray-500 text-xs italic">"{{ $n->catatan_guru ?? 'Tetap semangat belajar.' }}"</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-400">
                                Belum ada entri nilai yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Kelola Nilai Siswa
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Pilih Tahun Ajaran, Kelas, dan Mata Pelajaran untuk mengisi atau mengubah nilai siswa.
                </p>
            </div>
        </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filter Form -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
        <form method="GET" action="{{ route('admin.nilai.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            
            <!-- Pilih Tahun Ajaran -->
            <div class="md:col-span-3 min-w-0">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Tahun Ajaran</label>
                <select name="id_tahun_ajaran" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700 text-sm">
                    @foreach($taList as $ta)
                        <option value="{{ $ta->id_tahun_ajaran }}" {{ $selectedTaId == $ta->id_tahun_ajaran ? 'selected' : '' }}>
                            {{ $ta->tahun_ajaran }} {{ $ta->semester ? '('.$ta->semester.')' : '' }} {{ $ta->status == 'aktif' ? '[Aktif]' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Kelas -->
            <div class="md:col-span-3 min-w-0">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Kelas</label>
                <select name="id_kelas_ta" required onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700 text-sm">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($kelasTaList as $kta)
                        <option value="{{ $kta->id }}" {{ $selectedKelasTaId == $kta->id ? 'selected' : '' }}>
                            {{ $kta->kelas->nama_kelas ?? '-' }} (Wali: {{ $kta->waliKelas->nama_lengkap ?? 'Belum ada' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Mapel -->
            <div class="md:col-span-3 min-w-0">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Mata Pelajaran</label>
                <select name="id_mapel" onchange="this.form.submit()" class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700 text-sm">
                    <option value="">-- Semua Mata Pelajaran --</option>
                    @foreach($mapelList as $mapel)
                        <option value="{{ $mapel->id_mapel }}" {{ $selectedMapelId == $mapel->id_mapel ? 'selected' : '' }}>
                            {{ $mapel->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="md:col-span-3">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg shadow transition flex items-center justify-center gap-2 text-sm">
                    <i class="bi bi-search"></i> Tampilkan Siswa
                </button>
            </div>

        </form>
    </div>

    <!-- Tabel Input Nilai -->
    @if($selectedKelasTaId && isset($activeMapels) && $activeMapels->isNotEmpty())
        <div class="space-y-8">
            @foreach($activeMapels as $mapelItem)
                @php
                    $mapelId = $mapelItem->id_mapel;
                    $existingNilaiForMapel = $allExistingNilai->where('id_mapel', $mapelId)->keyBy('siswa_id');
                @endphp
                <div class="bg-white rounded-xl shadow border overflow-hidden">
                    <div class="p-6 border-b bg-gray-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">
                                Input Nilai: {{ $mapelItem->nama_mapel ?? '-' }}
                            </h2>
                            <p class="text-sm text-gray-500">
                                Kelas: {{ $selectedKelasTa->kelas->nama_kelas ?? '-' }} | Total Siswa: {{ $siswaKelasList->count() }}
                            </p>
                        </div>
                        <div class="text-xs text-gray-500 bg-white px-3 py-1.5 rounded border">
                            💡 Nilai Akhir dihitung otomatis rata-rata dari Tugas, UTS, dan UAS.
                        </div>
                    </div>

                    @if($siswaKelasList->isEmpty())
                        <div class="p-12 text-center text-gray-500">
                            Belum ada siswa yang terdaftar di kelas ini pada tahun ajaran terpilih.
                        </div>
                    @else
                        <form method="POST" action="{{ route('admin.nilai.store') }}">
                            @csrf
                            <input type="hidden" name="id_kelas_ta" value="{{ $selectedKelasTaId }}">
                            <input type="hidden" name="id_mapel" value="{{ $mapelId }}">

                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="bg-gray-100 text-gray-600 text-xs uppercase tracking-wider font-semibold border-b">
                                            <th class="py-3 px-4 w-12 text-center">No</th>
                                            <th class="py-3 px-4 w-28">NISN</th>
                                            <th class="py-3 px-4">Nama Siswa</th>
                                            <th class="py-3 px-4 w-24 text-center">Tugas</th>
                                            <th class="py-3 px-4 w-24 text-center">UTS</th>
                                            <th class="py-3 px-4 w-24 text-center">UAS</th>
                                            <th class="py-3 px-4 w-24 text-center">Akhir</th>
                                            <th class="py-3 px-4">Catatan Guru</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 text-sm">
                                        @foreach($siswaKelasList as $index => $sk)
                                            @php
                                                $siswaId = $sk->id_siswa;
                                                $nilai = $existingNilaiForMapel->get($siswaId);
                                            @endphp
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="py-3 px-4 text-center font-medium text-gray-500">{{ $index + 1 }}</td>
                                                <td class="py-3 px-4 text-gray-600">{{ $sk->siswa->nisn ?? '-' }}</td>
                                                <td class="py-3 px-4 font-semibold text-gray-800">{{ $sk->siswa->nama_siswa ?? '-' }}</td>
                                                
                                                <!-- Nilai Tugas -->
                                                <td class="py-3 px-2 text-center">
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                           name="nilais[{{ $siswaId }}][tugas]" 
                                                           value="{{ $nilai ? $nilai->nilai_tugas : '' }}" 
                                                           placeholder="0"
                                                           class="w-20 text-center rounded border border-gray-300 px-2 py-1 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white">
                                                </td>

                                                <!-- Nilai UTS -->
                                                <td class="py-3 px-2 text-center">
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                           name="nilais[{{ $siswaId }}][uts]" 
                                                           value="{{ $nilai ? $nilai->nilai_uts : '' }}" 
                                                           placeholder="0"
                                                           class="w-20 text-center rounded border border-gray-300 px-2 py-1 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white">
                                                </td>

                                                <!-- Nilai UAS -->
                                                <td class="py-3 px-2 text-center">
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                           name="nilais[{{ $siswaId }}][uas]" 
                                                           value="{{ $nilai ? $nilai->nilai_uas : '' }}" 
                                                           placeholder="0"
                                                           class="w-20 text-center rounded border border-gray-300 px-2 py-1 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white">
                                                </td>

                                                <!-- Nilai Akhir (Live / Saved) -->
                                                <td class="py-3 px-4 text-center font-bold text-blue-600 bg-blue-50/50">
                                                    {{ $nilai && $nilai->nilai_akhir !== null ? $nilai->nilai_akhir : '-' }}
                                                </td>

                                                <!-- Catatan Guru -->
                                                <td class="py-3 px-4">
                                                    <input type="text" 
                                                           name="nilais[{{ $siswaId }}][catatan]" 
                                                           value="{{ $nilai ? $nilai->catatan_guru : '' }}" 
                                                           placeholder="Catatan perkembangan siswa..."
                                                           class="w-full rounded border border-gray-300 px-3 py-1 shadow-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm bg-white">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="p-6 bg-gray-50 border-t flex justify-end">
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg shadow transition flex items-center gap-2">
                                    <span>Simpan Nilai {{ $mapelItem->nama_mapel }}</span>
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
    @endif

</div>
@endsection
