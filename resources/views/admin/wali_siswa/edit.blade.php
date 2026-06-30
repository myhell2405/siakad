@extends('admin.layout')

@section('content')
    @include('admin.wali_siswa.form', ['title' => 'Edit Data Wali: ' . ($waliSiswa->nama_wali ?? '')])
@endsection