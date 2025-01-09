@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Order</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('order.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="customer_id" class="form-label">Customer</label>
            <select class="form-select" id="customer_id" name="customer_id" required>
                @foreach($customers as $customer)
                    <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                        {{ $customer->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <h4 class="mb-3">Order Items</h4>
        <div id="orderItemsContainer">
            @foreach($order->orderItems as $item)
            <div class="order-item mb-3" id="order-item-{{ $item->id }}">
                <div class="row">
                    <div class="col-md-5">
                        <label class="form-label">Service</label>
                        <select class="form-select" name="order_items[{{ $item->id }}][service_id]" required>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ $item->service_id == $service->id ? 'selected' : '' }}>
                                    {{ $service->service }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="order_items[{{ $item->id }}][quantity]" value="{{ $item->qty }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Amount</label>
                        <input type="number" class="form-control" name="order_items[{{ $item->id }}][amount]" value="{{ $item->amount }}" required>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger btn-sm remove-order-item mt-4" data-id="{{ $item->id }}">
                            -
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-3">
            <button type="button" class="btn btn-primary" id="addOrderItemButton">Add Item</button>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success">Save Changes</button>
            <a href="{{ route('order.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<template id="orderItemTemplate">
    <div class="order-item mb-3">
        <div class="row">
            <div class="col-md-5">
                <label class="form-label">Service</label>
                <select class="form-select" name="order_items[new][service_id]" required>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->service }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-control" name="order_items[new][quantity]" value="1" required>
            </div>

            <div class="col-md-3">
                <label class="form-label">Amount</label>
                <input type="number" class="form-control" name="order_items[new][amount]" value="0" required>
            </div>

            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-sm btn-danger mt-4 remove-order-item">
                    -
                </button>
            </div>
        </div>
    </div>
</template>
@endsection

@push('js')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const orderItemsContainer = document.getElementById('orderItemsContainer');
        const addOrderItemButton = document.getElementById('addOrderItemButton');
        const orderItemTemplate = document.getElementById('orderItemTemplate').content;

        addOrderItemButton.addEventListener('click', function () {
            const newOrderItem = orderItemTemplate.cloneNode(true);
            orderItemsContainer.appendChild(newOrderItem);
        });

        orderItemsContainer.addEventListener('click', function (e) {
            if (e.target.closest('.remove-order-item')) {
                const orderItem = e.target.closest('.order-item');
                orderItem.remove();
            }
        });
    });
</script>
@endpush
