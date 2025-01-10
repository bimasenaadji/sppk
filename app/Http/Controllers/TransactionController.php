<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Service;
use App\Models\TaxInvoice;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {

        $transactions = Transaction::with(['orderItems.service'])->get(); // Mengambil semua transaksi beserta item order dan layanan terkait

        return view('transaction.index', compact('transactions'));
    }
    public function status()
    {
        return view('transaction.status');
    }

    public function data()
    {
        $transactions = Transaction::with(['customer', 'taxCategory'])->select('transactions.*');
        return DataTables::of($transactions)
            ->addIndexColumn()
            ->addColumn('customer_name', fn($row) => $row->customer->name)
            ->addColumn('tax_category_name', fn($row) => $row->taxCategory->transaction_type)
            ->addColumn('total_amount', fn($row) => $row->total_amount)
            ->make(true);
    }
    public function showInvoice($id)
    {
        $transaction = Transaction::with(['customer', 'taxCategory', 'orderItems.service'])->findOrFail($id);

        $invoice = Invoice::where('transaction_id', $transaction->id)->first();

        if ($invoice) {
            $taxInvoice = TaxInvoice::updateOrCreate(
                ['invoice_id' => $invoice->id],
                [
                    'tax_invoice_number' => 'TAX-' . $invoice->invoice_number,
                    'ppn_amount' => $invoice->total_amount * ($transaction->taxCategory->tax_ppn / 100),
                    'pph_amount' => $invoice->total_amount * ($transaction->taxCategory->tax_pph / 100),
                ]
            );

            $pdf = Pdf::loadView('transaction.print-invoice', compact('transaction', 'invoice', 'taxInvoice'));

            return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
        }

        $totalAmount = $transaction->orderItems->sum(function ($item) {
            return $item->amount * $item->qty;
        });

        $invoiceData = [
            'transaction_id' => $transaction->id,
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . $transaction->id,
            'invoice_date' => now(),
            'due_date' => now()->addDays(7),
            'total_amount' => $totalAmount,
            'status' => 'belum_dibayar',
        ];

        $invoice = Invoice::create($invoiceData);

        $taxInvoice = TaxInvoice::create([
            'invoice_id' => $invoice->id,
            'tax_invoice_number' => 'TAX-' . $invoice->invoice_number,
            'ppn_amount' => $totalAmount * ($transaction->taxCategory->tax_ppn / 100),
            'pph_amount' => $totalAmount * ($transaction->taxCategory->tax_pph / 100),
        ]);

        $pdf = Pdf::loadView('transaction.print-invoice', compact('transaction', 'invoice', 'taxInvoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
