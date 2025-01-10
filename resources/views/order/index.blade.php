@extends('layouts.app')

@section('title', 'Data Order')

@section('content')
    <h1 class="mt-2 mb-4">Data Order</h1>

    <div class="mb-3">
        <button type="button" class="btn btn-primary" id="btn-add-order" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Data Order
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="orderTable">
        <thead>
            <tr>
                <th></th>
                <th>No</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="orderForm" action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select id="customer_id" name="customer_id" class="form-select" required>
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h5>Order Items</h5>
                        <div id="orderItemsContainer">
                            <div class="order-item row mb-3">
                                <div class="col-5">
                                    <label class="form-label">Service</label>
                                    <select name="order_items[0][service_id]" class="form-select" required>
                                        <option value="">-- Select Service --</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->service }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">Quantity</label>
                                    <input type="number" name="order_items[0][quantity]" class="form-control" min="1" required>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">Amount</label>
                                    <input type="number" name="order_items[0][amount]" class="form-control" step="0.01" required>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn btn-danger mt-4" onclick="removeOrderItem(this)">-</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addOrderItem()">Add Item</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const services = @json($services);

        $(document).ready(function () {
            $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('order.data') }}',
                columns: [
                    { data: null, orderable: false, className: 'text-center', render: data => `<input type="checkbox" name="id[]" value="${data.id}" class="form-check-input">` },
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'customer_name' },
                    { data: 'date' },
                    { data: 'total' },
                    { data: 'status', render: data => {
                        const statusClasses = {
                            success: 'bg-success text-white',
                            pending: 'bg-warning text-white',
                            canceled: 'bg-danger text-white'
                        };
                        return `<span class="badge ${statusClasses[data] || ''}">${data.charAt(0).toUpperCase() + data.slice(1)}</span>`;
                    }},
                    { data: null, render: (data, type, row) => `
                        <button type="button" onclick="redirectToEdit(${row.id})" class="btn btn-primary" title="Edit Data">
                            <i class="menu-icon tf-icons bx bx-pencil"></i>
                        </button>
                        <button type="button" data-id="${row.id}" class="btn btn-danger btn-delete-data" title="Hapus Data">
                            <i class="menu-icon tf-icons bx bx-eraser"></i>
                        </button>
                        <button type="button" class="btn btn-info" onclick="redirectToInvoice(${row.id})" title="Invoice">
                            <i class="menu-icon tf-icons bx bx-notepad"></i>
                        </button>
                        <button type="button" data-id="${row.id}" class="btn btn-danger btn-cancel-order" title="Batal Order">
                            <i class="menu-icon tf-icons bx bx-x"></i>
                        </button>
                    `}
                ]
            });
        });
        $(document).on('click', '.btn-delete-data', function () {
            const id = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `{{ url('/order') }}/${id}/delete`,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            $('#orderTable').DataTable().ajax.reload(); 
                        } else {
                            alert('Gagal menghapus data. Silakan coba lagi.');
                        }
                    },
                    error: function () {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        });


        function addOrderItem() {
            const index = $('#orderItemsContainer .order-item').length;
            $('#orderItemsContainer').append(`
                <div class="order-item row mb-3">
                    <div class="col-5">
                        <label class="form-label">Service</label>
                        <select name="order_items[${index}][service_id]" class="form-select" required>
                            <option value="">-- Select Service --</option>
                            ${services.map(service => `<option value="${service.id}">${service.service}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" name="order_items[${index}][quantity]" class="form-control" min="1" required>
                    </div>
                    <div class="col-3">
                        <label class="form-label">Amount</label>
                        <input type="number" name="order_items[${index}][amount]" class="form-control" step="0.01" required>
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn btn-danger mt-4" onclick="removeOrderItem(this)">-</button>
                    </div>
                </div>
            `);
        }
        $(document).on('click', '.btn-cancel-order', function () {
            const orderId = $(this).data('id');
            
            if (confirm('Apakah Anda yakin ingin membatalkan order ini?')) {
                $.ajax({
                    url: `{{ url('/order') }}/${orderId}/cancel`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            alert(response.message);
                            $('#orderTable').DataTable().ajax.reload(); // Refresh DataTable
                        }
                    },
                    error: function () {
                        alert('Gagal membatalkan order.');
                    }
                });
            }
        });

        function removeOrderItem(button) {
            $(button).closest('.order-item').remove();
        }

        function redirectToInvoice(orderId) {
            window.location.href = `order/${orderId}/invoice`;
        }

        function redirectToEdit(orderId) {
            window.location.href = `order/${orderId}/edit`;
        }
    </script>
@endpush
