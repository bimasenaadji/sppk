@extends('layouts.app')

@section('title', 'index page')

@section('content')
    <h1 class="mt-2 mb-4">Master User</h1>

    <div class="mb-3">
        <button type="button" class="btn btn-success-dark" id="btn-add-user" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah User
        </button>
    </div>

    <table class="table table-bordered" id="userTable">
        <thead>
            <tr>
                <th>Nama</th>
                    <th>Posisi</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
            </tr>
        </thead>
    </table>

    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="userForm" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="id">
                        <div class="col mb-3">
                            <div class="col mb-3">
                                <label for="nameWithTitle" class="form-label">Name</label>
                                <input type="text" id="nameWithTitle" name="name" class="form-control" placeholder="Enter Name" required>
                            </div>
                            <div class="col mb-3">
                                <label for="positionWithTitle " class="form-label">Position</label>
                                <input type="text" id="positionWithTitle " name="position" class="form-control" placeholder="Enter Name" required>
                            </div>
                            <div class="col mb-3">
                                <label for="phoneWithTitle" class="form-label">Phone</label>
                                <input type="text" id="phoneWithTitle" name="phone" class="form-control" placeholder="Enter Name" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="xxxx@xxx.xx" required>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="********" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Modal Create  --}}

     <!-- Modal Edit -->
     <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="userFormEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="id">
                        <div class="mb-3">
                            <label for="nameWithTitle" class="form-label">Name</label>
                            <input type="text" id="nameWithTitle" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="positionWithTitle" class="form-label">Position</label>
                            <input type="text" id="positionWithTitle" name="position" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phoneWithTitle" class="form-label">Phone</label>
                            <input type="text" id="phoneWithTitle" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <div class="mb-3">
                                <label for="nameWithTitle" class="form-label">Name</label>
                                <input type="text" id="nameWithTitle" name="name" class="form-control" required>
                            </div>
                            <label for="emailWithTitle" class="form-label">Email</label>
                            <input type="email" id="emailWithTitle" name="email" class="form-control" required>
                        </div>
                        <div class="row g-2">
                            <div class="col mb-0">
                                <label for="passwordWithTitle" class="form-label">Password</label>
                                <input type="password" id="passwordWithTitle" name="passwordWithTitle" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('user.data') }}',
                columns: [
    { data: 'name', name: 'name' },
    { data: 'position', name: 'position' },
    { data: 'phone', name: 'phone' },
    { data: 'email', name: 'email' },
    { data: null, render: function (data, type, row) {
        return `
            <button type="button" data-id="${row.id}" class="btn btn-sm btn-primary btn-edit-data" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
            <button type="button" data-id="${row.id}" class="btn btn-sm btn-danger btn-delete-data">Hapus</button>
        `;
    }}
]

            });

            $('#btn-add-user').click(function() {
                $('#modalCenterTitle').text('Tambah User');
                $('#userForm')[0].reset();
                $('#userId').val('');
            });

            $(document).on('click', '.btn-edit-data', function() {
            const userId = $(this).data('id');
            
            $.ajax({
                url: `/user/${userId}`,
                type: 'GET',
                success: function(data) {
    $('#modalEdit #userId').val(data.id);
    $('#modalEdit #nameWithTitle').val(data.name);
    $('#modalEdit #emailWithTitle').val(data.email);
    $('#modalEdit #positionWithTitle').val(data.position);
    $('#modalEdit #phoneWithTitle').val(data.phone);
    $('#userFormEdit').attr('action', `/user/${data.id}`);
}

            });
        });
$('#userForm').submit(function(e) {
    e.preventDefault();
    const formData = $(this).serialize();
    const userId = $('#userId').val();
    const url = userId ? `/user/${userId}` : '{{ route('user.store') }}';
    const method = userId ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        type: method,
        data: formData,
        success: function(response) {
            // Tampilkan alert jika ingin
            alert(response.message || 'Data berhasil disimpan.');
            // Lalu refresh seluruh halaman
            location.reload();
        },
        error: function() {
            alert('Terjadi kesalahan saat menyimpan data.');
        }
    });
});


            $(document).on('click', '.btn-delete-data', function() {
                const userId = $(this).data('id');
                if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                    $.ajax({
                        url: `/user/${userId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            $('#userTable').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush
