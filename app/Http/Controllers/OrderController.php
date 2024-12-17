<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Service;
use App\Models\TaxCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
        $order = Order::findOrFail($id);

        $order->orderItems()->delete();

        $order->delete();

        return redirect()->route('order.index')->with('success', 'Order deleted successfully!');
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
}
