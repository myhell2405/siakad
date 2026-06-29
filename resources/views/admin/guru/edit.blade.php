@extends('admin.layout')

@section('content')
<h3>{{ $title }}</h3>

<form action="{{ route('admin.guru.update', $guru->id) }}" method="POST">
    @csrf
    @method('PUT')
    @include('admin.guru.form')
</form>
@endsection