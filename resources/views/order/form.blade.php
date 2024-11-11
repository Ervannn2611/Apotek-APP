@extends('layouts.layout')
@section('content')
    <div class="container mt-3">
        <form action="{{ route('pembelian.proses') }}" class="card m-auto p-4" method="POST">
            @csrf

            {{-- Display validation error messages --}}
            @if ($errors->any())
                <ul class="alert alert-danger p-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            @if (Session::get('failed'))
                <div class="alert alert-danger">{{ Session::get('failed') }}</div>
            @endif

            <h5 class="mb-3">Penanggung Jawab: <b>{{ Auth::user()->name }}</b></h5>

            <div class="mb-3 row">
                <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_customer" name="name_customer" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
                <div class="col-sm-10">
                    <div id="wrap-medicines">
                        <div class="medicine-group d-flex align-items-center mb-2">
                            <select name="medicines[]" class="form-select" required>
                                <option selected hidden disabled>Pesanan 1</option>
                                @foreach ($medicines as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" id="add-select" class="btn btn-sm btn-outline-success mt-2">
                        + Add Obat
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-success btn-lg w-100 mt-3">Konfirmasi Pembelian</button>
        </form>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        let no = 2;

        $("#add-select").on("click", function() {
            let html = `<div class="medicine-group d-flex align-items-center mb-2">
                            <select name="medicines[]" class="form-select" required>
                                <option selected hidden disabled>Pesanan ${no}</option>
                                @foreach ($medicines as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="remove-select btn btn-outline-danger btn-sm ms-2">
                                <i class="fas fa-times">x</i>
                            </button>
                        </div>`;
            $("#wrap-medicines").append(html);
            no++;
        });

        $(document).on("click", ".remove-select", function() {
            $(this).closest(".medicine-group").remove();
            no--;
        });
    </script>
@endpush
