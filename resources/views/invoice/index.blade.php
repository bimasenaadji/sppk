@extends('layouts.app')

@section('title', 'Invoice Page')

@section('content')
    <h1 class="mt-2 mb-4">Daftar Invoice</h1>

    <table class="table table-bordered table-striped table-hover" id="orderItemsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Transaction ID</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->transaction_id }}</td>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_date }}</td>
                    <td>{{ $invoice->due_date }}</td>
                    <td>{{ number_format($invoice->total_amount, 2) }}</td>
                    <td>{{ ucfirst($invoice->status) }}</td>
                    <td>{{ $invoice->created_at }}</td>
                    <td>{{ $invoice->updated_at }}</td>
                    <td>
                        <form method="POST" action="{{ route('invoices.updateStatus', $invoice->id) }}" class="d-inline">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-sm btn-primary">
                                Tandai {{ $invoice->status === 'belum_dibayar' ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                            </button>
                        </form>
                        @if ($invoice->status === 'sudah_dibayar')
                            <a href="{{ route('invoices.printReceipt', $invoice->id) }}" class="btn btn-sm btn-success">Cetak Kwitansi</a>
                        @endif
                        <form method="POST" action="{{ route('invoices.destroy', $invoice->id) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus invoice ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        
    </table>
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#orderItemsTable').DataTable({
            paging: true,          
            searching: true,       
            ordering: true,        
            info: true,            
            lengthChange: false,   
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/id.json' 
            }
        });
    });
</script>
@endpush

