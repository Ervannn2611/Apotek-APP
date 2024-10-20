@extends('layouts.layout')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-custom {
            margin: 50px auto;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        body {
            background-color: #f8f9fa;
        }
        .form-title {
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form action="{{ route('user.tambah-formulir') }}" method="POST">
        {{ csrf_field() }}
    <div class="container">
        <div class="card card-custom">
            {{-- Judul Form --}}
            <div class="form-title">Daftar Pengguna</div>

            {{-- form untuk pengguna --}}
            <form class="p-4">
                @csrf 
                @if(Session::get('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3 row">
                    <label for="name" class="col-sm-3 col-form-label text-right" value="{{ old('name') }}">Nama :</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="email" class="col-sm-3 col-form-label text-right" value="{{ old('email') }}">Email :</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="password" class="col-sm-3 col-form-label text-right" value="{{ old('password') }}">Password :</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="role" class="col-sm-3 col-form-label text-right" value="{{ old('role') }}">Role :</label>
                    <div class="col-sm-9">
                        <select name="role" id="role" class="form-control">
                            <option value="admin" value="{{ old('role') }}">Admin</option>
                            <option value="user" value="{{ old('role') }}">User</option>
                        </select>
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@endsection

