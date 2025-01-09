<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\TaxInvoice;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction.index');
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
        // Ambil data transaksi berdasarkan ID dengan relasi terkait
        $transaction = Transaction::with(['customer', 'taxCategory', 'orderItems.service'])->findOrFail($id);

        // Generate nomor invoice
        $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . $transaction->id;

        // Tanggal invoice dan due date
        $invoiceDate = now();
        $dueDate = now()->addDays(7);

        // Hitung total_amount jika null
        $totalAmount = $transaction->total_amount;

        if (is_null($totalAmount)) {
            // Jika total_amount tidak tersedia, hitung dari orderItems
            $totalAmount = $transaction->orderItems->sum(function ($item) {
                return $item->amount * $item->qty;
            });
        }

        if (is_null($totalAmount)) {
            // Jika masih null, tampilkan pesan debugging
            dd('Total amount is null', $transaction);
        }

        // Data untuk tabel Invoice
        $invoiceData = [
            'transaction_id' => $transaction->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'total_amount' => $totalAmount,
            'status' => 'belum_dibayar',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Simpan data invoice ke database
        $invoice = Invoice::create($invoiceData);

        // Hitung pajak berdasarkan kategori pajak
        $taxCategory = $transaction->taxCategory;
        $ppnRate = $taxCategory->tax_ppn ?? 0;
        $pphRate = $taxCategory->tax_pph ?? 0;

        $ppnAmount = $totalAmount * ($ppnRate / 100);
        $pphAmount = $totalAmount * ($pphRate / 100);

        // Data untuk tabel Tax Invoice
        $taxInvoiceData = [
            'invoice_id' => $invoice->id,
            'tax_invoice_number' => 'TAX-' . $invoiceNumber,
            'ppn_amount' => $ppnAmount,
            'pph_amount' => $pphAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Simpan data tax invoice ke database
        $taxInvoice = TaxInvoice::create($taxInvoiceData);

        // Generate PDF menggunakan view yang sesuai
        $pdf = Pdf::loadView('transactions.invoice', compact('transaction', 'invoice', 'taxInvoice'));

        // Unduh file PDF
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
