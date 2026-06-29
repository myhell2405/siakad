@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <h1 class="text-3xl font-bold text-gray-800">
            {{ $title }}
        </h1>

        <a href="{{ route('admin.mapel.create') }}"
           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">

            + Tambah Mapel

        </a>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-800 text-white">

                    <tr>
                        <th class="px-4 py-3 text-center w-32">Aksi</th>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama Mapel</th>
                        <th class="px-4 py-3 text-left">KKM</th>

                        <!-- KOLOM BARU -->
                        <th class="px-4 py-3 text-center">Guru</th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($mapel as $item)

                        <tr class="hover:bg-gray-50">

                            <!-- Aksi -->
                            <td class="px-4 py-3">

                                <div class="flex items-center gap-2">

                                    <a href="{{ route('admin.mapel.edit', $item->id_mapel) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.mapel.destroy', $item->id_mapel) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus mapel ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>

                                    </form>

                                </div>

                            </td>

                            <!-- No -->
                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <!-- Nama Mapel -->
                            <td class="px-4 py-3 font-medium">
                                {{ $item->nama_mapel }}
                            </td>

                            <!-- KKM -->
                            <td class="px-4 py-3">
                                {{ $item->kkm }}
                            </td>

                            <!-- GURU DETAIL -->
                            <td class="px-4 py-3 text-center">

                                <a href="{{ route('admin.mapel.guru.index', $item->id_mapel) }}"
                                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm">

                                    Detail Guru

                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                Data mapel belum tersedia
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection