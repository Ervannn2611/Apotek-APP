@extends('layouts.layout')

@section('content')
    <form action="{{ route('obat.edit.formulir', $item->id) }}" method="POST" class="">
        @method('PATCH')
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
            <label for="name" class="col-sm-2 col-form-label">Nama Obat :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $item->name) }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
            <div class="col-sm-10">
                <select class="form-select" id="type" name="type">
                    <option selected disabled hidden>Pilih</option>
                    <option value="tablet" {{ old('type', $item->type) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="sirup" {{ old('type', $item->type) == 'sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="kapsul" {{ old('type', $item->type) == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                </select>
            </div>
        </div>

        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $item->price) }}">
            </div>
        </div>

        {{-- <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stok Tersedia :</label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock', $item->stock) }}">
            </div> --}}
        </div>

        <button type="submit" class="btn btn-primary d-block mx-auto" >
        Ubah Data</button>
    </form>
@endsection
