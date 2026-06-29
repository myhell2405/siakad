@extends('admin.layout')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <h1 class="text-3xl font-bold text-gray-800">
            {{ $title }}
        </h1>

        @if($taAktif)
        <form action="{{ route('admin.pembagian-kelas.generate') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membuatkan kelas otomatis untuk semua master kelas yang belum terdaftar di TA ini?');">
            @csrf
            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow transition">
                + Generate Semua Kelas ({{ $masterKelasCount }})
            </button>
        </form>
        @endif

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

    @if(session('info'))
        <div class="bg-blue-100 border border-blue-300 text-blue-700 px-4 py-3 rounded-lg">
            {{ session('info') }}
        </div>
    @endif

    <!-- Status TA Aktif Banner -->
    @if(!$taAktif)
        <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-6 rounded-xl text-center space-y-3">
            <h3 class="text-lg font-bold">Belum Ada Tahun Ajaran Aktif</h3>
            <p class="text-sm">Silakan aktifkan salah satu Tahun Ajaran terlebih dahulu di menu Data Master -> Tahun Ajaran.</p>
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="inline-block mt-2 px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white font-semibold rounded-lg text-sm transition">
                Ke Menu Tahun Ajaran
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow border p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <label class="font-semibold text-gray-700 block">Tahun Ajaran Aktif</label>
                <p class="text-xl font-bold text-gray-900 mt-1">
                    {{ $taAktif->tahun_mulai }}/{{ $taAktif->tahun_selesai }} ({{ ucfirst($taAktif->semester) }})
                </p>
            </div>
            <div class="flex items-center gap-3">
                <span class="inline-flex px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                    Aktif
                </span>
                <span class="inline-flex px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">
                    Total: {{ $kelasTaList->count() }} Kelas
                </span>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow border overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center text-sm font-semibold w-36">
                                Aksi
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold w-16">
                                No
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Nama Kelas
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Tingkat
                            </th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">
                                Wali Kelas
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse($kelasTaList as $idx => $item)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- Aksi -->
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.kelas-ta.detail', $item->id) }}" class="px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-md text-sm">
                                        Atur Anggota
                                    </a>
                                    <form action="{{ route('admin.kelas-ta.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus pembagian kelas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white rounded-md text-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <!-- No -->
                            <td class="px-4 py-3 text-sm">
                                {{ $idx + 1 }}
                            </td>

                            <!-- Nama Kelas -->
                            <td class="px-4 py-3 font-medium text-sm">
                                {{ $item->kelas->nama_kelas ?? '-' }}
                            </td>

                            <!-- Tingkat -->
                            <td class="px-4 py-3 text-sm">
                                Kelas {{ $item->kelas->tingkat_kelas ?? '-' }}
                            </td>

                            <!-- Wali Kelas Inline -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <form action="{{ route('admin.pembagian-kelas.update-wali-kelas', $item->id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="id_wali_kelas" class="border rounded-md px-3 py-1 text-sm bg-white text-gray-700">
                                        @foreach($guruList as $g)
                                        <option value="{{ $g->id }}" {{ $item->id_wali_kelas == $g->id ? 'selected' : '' }}>
                                            {{ $g->nama_lengkap }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm">
                                        Simpan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                Belum ada pembagian kelas untuk Tahun Ajaran ini. Silakan klik tombol "+ Generate Semua Kelas" di atas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

@endsection
