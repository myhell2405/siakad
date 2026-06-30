@extends('admin.layout')

@section('content')
    @include('admin.mapel.form', ['title' => 'Edit Mata Pelajaran: ' . ($mapel->nama_mapel ?? '')])
@endsection