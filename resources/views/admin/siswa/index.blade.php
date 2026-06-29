@extends('admin.layout')

@section('content')
<div class="p-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-5">
        <h1 class="text-2xl font-bold text-gray-800">Data Siswa</h1>

        <a href="{{ route('admin.siswa.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            + Tambah Siswa
        </a>
    </div>

    {{-- SEARCH --}}
    <div class="mb-4">
        <form action="{{ route('admin.siswa.index') }}" method="GET" id="searchForm">
            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                   placeholder="Cari nama atau NISN..."
                   class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
        </form>
    </div>

    {{-- TABLE --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-gray-800 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">NISN</th>
                    <th class="px-4 py-3">Nama Siswa</th>
                    <th class="px-4 py-3">Jenis Kelamin</th>
                    <th class="px-4 py-3">Agama</th>
                    <th class="px-4 py-3">Tanggal Lahir</th>
                    <th class="px-4 py-3">No HP</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>

            <tbody id="tableSiswa">
                @forelse($siswa as $s)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $s->nisn }}</td>
                    <td class="px-4 py-3 font-medium">{{ $s->nama_siswa }}</td>
                    <td class="px-4 py-3">{{ $s->jenis_kelamin }}</td>
                    <td class="px-4 py-3">{{ $s->agama }}</td>
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($s->tanggal_lahir)->format('d-m-Y') }}
                    </td>
                    <td class="px-4 py-3">{{ $s->telp_siswa }}</td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 text-right space-x-2">

                        {{-- DETAIL BUTTON --}}
                        <button
                            onclick="openDetail(this)"
                            data-nisn="{{ $s->nisn }}"
                            data-nama="{{ $s->nama_siswa }}"
                            data-tempat="{{ $s->tempat_lahir }}"
                            data-tanggal="{{ $s->tanggal_lahir }}"
                            data-jenis="{{ $s->jenis_kelamin }}"
                            data-agama="{{ $s->agama }}"
                            data-status="{{ $s->status_keluarga }}"
                            data-anak="{{ $s->anak_ke }}"
                            data-alamat="{{ $s->alamat_siswa }}"
                            data-telp="{{ $s->telp_siswa }}"
                            data-sekolah="{{ $s->sekolah_asal }}"
                            data-diterima="{{ $s->tanggal_diterima }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                            Detail
                        </button>

                        {{-- EDIT --}}
                        <a href="{{ route('admin.siswa.edit', $s->id) }}"
                           class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                            Edit
                        </a>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.siswa.destroy', $s->id) }}"
                              method="POST"
                              class="inline-block"
                              onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">
                        Data siswa tidak ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t">
            {{ $siswa->links() }}
        </div>

{{-- MODAL DETAIL SISWA --}}
<div id="detailModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

    <div class="bg-white w-full max-w-2xl rounded-lg shadow-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold">Detail Siswa</h2>
            <button onclick="closeDetail()" class="text-gray-600 text-xl">&times;</button>
        </div>

        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm">
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">NISN</span>
                <span>: <span id="d_nisn"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Nama</span>
                <span>: <span id="d_nama"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Tempat Lahir</span>
                <span>: <span id="d_tempat"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Tanggal Lahir</span>
                <span>: <span id="d_tanggal"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Jenis Kelamin</span>
                <span>: <span id="d_jenis"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Agama</span>
                <span>: <span id="d_agama"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Status Keluarga</span>
                <span>: <span id="d_status"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Anak Ke</span>
                <span>: <span id="d_anak"></span></span>
            </div>
        
            <div class="col-span-2 grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Alamat</span>
                <span>: <span id="d_alamat"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">No HP</span>
                <span>: <span id="d_telp"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Sekolah Asal</span>
                <span>: <span id="d_sekolah"></span></span>
            </div>
        
            <div class="grid grid-cols-[140px_1fr]">
                <span class="font-semibold">Tanggal Diterima</span>
                <span>: <span id="d_diterima"></span></span>
            </div>
        
</div>

    </div>
</div>        

    </div>
</div>

{{-- SEARCH DEBOUNCE JS --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimeout = null;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            if (searchInput.value.length > 0 && document.activeElement === searchInput) {
                const len = searchInput.value.length;
                searchInput.setSelectionRange(len, len);
            }
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    document.getElementById('searchForm').submit();
                }, 500);
            });
        }
    });
</script>
<script>
function openDetail(btn) {
    document.getElementById('detailModal').classList.remove('hidden');

    document.getElementById('d_nisn').innerText = btn.dataset.nisn;
    document.getElementById('d_nama').innerText = btn.dataset.nama;
    document.getElementById('d_tempat').innerText = btn.dataset.tempat;
    document.getElementById('d_tanggal').innerText = btn.dataset.tanggal;
    document.getElementById('d_jenis').innerText = btn.dataset.jenis;
    document.getElementById('d_agama').innerText = btn.dataset.agama;
    document.getElementById('d_status').innerText = btn.dataset.status;
    document.getElementById('d_anak').innerText = btn.dataset.anak;
    document.getElementById('d_alamat').innerText = btn.dataset.alamat;
    document.getElementById('d_telp').innerText = btn.dataset.telp;
    document.getElementById('d_sekolah').innerText = btn.dataset.sekolah;
    document.getElementById('d_diterima').innerText = btn.dataset.diterima;
}

function closeDetail() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>

@endsection