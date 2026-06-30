@extends('admin.layout')

@section('content')
    @include('admin.ekskul.form', ['title' => 'Edit Ekstrakurikuler: ' . ($ekskul->nama_ekskul ?? '')])
@endsection
