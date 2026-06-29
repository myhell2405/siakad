@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $title }}
        </h1>

        <a href="{{ route('admin.kelas.create') }}"
           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            + Tambah Kelas
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left w-40">Aksi</th>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Kelas</th>
                        <th class="px-4 py-3 text-left">Tingkat</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($kelas as $item)

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">

                                    <a href="{{ route('admin.kelas.edit', $item->id_kelas) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.kelas.destroy', $item->id_kelas) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $item->nama_kelas }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->tingkat_kelas }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-8 text-gray-500">
                                Data kelas belum tersedia
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>
    </div>

</div>

@endsection