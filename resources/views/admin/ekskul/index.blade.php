@extends('admin.layout')

@section('content')

<div class="space-y-6">


<div class="flex items-center justify-between">

    <h1 class="text-3xl font-bold text-gray-800">
        {{ $title }}
    </h1>

    <a href="{{ route('admin.ekskul.create') }}"
       class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">

        + Tambah Ekskul

    </a>

</div>

<div class="bg-white rounded-xl shadow border overflow-hidden">

    <div class="overflow-x-auto">

        <table class="min-w-full divide-y divide-gray-200">

            <thead class="bg-gray-800 text-white">

                <tr>
                    <th class="px-4 py-3 text-center w-40">Aksi</th>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Ekskul</th>
                    <th class="px-4 py-3 text-left">Guru Pembina</th>
                    <th class="px-4 py-3 text-left">Keterangan</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-100 bg-white">

                @forelse($ekskul as $item)

                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3">

                            <div class="flex items-center gap-2">

                                <a href="{{ route('admin.ekskul.edit', $item->id_ekskul) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">

                                    Edit

                                </a>

                                <form action="{{ route('admin.ekskul.destroy', $item->id_ekskul) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus data ekskul ini?')">

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
                            {{ $item->nama_ekskul }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->guru->nama_lengkap ?? '-' }}
                        </td>

                        <td class="px-4 py-3">
                            {{ $item->keterangan ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-8 text-gray-500">

                            Data ekskul belum tersedia

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>


</div>

@endsection
