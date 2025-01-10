<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Service;
use App\Models\TaxCategory;
use App\Models\TaxInvoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        $services = Service::all();
        return view('order.index', compact('customers', 'services'));
    }
    public function data()
    {
        $data = Order::with('customer')->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($row) {
                return $row->customer ? $row->customer->name : '-';
            })
            ->make(true);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_items' => 'required|array',
            'order_items.*.service_id' => 'required|exists:services,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.amount' => 'required|numeric|min:0'
        ]);

        $totalAmount = collect($request->order_items)->sum(function ($item) {
            return $item['quantity'] * $item['amount'];
        });

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'date' => now(),
            'total' => $totalAmount,
            'status' => 'Pending'
        ]);

        foreach ($request->order_items as $item) {
            $order->orderItems()->create([
                'service_id' => $item['service_id'],
                'qty' => $item['quantity'],
                'amount' => $item['amount'],
                'total_amount' => $item['quantity'] * $item['amount']
            ]);
        }

        return redirect()->route('order.index')->with('success', 'Order created successfully!');
    }

    public function edit($id)
    {
        $order = Order::with(['customer', 'orderItems.service'])->findOrFail($id);

        $customers = Customer::all();
        $services = Service::all();

        return view('order.edit', compact('order', 'customers', 'services'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_items' => 'required|array',
            'order_items.*.service_id' => 'required|exists:services,id',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.amount' => 'required|numeric|min:0'
        ]);

        $order = Order::findOrFail($id);

        $totalAmount = collect($request->order_items)->sum(function ($item) {
            return $item['quantity'] * $item['amount'];
        });

        $order->update([
            'customer_id' => $request->customer_id,
            'total' => $totalAmount,
        ]);

        foreach ($request->order_items as $item) {
            $order->orderItems()->updateOrCreate(
                ['service_id' => $item['service_id']],
                [
                    'qty' => $item['quantity'],
                    'amount' => $item['amount'],
                    'total_amount' => $item['quantity'] * $item['amount']
                ]
            );
        }

        return redirect()->route('order.index')->with('success', 'Order updated successfully!');
    }


    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            $order->orderItems()->delete();

            $order->delete();

            return response()->json(['success' => true, 'message' => 'Order deleted successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete order.']);
        }
    }

    public function cancel(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            if ($order->status === 'cancelled') {
                return response()->json(['success' => false, 'message' => 'Order sudah dibatalkan.'], 400);
            }

            $order->status = 'canceled';
            $order->save();

            return response()->json(['success' => true, 'message' => 'Order berhasil dibatalkan.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Order tidak ditemukan.'], 404);
        } catch (\Exception $e) {
            \Log::error('Error saat membatalkan order: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server.'], 500);
        }
    }





    public function successOrder($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->status = 'paid';
        $invoice->save();

        $order = Order::findOrFail($invoice->order_id);
        if ($order->status === 'success') {
            return back()->with('info', 'Order has already been processed.');
        }

        $order->status = 'success';
        $order->save();

        $taxCategory = TaxCategory::find($order->customer->tax_id);

        $ppnAmount = $order->total * ($taxCategory->tax_ppn / 100);
        $pphAmount = $order->total * ($taxCategory->tax_pph / 100);
        $netAmount = $order->total - $ppnAmount - $pphAmount;

        Transaction::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'tax_categories_id' => $taxCategory->id,
            'total_amount' => $order->total,
            'ppn_amount' => $ppnAmount,
            'pph_amount' => $pphAmount,
            'net_amount' => $netAmount,
        ]);

        return redirect()->route('order.index')->with('success', 'Order marked as success and transaction recorded.');
    }
    public function showInvoice($orderId)
    {
        $order = Order::with(['customer', 'orderItems.service'])->findOrFail($orderId);
        $taxCategories = TaxCategory::all();

        // dd($order->OrderItems);

        return view('order.invoice', compact('order', 'taxCategories'));
    }
    public function confirmOrder(Request $request, $orderId)
    {
        $order = Order::with('customer', 'orderItems')->findOrFail($orderId);

        if ($order->status !== 'pending') {
            return redirect()->route('order.index')->with('error', 'Only orders with status "pending" can be confirmed.');
        }

        $taxCategory = TaxCategory::findOrFail($request->tax_category);

        $totalAfterTaxes = $request->input('total_after_taxes');

        $ppnAmount = $totalAfterTaxes * ($taxCategory->tax_ppn / 100);
        $pphAmount = $totalAfterTaxes * ($taxCategory->tax_pph / 100);
        $netAmount = $totalAfterTaxes;

        $transaction = Transaction::create([
            'order_id' => $order->id,
            'customer_id' => $order->customer_id,
            'tax_categories_id' => $taxCategory->id,
            'total_amount' => $totalAfterTaxes,
            'ppn_amount' => $ppnAmount,
            'pph_amount' => $pphAmount,
            'net_amount' => $netAmount,
        ]);

        $order->update(['status' => 'success']);

        return redirect()->route('order.index')->with('success', 'Order has been confirmed and transaction has been recorded.');
    }




    public function printInvoice(Order $order)
    {
        $order->load(['orderItems', 'customer']);

        $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . $order->id;

        $invoiceDate = now();
        $dueDate = now()->addDays(7);

        $totalAmount = $order->total;

        $invoiceData = [
            'order_id' => $order->id,
            'invoice_number' => $invoiceNumber,
            'invoice_date' => $invoiceDate,
            'due_date' => $dueDate,
            'total_amount' => $totalAmount,
            'status' => 'belum_dibayar',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $invoice = Invoice::create($invoiceData);


        $taxCategory = $order->tax_category;
        $ppnRate = $taxCategory->tax_ppn ?? 0;
        $pphRate = $taxCategory->tax_pph ?? 0;

        $ppnAmount = $totalAmount * ($ppnRate / 100);
        $pphAmount = $totalAmount * ($pphRate / 100);

        $taxInvoiceData = [
            'invoice_id' => $invoice->id,
            'tax_invoice_number' => 'TAX-' . $invoiceNumber,
            'ppn_amount' => $ppnAmount,
            'pph_amount' => $pphAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $taxInvoice = TaxInvoice::create($taxInvoiceData);

        $pdf = Pdf::loadView('/order/print-invoice', compact('order', 'invoice', 'taxInvoice'));

        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');
    }
}
