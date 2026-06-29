@extends('admin.layout')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow border">

        <div class="border-b px-6 py-4">
            <h1 class="text-2xl font-bold text-gray-800">
                Tambah Mapel
            </h1>
        </div>

        <div class="p-6">

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.mapel.store') }}" method="POST">
                @csrf
                @include('admin.mapel.form')
            </form>

        </div>

    </div>

</div>

@endsection