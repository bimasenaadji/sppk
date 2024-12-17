<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
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
        $data = Transaction::with(['customer', 'taxCategory'])->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('customer_name', function ($row) {
                return $row->customer ? $row->customer->name : '-';
            })
            ->addColumn('transaction_type', function ($row) {
                return $row->taxCategory ? $row->taxCategory->transaction_type : '-';
            })
            ->make(true);
    }
    public function printReceipt($transactionId)
    {
        $transaction = Transaction::with('order')->findOrFail($transactionId);
        return view('transactions.receipt', compact('transaction'));
    }
}
