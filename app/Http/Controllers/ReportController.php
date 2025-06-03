<?php

namespace App\Http\Controllers;

use App\Models\Documentation;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index()
{
    $users = User::all(); // ambil semua user, atau bisa disesuaikan

    return view('report.index', compact('users'));
}

public function getData(Request $request)
{

    $data = Report::with('reporter')->select([
        'id', 
        'report_number',
        'incident_area',
        'incident_type',
        'victim',
        'reporter_id',
        'incident_date',
        'status'
    ]);

    \Carbon\Carbon::setLocale('id');

    return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('reporter_name', function ($row) {
            return $row->reporter ? $row->reporter->name : '-';
        })
        ->editColumn('incident_date', function ($row) {
            return \Carbon\Carbon::parse($row->incident_date)->format('d F Y');
        })
        ->make(true);
}



public function startInspection($id)
{
    $report = Report::findOrFail($id);

    if ($report->status === 'proses') {
        return response()->json([
            'success' => false,
            'message' => 'Laporan sudah dalam proses inspeksi.'
        ], 400);
    }

    $report->status = 'proses';
    $report->save();

    return response()->json([
        'success' => true,
        'message' => 'Laporan masuk ke fase inspeksi.'
    ]);
}

public function store(Request $request)
{
    $request->validate([
        'reporter_id' => 'required|exists:users,id',
        'victim' => 'required|string|max:255',
        'incident_area' => 'required|string|max:255',
        'incident_type' => 'required|string|max:255',
        'incident_date' => 'required|date',
        'description' => 'required|string',
        'documentation.*' => 'nullable|image|max:2048', // opsional
    ]);

    // Simpan laporan dulu
    $report = Report::create([
        'report_number' => 'REP-' . strtoupper(uniqid(3)),
        'incident_area' => $request->incident_area,
        'incident_type' => $request->incident_type,
        'incident_date' => $request->incident_date,
        'reporter_id' => $request->reporter_id,
        'victim' => $request->victim,
        'status' => 'baru',
    ]);

    // Simpan deskripsi ke tabel documentation
Documentation::create([
    'report_id' => $report->id,
    'note' => $request->description, // atau 'note' => $request->note
    'created_by' => auth()->id(), // << ini WAJIB ada!
]);

    // (Opsional) Simpan gambar dokumentasi jika ada
    if ($request->hasFile('documentation')) {
        foreach ($request->file('documentation') as $image) {
            $path = $image->store('documentation_images', 'public');

            \App\Models\Image::create([
                'report_id' => $report->id,
                'uploaded_by' => auth()->id(),
                'image_path' => $path,
                'context' => 'report',
                'only_for_print' => false,
            ]);
        }
    }

    return redirect()->route('report.index')->with('success', 'Laporan berhasil ditambahkan.');
}

public function destroy($id)
{
    $report = Report::with('documentation', 'images')->findOrFail($id);

    // Hapus dokumentasi jika ada
    if ($report->documentation && $report->documentation->file_path) {
        if (Storage::exists($report->documentation->file_path)) {
            Storage::delete($report->documentation->file_path);
        }
        $report->documentation->delete(); // hapus record dari DB
    }

    // Hapus semua gambar terkait
    foreach ($report->images as $image) {
        if ($image->file_path && Storage::exists($image->file_path)) {
            Storage::delete($image->file_path);
        }
        $image->delete();
    }

    // Hapus inspeksi jika ada
    if ($report->inspection) {
        $report->inspection->delete();
    }

    $report->delete();

    return redirect()->route('report.index')->with('success', 'Laporan berhasil dihapus.');
}



}
