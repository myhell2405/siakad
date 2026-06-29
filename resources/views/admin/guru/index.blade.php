@extends('admin.layout')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $title }}
        </h1>

        <a href="{{ route('admin.guru.create') }}"
           class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow">
            + Tambah Guru
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- SEARCH --}}
    <div class="bg-white rounded-xl shadow border p-5">
        <form action="{{ route('admin.guru.index') }}" method="GET" id="searchForm">
            <input
                id="searchInput"
                name="search"
                type="text"
                value="{{ request('search') }}"
                placeholder="Cari nama, NIP, atau NUPTK..."
                class="w-full border rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500">
        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow border overflow-hidden">
        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">NIP</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">JK</th>
                        <th class="px-4 py-3 text-left">Pendidikan</th>
                        <th class="px-4 py-3 text-left">Jabatan</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                @forelse($guru as $g)

                    <tr class="hover:bg-gray-50">

                        <td class="px-4 py-3">
                            {{ ($guru->currentPage() - 1) * $guru->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">{{ $g->nip }}</td>

                        <td class="px-4 py-3 font-semibold">{{ $g->nama_lengkap }}</td>

                        <td class="px-4 py-3">
                            {{ $g->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </td>

                        <td class="px-4 py-3">{{ $g->pendidikan_terakhir }}</td>

                        <td class="px-4 py-3">{{ $g->jabatan_guru }}</td>

                        <td class="px-4 py-3">
                            @if($g->status == "Aktif")
                                <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs">Aktif</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs">Tidak Aktif</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center space-x-2">

                            {{-- DETAIL --}}
                            <button
                                onclick='openDetail({
                                            nip: "{{ $g->nip }}",
                                            nuptk: "{{ $g->nuptk }}",
                                            nama_lengkap: "{{ $g->nama_lengkap }}",
                                            tempat_lahir: "{{ $g->tempat_lahir }}",
                                            tanggal_lahir: "{{ $g->tanggal_lahir }}",
                                            jenis_kelamin: "{{ $g->jenis_kelamin }}",
                                            pendidikan_terakhir: "{{ $g->pendidikan_terakhir }}",
                                            jabatan_guru: "{{ $g->jabatan_guru }}",
                                            pangkat_gol: "{{ $g->pangkat_gol }}",
                                            alamat: "{{ $g->alamat }}",
                                            provinsi: "{{ $g->provinsi }}",
                                            kab_kota: "{{ $g->kab_kota }}",
                                            kecamatan: "{{ $g->kecamatan }}",
                                            kenagarian: "{{ $g->kenagarian }}",
                                            no_telepon: "{{ $g->no_telepon }}",
                                            email: "{{ $g->email }}",
                                            status: "{{ $g->status }}"
                                        })'
                                class="px-3 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                Detail
                            </button>

                            <a href="{{ route('admin.guru.edit', $g->id) }}"
                               class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                Edit
                            </a>

                            <form action="{{ route('admin.guru.destroy', $g->id) }}"
                                  method="POST"
                                  class="inline"
                                  onsubmit="return confirm('Yakin hapus data ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        class="px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-500">
                            Data guru belum tersedia
                        </td>
                    </tr>

                @endforelse

                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $guru->links() }}
    </div>
</div>

{{-- ================= MODAL DETAIL ================= --}}
<div id="detailModal"
     class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl w-full max-w-2xl p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Detail Guru</h2>
            <button onclick="closeDetail()" class="text-2xl">&times;</button>
        </div>

        <div id="detailContent" class="grid grid-cols-2 gap-3 text-sm"></div>

    </div>
</div>

{{-- ================= JS ================= --}}
<script>
function openDetail(guru){

    document.getElementById("detailContent").innerHTML = `
        <div><b>NIP</b></div><div>${guru.nip ?? '-'}</div>
        <div><b>NUPTK</b></div><div>${guru.nuptk ?? '-'}</div>
        <div><b>Nama Lengkap</b></div><div>${guru.nama_lengkap ?? '-'}</div>
        <div><b>Tempat / Tanggal Lahir</b></div>
        <div>${guru.tempat_lahir ?? '-'} / ${guru.tanggal_lahir ?? '-'}</div>

        <div><b>Jenis Kelamin</b></div><div>${guru.jenis_kelamin ?? '-'}</div>
        <div><b>Pendidikan</b></div><div>${guru.pendidikan_terakhir ?? '-'}</div>
        <div><b>Jabatan</b></div><div>${guru.jabatan_guru ?? '-'}</div>
        <div><b>Pangkat</b></div><div>${guru.pangkat_gol ?? '-'}</div>

        <div><b>Alamat</b></div><div>${guru.alamat ?? '-'}</div>
        <div><b>Provinsi</b></div><div>${guru.provinsi ?? '-'}</div>
        <div><b>Kab/Kota</b></div><div>${guru.kab_kota ?? '-'}</div>
        <div><b>Kecamatan</b></div><div>${guru.kecamatan ?? '-'}</div>
        <div><b>Kenagarian/Kelurahan</b></div><div>${guru.kenagarian ?? '-'}</div>

        <div><b>No HP</b></div><div>${guru.no_telepon ?? '-'}</div>
        <div><b>Email</b></div><div>${guru.email ?? '-'}</div>
        <div><b>Status</b></div><div>${guru.status ?? '-'}</div>
    `;

    document.getElementById("detailModal").classList.remove("hidden");
    document.getElementById("detailModal").classList.add("flex");
}

function closeDetail(){
    document.getElementById("detailModal").classList.add("hidden");
    document.getElementById("detailModal").classList.remove("flex");
}

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