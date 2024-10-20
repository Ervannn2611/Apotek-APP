@extends('layouts.layout')

@section('content')

    <div class="home-text">
        <h1>Data User</h1>
    </div>

    {{-- Menampilkan pesan sukses --}}
    @if (Session::get('success'))
        <div class="alert alert-success">{{ Session::get('success') }}</div>
    @endif

    <div class="row mb-3">
        {{-- Form Pencarian dan Sorting --}}
        <div class="col-lg-6 col-md-6 mb-2">
            <form class="d-flex" role="search" action="{{ route('user.data_user') }}" method="GET">
                <input type="text" class="form-control me-2" name="search" placeholder="Search" aria-label="Search" value="{{ request('search') }}"> 
                <select name="role" class="form-select me-2" aria-label="Pilih Role">
                    <option selected disabled hidden>Pilih Semua Role</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>

        {{-- Tombol Tambah User --}}
        <div class="col-lg-6 col-md-6 d-flex justify-content-end mb-3">
            <a href="{{ route('user.user') }}" class="btn btn-primary">Tambah User</a>
        </div>
    </div>

    {{-- Tabel Data User --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_user as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->role }}</td>
                    <td class="d-flex gap-2 justify-content-center">
                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm" onclick="showModalDelete({{ $item->id }}, '{{ $item->name }}')">Hapus</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Modal Hapus User --}}
    <div class="modal fade" id="modal_delete" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_delete_user" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDeleteLabel">Hapus Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus <span id="delete_name"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm_delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModalDelete(id, name) {
        let urlDelete = "{{ route('user.hapus', ':id') }}";
        urlDelete = urlDelete.replace(':id', id);
        $('#form_delete_user').attr('action', urlDelete);
        $('#delete_name').text(name);
        $('#modal_delete').modal('show');
    }
</script>
@endpush
