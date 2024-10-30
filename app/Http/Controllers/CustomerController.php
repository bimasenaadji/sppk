<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index()
    {
        return view('master-customer.index');
    }

    public function data()
    {
        $data = Customer::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json($customer);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'tax_id' => $request->tax_id
        ]);

        return redirect()->route('customer.index')->with('success', 'Berhasil menambahkan customer');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'no_telp' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',

        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($validated);

        return redirect()->route('customer.index')->with('success', 'Customer berhasil diupdate');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'Customer berhasil dihapus');
    }
}
