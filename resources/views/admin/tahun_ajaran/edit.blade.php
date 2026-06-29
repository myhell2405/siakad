@extends('admin.layout')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-xl shadow border">

        <!-- Header -->
        <div class="border-b px-6 py-4">

            <h1 class="text-2xl font-bold text-gray-800">
                Edit Tahun Ajaran
            </h1>

        </div>

        <!-- Body -->
        <div class="p-6">

            <!-- Error -->
            @if ($errors->any())

                <div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg">

                    <ul class="list-disc ml-5">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <!-- FORM -->
            <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id_tahun_ajaran) }}"
                  method="POST">

                @csrf
                @method('PUT')

                @include('admin.tahun_ajaran.form')

            </form>

        </div>

    </div>

</div>

@endsection