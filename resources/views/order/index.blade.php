@extends('layouts.app')

@section('title', 'index page')

@section('content')
    <h1 class="mt-2 mb-4">Data Order</h1>

    <!-- Add Order Button -->
    <div class="mb-3">
        <button type="button" class="btn btn-primary" id="btn-add-order" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Data Order
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Order Table -->
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

    <!-- Modal Create Order -->
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

    <!-- Modal Edit Order -->
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="orderFormEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="orderId" name="id">
                        <div class="mb-3">
                            <label for="edit_customer_id" class="form-label">Customer</label>
                            <select id="edit_customer_id" name="customer_id" class="form-select" required>
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h5>Order Items</h5>
                        <div id="editOrderItemsContainer"></div>
                        <button type="button" class="btn btn-secondary" onclick="addEditOrderItem()">Add Item</button>
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
        $(document).ready(function() {
            // Initialize DataTable
            $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: '{{ route('order.data') }}',
                columns: [
                    { data: null, orderable: false, className: 'text-center', render: data => `<input type="checkbox" name="id[]" value="${data.id}" class="form-check-input">` },
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'customer_name' },
                    { data: 'date', className: 'whitespace-normal' },
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
                        <span class="flex gap-x-5">
                            <button type="button" data-id="${row.id}" class="btn btn-primary btn-edit-data" data-bs-toggle="modal" data-bs-target="#modalEdit">Edit</button>
                            <button type="button" data-id="${row.id}" class="btn btn-danger btn-delete-data">Hapus</button>
                            <button type="button" class="btn btn-info" onclick="redirectToInvoice(${row.id})">Invoice</button>
                        </span>`
                    }
                ]
            });

            // Load order data into Edit modal
            $(document).on('click', '.btn-edit-data', function() {
                const orderId = $(this).data('id');
                $.get(`/order/${orderId}`, data => {
                    $('#orderId').val(data.id);
                    $('#edit_customer_id').val(data.customer_id);
                    $('#editOrderItemsContainer').html(data.order_items.map((item, i) => `
                        <div class="row mb-3" id="editOrderItem-${i}">
                            <div class="col-5">
                                <label class="form-label">Service</label>
                                <select name="order_items[${i}][service_id]" class="form-select" required>
                                    <option value="${item.service_id}">${item.service_name}</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" name="order_items[${i}][quantity]" value="${item.quantity}" class="form-control" required>
                            </div>
                            <div class="col-3">
                                <label class="form-label">Amount</label>
                                <input type="number" name="order_items[${i}][amount]" value="${item.amount}" class="form-control" step="0.01" required>
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn btn-danger" onclick="removeEditOrderItem(${i})">-</button>
                            </div>
                        </div>
                    `).join(''));
                });
            });
        });

        // Functions for dynamic item rows in modals
        function addOrderItem() {
            const index = $('#orderItemsContainer .row').length;
            $('#orderItemsContainer').append(`
                <div class="order-item row mb-3">
                    <div class="col-5">
                        <label class="form-label">Service</label>
                        <select name="order_items[${index}][service_id]" class="form-select" required></select>
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

        function removeOrderItem(button) {
            $(button).closest('.order-item').remove();
        }

        function addEditOrderItem() {
            // similar to addOrderItem but for the Edit modal
        }

        function removeEditOrderItem(index) {
            $(`#editOrderItem-${index}`).remove();
        }

        function redirectToInvoice(orderId) {
            window.location.href = `order/${orderId}/invoice`;
        }
    </script>
@endpush
