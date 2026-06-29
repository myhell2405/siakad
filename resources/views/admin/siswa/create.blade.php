@extends('admin.layout')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-5">Tambah Siswa</h1>

    <form action="{{ route('admin.siswa.store') }}" method="POST"
          class="bg-white p-6 rounded-lg shadow">

        @include('admin.siswa.form')

        <div class="mt-6 flex justify-end">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                Simpan
            </button>
        </div>

    </form>

</div>
@endsection