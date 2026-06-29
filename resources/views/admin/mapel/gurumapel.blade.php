@extends('admin.layout')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Daftar Guru Mata Pelajaran
            </h1>

            <p class="text-gray-500 mt-1">
                {{ $mapel->nama_mapel }}
            </p>
        </div>

        <a href="{{ route('admin.mapel.index') }}"
           class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg">
            Kembali
        </a>

    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORM TAMBAH GURU --}}
    <div class="bg-white rounded-xl shadow border p-6">

        <h2 class="text-lg font-semibold mb-4">
            Tambahkan Guru
        </h2>

        <form action="{{ route('admin.mapel.guru.store', $mapel->id_mapel) }}"
              method="POST"
              class="flex gap-3">

            @csrf

            <select name="id_guru" class="flex-1 border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:outline-none text-gray-700" required>
                <option value="">-- Pilih Guru Pengampu --</option>
                @foreach($availableGuru as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_lengkap }} (NIP: {{ $g->nip }})</option>
                @endforeach
            </select>

            <button
                type="submit"
                class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg">
                Tambahkan Guru
            </button>

        </form>

    </div>

    {{-- TABEL GURU --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-800 text-white">

                    <tr>
                        <th class="px-4 py-3 text-left w-16">No</th>
                        <th class="px-4 py-3 text-left">Nama Guru</th>
                        <th class="px-4 py-3 text-left">NIP</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-center w-32">Aksi</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($guruMapel as $guru)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3 text-sm">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $guru->nama_lengkap }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $guru->nip }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $guru->jabatan_guru ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-center">

                                <form action="{{ route('admin.mapel.guru.destroy', [$mapel->id_mapel, $guru->id]) }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus guru dari mata pelajaran ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                Belum ada guru yang terdaftar pada mata pelajaran ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection