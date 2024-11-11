@extends('layouts.layout')

@section('content')
@if (Session::get('failed'))
    <div class="alert alert-danger">{{ Session::get('failed') }}</div>
@endif
@if (Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
<div class="jumbotron py-4 px-5">
    @if(Auth::check())
        <h1 class="display-4">Selamat Datang, {{ Auth::user()->name }}</h1>
    @else
        <h1 class="display-4">Selamat Datang, Pengguna</h1>
    @endif
    <p class="lead">Di Aplikasi Manajemen Obat</p>
    <hr class="my-4">
    <p>Aplikasi ini digunakan hanya oleh pegawai administrator Apotek. Digunakan untuk mengelola data obat, penyetokan, juga (kasir).</p>
</div>
@endsection
