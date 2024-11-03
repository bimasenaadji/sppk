<?php

namespace App\Http\Controllers;

use App\Models\TaxCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TaxCategoryController extends Controller
{
    public function index()
    {
        return view('tax-category.index');
    }

    public function data()
    {
        $data = TaxCategory::all();
        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }
}
