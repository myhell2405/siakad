@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $kelasTa->kelas->nama_kelas }}
        </h1>

        <a href="{{ route('admin.pembagian-kelas.index') }}"
           class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
            Kembali
        </a>
    </div>

    <!-- Informasi -->
    <div class="bg-white rounded-xl shadow border p-6">
        <div class="grid md:grid-cols-3 gap-6">

            <div>
                <label class="font-semibold text-gray-700">Tahun Ajaran</label>
                <p>
                    {{ $kelasTa->tahunAjaran->tahun_mulai }} /
                    {{ $kelasTa->tahunAjaran->tahun_selesai }}
                    ({{ $kelasTa->tahunAjaran->semester }})
                </p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Wali Kelas</label>
                <p>{{ $kelasTa->waliKelas->nama_lengkap }}</p>
            </div>

        </div>
    </div>

    <!-- Siswa Kelas -->
    <div class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-semibold mb-4">
            Siswa Kelas
        </h2>

        <form action="{{ route('admin.kelas-ta.siswa.store', $kelasTa->id) }}"
              method="POST"
              class="flex gap-3 mb-6">

            @csrf

            <select name="id_siswa"
                    class="w-full border rounded-lg px-4 py-2 bg-white"
                    required>
                <option value="">-- Pilih Siswa Belum Dapat Kelas --</option>
                @foreach($unassignedSiswa as $s)
                    <option value="{{ $s->id }}">
                        {{ $s->nama_siswa }} (NISN: {{ $s->nisn ?? '-' }})
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg">
                Tambah
            </button>

        </form>

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NISN</th>
                    <th class="px-4 py-3">Jenis Kelamin</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($siswaKelas as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->siswa->id }}</td>
                        <td class="px-4 py-3">{{ $item->siswa->nama_siswa }}</td>
                        <td class="px-4 py-3">{{ $item->siswa->nisn }}</td>
                        <td class="px-4 py-3">{{ $item->siswa->jenis_kelamin }}</td>
                        <td class="px-4 py-3 text-center">

                            <form action="{{ route('admin.kelas-ta.siswa.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus?')">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>

                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="text-center py-6 text-gray-500">
                            Belum ada siswa
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <!-- Guru Kelas -->
    <div class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-xl font-semibold mb-4">
            Guru Kelas
        </h2>

        <form action="{{ route('admin.kelas-ta.guru.store', $kelasTa->id) }}"
              method="POST"
              class="flex gap-3 mb-6">

            @csrf

            <select name="id_guru"
                    class="w-full border rounded-lg px-4 py-2 bg-white"
                    required>
                <option value="">-- Pilih Guru Mengajar --</option>
                @foreach($availableGuru as $g)
                    <option value="{{ $g->id }}">
                        {{ $g->nama_lengkap }} (NIP: {{ $g->nip ?? '-' }})
                    </option>
                @endforeach
            </select>

            <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white px-5 py-2 rounded-lg">
                Tambah
            </button>

        </form>

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Jenis Kelamin</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($guruKelas as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->guru->id }}</td>
                        <td class="px-4 py-3">{{ $item->guru->nama_lengkap }}</td>
                        <td class="px-4 py-3">{{ $item->guru->nip }}</td>
                        <td class="px-4 py-3">{{ $item->guru->jenis_kelamin }}</td>
                        <td class="px-4 py-3 text-center">

                            <form action="{{ route('admin.kelas-ta.guru.destroy', $item->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin hapus?')">

                                @csrf
                                @method('DELETE')

                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Hapus
                                </button>

                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="text-center py-6 text-gray-500">
                            Belum ada guru
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection