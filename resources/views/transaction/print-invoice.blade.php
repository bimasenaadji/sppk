@extends('layouts.app')

@section('title', 'Invoice')

@section('content')
<h1>Invoice</h1>
<p><strong>Invoice Number:</strong> {{ $transaction->id }}</p>
<p><strong>Invoice Date:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
<p><strong>Due Date:</strong> {{ $transaction->due_date ?? '-' }}</p>
<p><strong>Status:</strong> {{ $transaction->status ?? 'Pending' }}</p>
<hr>

<h3>Order Details</h3>
<p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
<p><strong>Customer Name:</strong> {{ $transaction->customer->name }}</p>
<p><strong>Order Date:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
<hr>

<h3>Order Items</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Service</th>
            <th>Quantity</th>
            <th>Amount</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($transaction->orderItems as $item)
            <tr>
                <td>{{ $item->service->name ?? 'N/A' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->amount, 2) }}</td>
                <td>{{ number_format($item->total_amount, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<h3>Tax Summary</h3>
<table class="table table-bordered">
    <tr>
        <th>PPN Amount</th>
        <td>{{ number_format($transaction->ppn_amount, 2) }}</td>
    </tr>
    <tr>
        <th>PPh Amount</th>
        <td>{{ number_format($transaction->pph_amount, 2) }}</td>
    </tr>
    <tr>
        <th>Total Tax</th>
        <td>{{ number_format($transaction->ppn_amount + $transaction->pph_amount, 2) }}</td>
    </tr>
</table>

<h3>Order Summary</h3>
<table class="table table-bordered">
    <tr>
        <th>Total Amount</th>
        <td>{{ number_format($transaction->total_amount, 2) }}</td>
    </tr>
    <tr>
        <th>Net Amount</th>
        <td>{{ number_format($transaction->net_amount, 2) }}</td>
    </tr>
</table>
@endsection
