@extends('layouts.app')

@section('title', 'index page')

@section('content')
    <h1 class="mt-2 mb-4">Kategori Pajak</h1>

    <!-- Add User Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" id="btn-add-transaction" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Kategori Pajak
        </button>
    </div>

    <!-- User Table -->
    <table class="table table-bordered" id="transactionTable">
        <thead>
            <tr>
                <th></th>
                <th>No</th>
                <th>Customer</th>
                <th>Tax Category</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Tambah Kategori Pajak</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="transactionForm" action="{{ route('user.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="id">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name" required>
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
                <form id="transactionFormEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="id">
                        <div class="mb-3">
                            <label for="nameWithTitle" class="form-label">Name</label>
                            <input type="text" id="nameWithTitle" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
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
            // Datatable initialization
            $('#transactionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: ' {{ route('transaction.data') }}',
                    type: 'GET',
                },
                columns: [
                    { data: null, orderable: false, className: 'text-center', render: function (data, type, row) {
                        return `<input type="checkbox" name="id[]" value="${data.id}" class="form-check-input">`;
                    }},
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'transaction_type', name: 'transaction_type', className: 'px-6 py-4 border-b border-gray-200 whitespace-normal break-words' },
                    { data: 'total_amount', name: 'total_amount' },
                    { data: null, className: 'px-6 py-4 border-b border-gray-200 whitespace-normal break-words', render: function (data, type, row) {
                        return `<span class="flex gap-x-5">
                            <button type="button" data-id="${row.id}" class="text-white btn btn-primary btn-edit-data" data-bs-toggle="modal" data-bs-target="#modalEdit" >Edit</button>
                            <button type="button" data-id="${row.id}" class="text-white btn btn-danger btn-delete-data">Hapus</button>
                        </span>`;
                    }}
                ]
            });

            // Open modal for Add User
            $('#btn-add-transaction').click(function() {
                $('#modalCenterTitle').text('Tambah User');
                $('#transactionForm')[0].reset();
                $('#userId').val('');
            });

            // Open modal for Edit User
            $(document).on('click', '.btn-edit-data', function() {
            const userId = $(this).data('id');
            
            $.ajax({
                url: `/user/${userId}`,
                type: 'GET',
                success: function(data) {
                    // Tampilkan data di modal
                    $('#modalEdit #userId').val(data.id);
                    $('#modalEdit #nameWithTitle').val(data.name);
                    $('#modalEdit #emailWithTitle').val(data.email);

                    $('#transactionFormEdit').attr('action', `/user/${userId}`);

                    $('#modalEdit').modal('show');

                }
            });
        });

            // Form submission for Add/Edit
            $('#transactionForm').submit(function(e) {
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
                        $('#modalCenter').modal('hide');
                        $('#transactionTable').DataTable().ajax.reload();
                    }
                });
            });

            // Delete User
            $(document).on('click', '.btn-delete-data', function() {
                const userId = $(this).data('id');
                if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
                    $.ajax({
                        url: `/user/${userId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            $('#transactionTable').DataTable().ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush
