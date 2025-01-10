<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();

        return view('invoice.index', compact('invoices'));
    }
    public function updateStatus($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->status = $invoice->status === 'belum_dibayar' ? 'sudah_dibayar' : 'belum_dibayar';
        $invoice->save();

        return redirect()->route('invoice.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }
    public function printReceipt($id)
    {
        $invoice = Invoice::with('transaction.customer')->findOrFail($id);

        if ($invoice->status !== 'sudah_dibayar') {
            return redirect()->route('invoice.index')->with('error', 'Kwitansi hanya dapat dicetak jika status sudah dibayar.');
        }

        $pdf = Pdf::loadView('invoice.kwitansi', compact('invoice'));
        return $pdf->download('kwitansi-' . $invoice->invoice_number . '.pdf');
    }
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil dihapus.');
    }
}
