@extends('admin.layout')

@section('content')
    @include('admin.tahun_ajaran.form', ['title' => 'Edit Tahun Ajaran: ' . ($tahunAjaran->tahun_mulai ?? '') . '/' . ($tahunAjaran->tahun_selesai ?? '')])
@endsection