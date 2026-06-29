@extends('admin.layout')

@section('content')
<h3>{{ $title }}</h3>

<form action="{{ route('admin.guru.store') }}" method="POST">
    @csrf
    @include('admin.guru.form')
</form>
@endsection