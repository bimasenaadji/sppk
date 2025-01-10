<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border: 1px solid #000;
        }
        .text-primary {
            color: #007bff;
        }
        .fw-bold {
            font-weight: bold;
        }
        .fw-lighter {
            font-weight: lighter;
        }
        .fst-italic {
            font-style: italic;
        }
        .text-center {
            text-align: center;
        }
        .text-end {
            text-align: right;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000;
        }
        .border {
            border: 1px solid #000;
            padding: 8px;
        }
        .mb-0 {
            margin-bottom: 0;
        }
        .mb-1 {
            margin-bottom: 5px;
        }
        .mb-2 {
            margin-bottom: 10px;
        }
        .my-4 {
            margin: 20px 0;
        }
        .mt-4 {
            margin-top: 20px;
        }
        .mt-5 {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-primary">Invoice</h1>
        <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
        <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date }}</p>
        <p><strong>Due Date:</strong> {{ $invoice->due_date ?? '-' }}</p>
        <p><strong>Status:</strong> {{ $invoice->status ?? 'Pending' }}</p>
        <hr class="mb-4">
    
        <h3 class="text-primary">Order Details</h3>
        <p><strong>Order ID:</strong> {{ $transaction->order_id }}</p>
        <p><strong>Customer Name:</strong> {{ $transaction->customer->name }}</p>
        <p><strong>Order Date:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
        <hr class="mb-4">
    
        <h3 class="text-primary">Order Items</h3>
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
                        <td>{{ $item->service->service ?? 'N/A' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ number_format($item->amount, 2) }}</td>
                        <td>{{ number_format($item->qty * $item->amount, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        <h3 class="text-primary">Tax Summary</h3>
        <table class="table table-bordered">
            <tr>
                <th>PPN Amount</th>
                <td class="text-end">{{ number_format($taxInvoice->ppn_amount, 2) }}</td>
            </tr>
            <tr>
                <th>PPh Amount</th>
                <td class="text-end">{{ number_format($taxInvoice->pph_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Total Tax</th>
                <td class="text-end">{{ number_format($taxInvoice->ppn_amount + $taxInvoice->pph_amount, 2) }}</td>
            </tr>
        </table>
    
        <h3 class="text-primary">Order Summary</h3>
        <table class="table table-bordered">
            <tr>
                <th>Total Amount</th>
                <td class="text-end">{{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Net Amount</th>
                <td class="text-end">{{ number_format($invoice->total_amount - ($taxInvoice->ppn_amount + $taxInvoice->pph_amount), 2) }}</td>
            </tr>
        </table>

        <h3 class="text-primary">Company Details</h3>
        <p><strong>Bank Account Number:</strong> {{ config('app.bank_account') }}</p>
        <p><strong>Address:</strong> {{ config('app.address') }}</p>
        <p><strong>Phone Number:</strong> {{ config('app.phone') }}</p>
    </div>
</body>
</html>
