@extends('admin.layout')

@section('content')

<div class="max-w-7xl mx-auto">

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">
        {{ $title }}
    </h1>

    <a href="{{ route('admin.guru.index') }}"
       class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
        Kembali
    </a>
</div>

{{-- ERROR VALIDASI --}}
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-xl shadow border">

<form action="{{ isset($guru) ? route('admin.guru.update',$guru->id) : route('admin.guru.store') }}"
      method="POST"
      class="p-6">

    @csrf
    @if(isset($guru))
        @method('PUT')
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

        <input type="text" name="nip" required
            value="{{ old('nip', $guru->nip ?? '') }}"
            placeholder="NIP"
            class="border p-2 rounded">

        <input type="text" name="nuptk" required
            value="{{ old('nuptk', $guru->nuptk ?? '') }}"
            placeholder="NUPTK"
            class="border p-2 rounded">

        <input type="text" name="nama_lengkap" required
            value="{{ old('nama_lengkap', $guru->nama_lengkap ?? '') }}"
            placeholder="Nama Lengkap"
            class="border p-2 rounded">

        <input type="text" name="tempat_lahir" required
            value="{{ old('tempat_lahir', $guru->tempat_lahir ?? '') }}"
            placeholder="Tempat Lahir"
            class="border p-2 rounded">

        <input type="date" name="tanggal_lahir" required
            value="{{ old('tanggal_lahir', $guru->tanggal_lahir ?? '') }}"
            class="border p-2 rounded">

        <select name="jenis_kelamin" required class="border p-2 rounded">
            <option value="">Jenis Kelamin</option>
            <option value="L" {{ old('jenis_kelamin',$guru->jenis_kelamin??'')=='L'?'selected':'' }}>Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin',$guru->jenis_kelamin??'')=='P'?'selected':'' }}>Perempuan</option>
        </select>

        <input type="text" name="pendidikan_terakhir" required
            value="{{ old('pendidikan_terakhir', $guru->pendidikan_terakhir ?? '') }}"
            placeholder="Pendidikan"
            class="border p-2 rounded">

        <input type="text" name="jabatan_guru" required
            value="{{ old('jabatan_guru', $guru->jabatan_guru ?? '') }}"
            placeholder="Jabatan"
            class="border p-2 rounded">

        <input type="text" name="pangkat_gol" required
            value="{{ old('pangkat_gol', $guru->pangkat_gol ?? '') }}"
            placeholder="Pangkat"
            class="border p-2 rounded">

        <input type="text" name="no_telepon" required
            value="{{ old('no_telepon', $guru->no_telepon ?? '') }}"
            placeholder="No HP"
            class="border p-2 rounded">

        <input type="email" name="email" required
            value="{{ old('email', $guru->email ?? '') }}"
            placeholder="Email"
            class="border p-2 rounded">

        <select name="status" required class="border p-2 rounded">
            <option value="">Status</option>
            <option value="Aktif" {{ old('status',$guru->status??'')=='Aktif'?'selected':'' }}>Aktif</option>
            <option value="Tidak Aktif" {{ old('status',$guru->status??'')=='Tidak Aktif'?'selected':'' }}>Tidak Aktif</option>
        </select>

    </div>

    {{-- ALAMAT --}}
    <div class="mt-5">
        <textarea name="alamat" required
            placeholder="Alamat"
            class="w-full border p-2 rounded">{{ old('alamat',$guru->alamat??'') }}</textarea>
    </div>

    {{-- WILAYAH --}}
    <div class="grid grid-cols-2 gap-4 mt-5">

        <input type="text" name="provinsi" required
            value="{{ old('provinsi',$guru->provinsi??'') }}"
            placeholder="Provinsi"
            class="border p-2 rounded">

        <input type="text" name="kab_kota" required
            value="{{ old('kab_kota',$guru->kab_kota??'') }}"
            placeholder="Kab/Kota"
            class="border p-2 rounded">

        <input type="text" name="kecamatan" required
            value="{{ old('kecamatan',$guru->kecamatan??'') }}"
            placeholder="Kecamatan"
            class="border p-2 rounded">

        <input type="text" name="kenagarian" required
            value="{{ old('kenagarian',$guru->kenagarian??'') }}"
            placeholder="Kenagarian/kelurahan"
            class="border p-2 rounded">

    </div>

    <div class="flex justify-end mt-6">
        <button type="submit"
            class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Simpan
        </button>
    </div>

</form>

</div>

</div>

@endsection