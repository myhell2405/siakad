@extends('admin.layout')

@section('content')

<div class="bg-white rounded-xl shadow border p-6">


<h1 class="text-2xl font-bold mb-6">
    Edit Ekskul
</h1>

<form action="{{ route('admin.ekskul.update', $ekskul->id_ekskul) }}"
      method="POST">

    @csrf
    @method('PUT')

    @include('admin.ekskul.form')

    <div class="mt-6 flex justify-end gap-3">

        <a href="{{ route('admin.ekskul.index') }}"
           class="px-4 py-2 bg-gray-500 text-white rounded-lg">

            Batal

        </a>

        <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg">

            Update

        </button>

    </div>

</form>


</div>

@endsection
