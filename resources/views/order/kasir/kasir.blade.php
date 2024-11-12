@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('pembelian.formulir') }}" class="btn btn-primary">+ Tambah</a>
        </div>
        <div class="col-lg-6 col-md-6 mb-2">
            <form class="d-flex" role="search" action="{{ url()->current() }}" method="GET">
                <input type="date" class="form-control me-2" name="search" placeholder="Cari Obat" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
        </div>

        <h2 class="mb-4" style="text-align: center; font-weight: bold; font-size: 22px;">Data Pembelian: {{ Auth::user()->name }}</h2>


        <style>
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: #f5f5f5;
            }

            .table-striped tbody tr:nth-of-type(even) {
                background-color: #fff;
            }
        </style>

        <table class="table table-bordered table-striped mt-3" style="border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
            <thead class="thead-light">
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 40%;">Obat</th>
                    <th style="width: 20%;">Total Harga</th>
                    <th style="width: 20%;">Tanggal Pembelian</th>
                    <th style="width: 15%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $index => $order)
                    <tr>
                        <td>{{ ($orders->currentPage() - 1) * $orders->perPage() + $index + 1 }}</td>
                        <td style="word-break: break-all;">
                            <ul class="list-unstyled mb-0">
                                @foreach ($order->medicines as $medicine)
                                    <li>{{ $medicine['medicines'] }} ({{ $medicine['quantity'] }}): Rp.{{ number_format($medicine['price'], 0, ',', '.') }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>Rp.{{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td>{{ \carbon\carbon::create($order->created_at)->locale('id')->isoformat('D MMMM, Y HH:mm:ss') }}</td>
                        <td>
                            <a href="{{ route('pembelian.print', $order->id) }}" class="btn btn-secondary btn-sm">Download</a>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $orders->links() }}
        </div>
    </div>
@endsection

