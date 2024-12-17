@extends('layouts.app')

@section('title', 'index page')

@section('content')
<h1>Invoice</h1>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Customer Name:</strong> {{ $order->customer->name }}</p>
    <p><strong>Order Date:</strong> {{ $order->date }}</p>
    <p><strong>Status:</strong> {{ $order->status }}</p>
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
            @foreach ($order->orderItems as $item)
                <tr>
                    <td>{{ $item->service->service ?? 'N/A' }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ number_format($item->amount, 2) }}</td>
                    <td>{{ number_format($item->total_amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Select Tax Category</h3>
    <form id="taxCategoryForm">
        <div class="form-group">
            <label for="tax_category">Tax Category</label>
            <select class="form-control" id="tax_category" name="tax_category">
                <option value="">-- Select Tax Category --</option>
                @foreach($taxCategories as $taxCategory)
                    <option value="{{ $taxCategory->id }}" 
                            data-ppn="{{ $taxCategory->tax_ppn }}" 
                            data-pph="{{ $taxCategory->tax_pph }}">
                        {{ $taxCategory->transaction_type }} - {{ $taxCategory->description }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>
    <hr>
    
    <h3>Order Summary</h3>
    <table class="table table-bordered">
        <tr>
            <th>Total</th>
            <td id="total_amount">{{ number_format($order->total, 2) }}</td>
        </tr>
        <tr>
            <th>PPN Amount</th>
            <td id="ppn_amount">0.00</td>
        </tr>
        <tr>
            <th>PPh Amount</th>
            <td id="pph_amount">0.00</td>
        </tr>
        <tr>
            <th>Total after Taxes</th>
            <td id="total_taxes">{{ number_format($order->total, 2) }}</td>
        </tr>
        <tr>
            <th>Net Amount</th>
            <td id="net_amount">0.00</td>
        </tr>
    </table>
    @endsection

    @push('js')
        <script>
            document.getElementById('tax_category').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const ppnRate = parseFloat(selectedOption.getAttribute('data-ppn')) || 0;
                const pphRate = parseFloat(selectedOption.getAttribute('data-pph')) || 0;
                const totalAmount = parseFloat({{ $order->total }});

                const ppnAmount = totalAmount * (ppnRate / 100);
                const pphAmount = totalAmount * (pphRate / 100);
                const totalTaxes = totalAmount + ppnAmount + pphAmount;
                const netAmount = totalTaxes - totalAmount

                document.getElementById('ppn_amount').innerText = ppnAmount.toFixed(2) + '  (' + ppnRate.toFixed() + '%)';
                document.getElementById('pph_amount').innerText = pphAmount.toFixed(2) + '  (' + pphRate.toFixed() + '%)';
                document.getElementById('total_taxes').innerText = totalTaxes.toFixed(2);
                document.getElementById('net_amount').innerText = netAmount.toFixed(2);
            });
        </script>
@endpush
