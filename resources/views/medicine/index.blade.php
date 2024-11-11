@extends('layouts.layout')

@section('content')
@if (Session::get('success'))
    <div class="alert alert-success">{{ Session::get('success') }}</div>
@endif
<div class="container mt-4">


    <!-- Search and Add Button Section -->
    <div class="row mb-4">
        <!-- Search Form -->
        <div class="col-lg-6 col-md-6 mb-2">
            <form class="d-flex" role="search" action="{{ route('obat.data') }}" method="GET">
                <input type="text" class="form-control me-2" name="search" placeholder="Cari Obat" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Cari</button>
            </form>
        </div>
        <!-- Add and Sorting Buttons -->
        <div class="col-lg-6 col-md-6 d-flex justify-content-end">
            <a class="btn btn-primary mx-2 mb-2" href="{{ route('obat.tambah_obat') }}">
                <i class="fas fa-plus"></i> Tambah Obat
            </a>
            <form action="{{ route('obat.data') }}" method="GET" class="me-2">
                <input type="hidden" name="sort_stock" value="stock">
                <button type="submit" class="btn btn-warning">Stok Kecil</button>
            </form>
            <form action="{{ route('obat.data') }}" method="GET" class="me-2">
                <input type="hidden" name="large_stock" value="stock">
                <button type="submit" class="btn btn-info">Stok Besar</button>
            </form>
        </div>
    </div>
    <div class="mb-4">
        <h1 class="text-center">Data Obat</h1>
    </div>

    <!-- Medicines Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped align-middle">
            <thead class="table-primary text-center">
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Jenis</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (count($medicines) < 1)
                    <tr>
                        <td colspan="6" class="text-center text-muted">Data Obat Kosong</td>
                    </tr>
                @else
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td class="text-center">{{ ($medicines->currentPage() - 1) * $medicines->perPage() + ($index + 1) }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->type }}</td>
                            <td class="text-center">Rp. {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-center {{ $item->stock <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer" onclick="showModalStock({{ $item->id }}, '{{ $item->stock }}')">
                                {{ $item->stock }}
                            </td>
                            <td class="d-flex justify-content-center">
                                <a href="{{ route('obat.edit', $item->id) }}" class="btn btn-sm btn-primary me-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <button class="btn btn-sm btn-danger" onclick="showModalDelete({{ $item->id }}, '{{ $item->name }}')">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end">
        {{ $medicines->links() }}
    </div>

    <!-- Modal Hapus -->
    <div class="modal fade" id="modal_delete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_delete_obat" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Hapus Data Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus obat <span id="delete_name"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm_delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Stock -->
    <div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="modalEditStockLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_edit_stock" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditStockLabel">Edit Stok Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stock_edit" class="form-label">Stok: </label>
                            <input type="number" class="form-control" id="stock_edit" name="stock" required>
                            @if(Session::get('failed'))
                                <small class="text-danger">{{ Session::get('failed') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    function showModalDelete(id, name) {
        let urlDelete = "{{ route('obat.hapus', ':id') }}";
        urlDelete = urlDelete.replace(':id', id);
        $('#form_delete_obat').attr('action', urlDelete);
        $('#delete_name').text(name);
        $('#modal_delete').modal('show');
    }

    function showModalStock(id, stock) {
        $('#stock_edit').val(stock);
        let url = "{{ route('obat.edit.stock', ':id') }}";
        url = url.replace(':id', id);
        $('#form_edit_stock').attr('action', url);
        $('#modal_edit_stock').modal('show');
    }

    @if(Session::get('failed'))
    $(document).ready(function() {
        let id = "{{ Session::get('id') }}";
        let stock = "{{ Session::get('stock') }}";
        showModalStock(id, stock);
    });
    @endif
</script>
@endpush
