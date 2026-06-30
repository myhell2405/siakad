@extends('admin.layout')

@section('content')
    @include('admin.guru.form', ['title' => 'Edit Data Pendidik: ' . ($guru->nama_lengkap ?? '')])
@endsection