@extends('admin.layout')

@section('content')
<div class="p-6">

    <h1 class="text-2xl font-bold mb-5">Edit Siswa</h1>

    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST"
          class="bg-white p-6 rounded-lg shadow">

        @method('PUT')

        @include('admin.siswa.form')

        <div class="mt-6 flex justify-end gap-2">

            <a href="{{ route('admin.siswa.index') }}"
               class="px-5 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">
                Kembali
            </a>

            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg">
                Update
            </button>

        </div>

    </form>

</div>
@endsection