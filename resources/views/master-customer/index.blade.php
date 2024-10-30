@extends('layouts.app')

@section('title', 'Master Customer')

@section('content')
    <h1 class="mt-2 mb-4">Master Customer</h1>

    <!-- Add Customer Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" id="btn-add-customer" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Customer
        </button>
    </div>

    <!-- Customer Table -->
    <table class="table table-bordered" id="customerTable">
        <thead>
            <tr>
                <th></th>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No Telp</th>
                <th>Alamat</th>
                <th>Tax ID</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>   
    </table>

    <!-- Create Customer Modal -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customerForm" action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="customerId" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telp" class="form-label">No Telp</label>
                            <input type="text" id="no_telp" name="no_telp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tax_id" class="form-label">Tax ID</label>
                            <input type="text" id="tax_id" name="tax_id" class="form-control">
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

    <!-- Edit Customer Modal -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="customerFormEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="customerId" name="id">
                        <div class="mb-3">
                            <label for="nameWithTitle" class="form-label">Name</label>
                            <input type="text" id="nameWithTitle" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="emailWithTitle" class="form-label">Email</label>
                            <input type="email" id="emailWithTitle" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_telpWithTitle" class="form-label">No Telp</label>
                            <input type="text" id="no_telpWithTitle" name="no_telp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamatWithTitle" class="form-label">Alamat</label>
                            <input type="text" id="alamatWithTitle" name="alamat" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="tax_idWithTitle" class="form-label">Tax ID</label>
                            <input type="text" id="tax_idWithTitle" name="tax_id" class="form-control">
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
        // Initialize DataTable
        $('#customerTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('customer.data') }}',
            columns: [
                { data: null, orderable: false, className: 'text-center', render: function (data) {
                    return `<input type="checkbox" name="id[]" value="${data.id}" class="form-check-input">`;
                }},
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'no_telp', name: 'no_telp' },
                { data: 'alamat', name: 'alamat' },
                { data: 'tax_id', name: 'tax_id' },
                { data: null, render: function (data, type, row) {
                    return `<span class="flex gap-x-5">
                        <button type="button" data-id="${row.id}" class="btn btn-primary btn-edit-data" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
                        <button type="button" data-id="${row.id}" class="btn btn-danger btn-delete-data">Hapus</button>
                    </span>`;
                }}
            ]
        });

        // Open Edit Modal with data
        $(document).on('click', '.btn-edit-data', function() {
            const customerId = $(this).data('id');
            $.ajax({
                url: `/customer/${customerId}`,
                type: 'GET',
                success: function(data) {
                    $('#modalEdit #customerId').val(data.id);
                    $('#modalEdit #nameWithTitle').val(data.name);
                    $('#modalEdit #emailWithTitle').val(data.email);
                    $('#modalEdit #no_telpWithTitle').val(data.no_telp);
                    $('#modalEdit #alamatWithTitle').val(data.alamat);
                    $('#modalEdit #tax_idWithTitle').val(data.tax_id);
                    $('#customerFormEdit').attr('action', `/customer/${customerId}`);
                    $('#modalEdit').modal('show');
                }
            });
        });

        // Handle Delete
        $(document).on('click', '.btn-delete-data', function() {
            const customerId = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus customer ini?')) {
                $.ajax({
                    url: `/customer/${customerId}`,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('#customerTable').DataTable().ajax.reload();
                    }
                });
            }
        });
    });
</script>
@endpush
