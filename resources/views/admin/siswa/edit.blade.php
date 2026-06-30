@extends('admin.layout')

@section('content')
    @include('admin.siswa.form', ['title' => 'Edit Data Siswa: ' . ($siswa->nama_siswa ?? '')])
@endsection