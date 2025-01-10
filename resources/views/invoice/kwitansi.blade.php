<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi - {{ $invoice->invoice_number }}</title>
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
        .table-bordered th {
            background-color: #f2f2f2;
        }
        .border {
            border: 1px solid #000;
            padding: 8px;
        }
        .border-dotted {
            border: 1px dotted #000;
        }
        header {
            margin-bottom: 20px;
        }
        header .row {
            display: flex;
            align-items: center;
        }
        header .col-2 img {
            width: 100px;
            height: 70px;
        }
        header .col-10 {
            margin-left: 20px;
        }
        .row {
            display: flex;
        }
        .col-6 {
            width: 50%;
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
        .py-2 {
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="mb-4">
            <div class="row">
                <div class="col-2">
                    <img src="{{ asset('uploads/' . config('app.logo')) }}" alt="Logo">
                </div>
                <div class="col-10">
                    <h3 class="text-primary mb-1">{{ config('app.name') }}</h3>
                    <p class="mb-0">{{ config('app.address') }}</p>
                    <p class="mb-0">Website: {{ config('app.website') }} | No. HP: {{ config('app.phone') }}</p>
                </div>
            </div>
        </header>

        <!-- Title -->
        <div class="text-center">
            <h2 class="fw-bold mb-2">KWITANSI</h2>
            <hr>
        </div>

        <!-- Invoice Information -->
        <section class="mt-4">
            <p class="mb-1">Tanggal: <strong>{{ $invoice->transaction->created_at->format('l, d F Y') }}</strong></p>
            <p class="mb-1">Kepada Yth:</p>
            <p class="fw-bold mb-1">{{ $invoice->transaction->customer->name }}</p>
            <p class="mb-1">{{ $invoice->transaction->customer->address }}</p>
        </section>

        <!-- Transaction Details -->
        <section class="mt-4">
            <table class="table table-borderless">
                <tbody>
                    <tr>
                        <td width="150">Nomor Invoice</td>
                        <td width="3">:</td>
                        <td>{{ $invoice->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td width="150">Transaction ID</td>
                        <td width="3">:</td>
                        <td>{{ $invoice->transaction->id }}</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <!-- Items Table -->
        <section class="mt-4">
            <table class="table table-bordered">
                <thead class="text-center">
                    <tr>
                        <th width="5%">No.</th>
                        <th>Nama Item</th>
                        <th>Quantity</th>
                        <th>Harga Satuan</th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->transaction->orderItems as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->service->service }}</td>
                            <td class="text-center">{{ $item->qty }}</td>
                            <td class="text-end">Rp{{ number_format($item->amount, 2) }}</td>
                            <td class="text-end">Rp{{ number_format($item->total_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- Total and Terbilang -->
        <section class="mt-4">
            <table class="table table-borderless">
                <tr>
                    <td class="fw-bold">Terbilang:</td>
                    <td class="text-end fw-bold">Total</td>
                    <td class="text-end fw-bold border">Rp{{ number_format($invoice->transaction->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="fst-italic fw-bold">
                        {{ ucwords(\Terbilang::make($invoice->transaction->total_amount)) }} Rupiah
                    </td>
                </tr>
            </table>
        </section>

        <!-- Signature -->
        <footer class="mt-5" style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="text-align: center; width: 45%;">
                <p>Diterima oleh:</p>
                <br><br>
                <p class="border-dotted py-2">{{ $invoice->transaction->customer->name }}</p>
            </div>
            <div style="text-align: center; width: 45%;">
                <p>Diserahkan oleh:</p>
                <br><br>
                <p class="border-dotted py-2">{{ auth()->user()->name }}</p>
                <h4 class="mt-0">{{ config('app.name') }}</h4>
            </div>
        </footer>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>
