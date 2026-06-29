@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <h1 class="text-3xl font-bold text-gray-800">
            {{ $title }}
        </h1>

        <a href="{{ route('admin.wali-siswa.create') }}"
           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            + Tambah Wali Siswa
        </a>

    </div>

    <!-- Search -->
    <div class="bg-white rounded-xl shadow border p-4">
        <form action="{{ route('admin.wali-siswa.index') }}" method="GET" id="searchForm">
            <input
                type="text"
                name="search"
                id="searchInput"
                value="{{ request('search') }}"
                placeholder="Cari NISN, nama siswa, nama wali, atau pekerjaan..."
                class="w-full border rounded-lg px-4 py-2 focus:ring focus:ring-blue-200">
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow border overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-800 text-white">

                    <tr>
                        <th class="px-4 py-3 text-left w-40">Aksi</th>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">NISN</th>
                        <th class="px-4 py-3 text-left">Nama Siswa</th>
                        <th class="px-4 py-3 text-left">Nama Wali</th>
                        <th class="px-4 py-3 text-left">Hubungan</th>
                        <th class="px-4 py-3 text-left">Telepon</th>
                        <th class="px-4 py-3 text-left">Pekerjaan</th>
                    </tr>

                </thead>

                <tbody id="waliTable" class="divide-y divide-gray-100 bg-white">

                    @forelse($waliSiswa as $item)

                        <tr class="hover:bg-gray-50">

                            <!-- Aksi -->
                            <td class="px-4 py-3">

                                <div class="flex items-center gap-2">

                                    <a href="{{ route('admin.wali-siswa.edit', $item->id_wali) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.wali-siswa.destroy', $item->id_wali) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus data ini?')">

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

                            <!-- NISN -->
                            <td class="px-4 py-3">
                                {{ $item->nisn }}
                            </td>

                            <!-- Nama Siswa -->
                            <td class="px-4 py-3 font-medium">
                                {{ $item->siswa->nama_siswa ?? '-' }}
                            </td>

                            <!-- Nama Wali -->
                            <td class="px-4 py-3">
                                {{ $item->nama_wali }}
                            </td>

                            <!-- Hubungan -->
                            <td class="px-4 py-3">
                                {{ $item->hubungan }}
                            </td>

                            <!-- Telepon -->
                            <td class="px-4 py-3">
                                {{ $item->telepon ?? '-' }}
                            </td>

                            <!-- Pekerjaan -->
                            <td class="px-4 py-3">
                                {{ $item->pekerjaan ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-8 text-gray-500">
                                Data wali siswa belum tersedia
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="p-4 border-t">
            {{ $waliSiswa->links() }}
        </div>

    </div>

</div>

<!-- JS SEARCH DEBOUNCE -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    let searchTimeout = null;
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        if (searchInput.value.length > 0 && document.activeElement === searchInput) {
            const len = searchInput.value.length;
            searchInput.setSelectionRange(len, len);
        }
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                document.getElementById('searchForm').submit();
            }, 500);
        });
    }
});
</script>

@endsection