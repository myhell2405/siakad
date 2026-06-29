@extends('admin.layout')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Identitas Guru Kelas</h1>
        <p class="text-sm text-gray-600 mt-1">Pilih Tahun Ajaran dan Kelas untuk melihat profil guru kelas (wali kelas) yang bertugas.</p>
    </div>

    <!-- Filter Form -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
        <form action="{{ route('admin.laporan.identitas-guru') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
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
                            {{ $k->kelas->nama_kelas ?? '-' }} (Wali: {{ $k->waliKelas->nama_lengkap ?? '-' }})
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

    @if ($selectedKelas)
        @php
            $g = $selectedKelas->waliKelas;
        @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl mx-auto">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="font-bold text-gray-800 text-lg">Pratinjau Data Guru Kelas</h3>
                    <p class="text-xs text-gray-500">Kelas: {{ $selectedKelas->kelas->nama_kelas ?? '-' }} | TA: {{ $selectedKelas->tahunAjaran->tahun_ajaran ?? '-' }}</p>
                </div>
                @if ($g)
                    <a href="{{ route('admin.laporan.identitas-guru', ['id_ta' => $id_ta, 'id_kelas' => $id_kelas, 'print' => 1]) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition-colors shadow">
                        <i class="bi bi-printer-fill"></i> Cetak Lembar Resmi
                    </a>
                @endif
            </div>

            <div class="p-8">
                @if ($g)
                    <div class="space-y-4 text-gray-700">
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">Nama Lengkap</span>
                            <span class="col-span-2 font-bold text-gray-900 uppercase">{{ $g->nama_lengkap }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">NIP</span>
                            <span class="col-span-2 font-mono">{{ $g->nip ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">NUPTK</span>
                            <span class="col-span-2 font-mono">{{ $g->nuptk ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">Tempat, Tgl Lahir</span>
                            <span class="col-span-2">{{ $g->tempat_lahir ?? '-' }}, {{ $g->tanggal_lahir ? \Carbon\Carbon::parse($g->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">Pendidikan Terakhir</span>
                            <span class="col-span-2">{{ $g->pendidikan_terakhir ?? 'S1. PGSD' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">Jabatan Guru</span>
                            <span class="col-span-2">Guru Kelas</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4 border-b pb-3">
                            <span class="font-semibold text-gray-600">Pangkat / Gol</span>
                            <span class="col-span-2">{{ $g->pangkat_gol ?? 'Ahli Pertama, IX' }}</span>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <span class="font-semibold text-gray-600">Tugas Mengajar Kls</span>
                            <span class="col-span-2 font-bold">{{ $selectedKelas->kelas->nama_kelas ?? '-' }}</span>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-yellow-600">
                        <i class="bi bi-exclamation-triangle text-3xl mb-2 block"></i>
                        Belum ada Guru yang ditugaskan sebagai Wali Kelas untuk kelas ini. Silakan atur di menu Pembagian Kelas Aktif.
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-dashed border-gray-300">
            <i class="bi bi-person-badge text-4xl text-blue-400 mb-3 block"></i>
            <p class="text-gray-600 font-medium">Silakan pilih Tahun Ajaran dan Kelas di atas untuk melihat identitas guru kelas.</p>
        </div>
    @endif
@endsection
