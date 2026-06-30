@extends('admin.layout')

@section('content')
    @include('admin.kelas.form', ['title' => 'Edit Data Kelas: ' . ($kelas->nama_kelas ?? '')])
@endsection