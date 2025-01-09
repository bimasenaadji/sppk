@extends('layouts.app')

@section('title', 'Transaction Page')

@section('content')
    <h1 class="mt-2 mb-4">Data Transaksi</h1>

    <div class="mb-3">
        <button type="button" class="btn btn-primary" id="btn-add-transaction" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Data Transaksi
        </button>
    </div>

    <table class="table table-bordered" id="transactionTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Customer</th>
                <th>Tax Category</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal Create Transaction -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="transactionForm" action="{{ route('transaction.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select id="customer_id" name="customer_id" class="form-control" required>
                                <!-- Populasi data customer dari controller -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tax_categories_id" class="form-label">Tax Category</label>
                            <select id="tax_categories_id" name="tax_categories_id" class="form-control" required>
                                <!-- Populasi data tax category dari controller -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="total_amount" class="form-label">Total</label>
                            <input type="number" id="total_amount" name="total_amount" class="form-control" placeholder="Enter total amount" required>
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
    {{-- End Modal Create --}}
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#transactionTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('transaction.data') }}',
                    type: 'GET',
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'customer_name', name: 'customer_name' },
                    { data: 'tax_category_name', name: 'tax_category_name' },
                    { data: 'total_amount', name: 'total_amount', render: $.fn.dataTable.render.number(',', '.', 2, 'Rp ') },
                    { 
                        data: null, 
                        orderable: false, 
                        searchable: false, 
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-success btn-sm" onclick="printInvoice(${row.id})">Print Invoice</button>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Delete</button>
                            `;
                        }
                    }
                ]
            });

            // Add Transaction Modal Logic
            $('#btn-add-transaction').click(function () {
                $('#transactionForm')[0].reset();
                $('#transactionForm').attr('action', '{{ route('transaction.store') }}');
            });

            // Delete Transaction
            $(document).on('click', '.btn-delete', function () {
                const id = $(this).data('id');
                if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                    $.ajax({
                        url: `/transaction/${id}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function () {
                            $('#transactionTable').DataTable().ajax.reload();
                        },
                        error: function () {
                            alert('Gagal menghapus transaksi.');
                        }
                    });
                }
            });

            // View Transaction Function
            window.printInvoice = function (id) {
                window.open(`/transaction/${id}/invoice`, '_blank'); // Membuka invoice di tab baru
            };
        });
    </script>
@endpush
