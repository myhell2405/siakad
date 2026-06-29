@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <h1 class="text-3xl font-bold text-gray-800">
            {{ $title }}
        </h1>

        <a href="{{ route('admin.tahun-ajaran.create') }}"
           class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">

            + Tambah Tahun Ajaran

        </a>

    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-800 text-white">

                    <tr>

                        <th class="px-4 py-3 text-center text-sm font-semibold w-28">
                            Aksi
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            No
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Tahun Ajaran
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Semester
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Created At
                        </th>

                        <th class="px-4 py-3 text-left text-sm font-semibold">
                            Updated At
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse($tahunAjaran as $ta)

                        <tr class="hover:bg-gray-50 transition">

                            <!-- Aksi -->
                            <td class="px-4 py-3 whitespace-nowrap">

                                <div class="flex items-center justify-center gap-2">

                                    <a href="{{ route('admin.tahun-ajaran.edit', $ta->id_tahun_ajaran) }}"
                                       class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm">
                                        Edit
                                    </a>
                                
                                    <form action="{{ route('admin.tahun-ajaran.destroy', $ta->id_tahun_ajaran) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus tahun ajaran ini?')">
                                
                                        @csrf
                                        @method('DELETE')
                                
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm">
                                            Hapus
                                        </button>
                                
                                    </form>
                                
                                </div>

                            </td>

                            <!-- No -->
                            <td class="px-4 py-3">
                                {{ $tahunAjaran->firstItem() + $loop->index }}
                            </td>

                            <!-- Tahun -->
                            <td class="px-4 py-3 font-medium">
                                {{ $ta->tahun_mulai }}/{{ $ta->tahun_selesai }}
                            </td>

                            <!-- Semester -->
                            <td class="px-4 py-3 capitalize">
                                {{ $ta->semester }}
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3">

                                @if($ta->status == 'aktif')
                                    <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">
                                        Tidak Aktif
                                    </span>
                                @endif

                            </td>

                            <!-- Created -->
                            <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                {{ $ta->created_at }}
                            </td>

                            <!-- Updated -->
                            <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">
                                {{ $ta->updated_at }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="text-center py-8 text-gray-500">
                                Data tahun ajaran belum tersedia.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="p-4 border-t">
            {{ $tahunAjaran->links() }}
        </div>

    </div>

</div>

@endsection