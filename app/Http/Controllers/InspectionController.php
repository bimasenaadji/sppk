<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Inspection;
use App\Models\Report;
use App\Models\User;
use PDF; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class InspectionController extends Controller
{
     public function index()
    {
        $users = User::all();
        $reports = Report::whereDoesntHave('inspection')->where('status', 'baru')->get();

        return view('inspect.index', compact('users', 'reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
            'inspected_by' => 'required|exists:users,id',
            'severity_level' => 'required|in:normal,sedang,tinggi',
            'corrective_action' => 'required|string',
            'preventive_action' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('inspections', 'public');
        }

        $inspection = Inspection::create([
            'report_id' => $request->report_id,
            'inspected_by' => $request->inspected_by,
            'severity_level' => $request->severity_level,
            'corrective_action' => $request->corrective_action,
            'preventive_action' => $request->preventive_action,
            'image' => $imagePath,
        ]);

         // Simpan image jika ada
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('inspections', 'public');

        Image::create([
            'report_id' => $request->report_id,
            'uploaded_by' => Auth::id(),
            'context' => 'inspection',
            'image_path' => $imagePath,
            'only_for_print' => false, // atau sesuaikan dengan kebutuhanmu
        ]);
    }


        Report::where('id', $request->report_id)->update(['status' => 'proses']);

        return redirect()->route('inspect.index')->with('success', 'Inspeksi berhasil ditambahkan.');
    }

    public function finish($id)
{
    $report = Report::findOrFail($id);

    if ($report->status !== 'selesai') {
        $report->update(['status' => 'selesai']);
    }

    return redirect()->back()->with('success', 'Laporan berhasil diselesaikan.');
}


    public function data(Request $request)
{
    $data = Inspection::with(['report', 'inspector'])->latest();

    return DataTables::of($data)
        ->addIndexColumn() // <-- ini yang menambahkan DT_RowIndex
        ->addColumn('id', function ($row) {
            return $row->report ? $row->id : '-';
        })
        ->addColumn('severity_level', function ($row) {
            return ucfirst($row->severity_level);
        })
        ->addColumn('corrective_action', function ($row) {
            return $row->corrective_action;
        })
        ->addColumn('preventive_action', function ($row) {
            return $row->preventive_action;
        })
        ->addColumn('status', function ($row) {
            return $row->report ? $row->report->status : '-';
        })
        ->addColumn('action', function ($row) {
            return '
                <button class="btn btn-sm btn-primary" data-id="'.$row->id.'">Edit</button>
                <button class="btn btn-sm btn-danger" data-id="'.$row->id.'">Hapus</button>
            ';
        })
        ->rawColumns(['action']) // <-- Tambahkan ini!
        ->make(true);
}

public function generateInvoice($id)
{
    $inspect = Inspection::with([
        'report.documentation',
        'report.reporter'
    ])->findOrFail($id);

    $report = $inspect->report;
    $documentation = $report->documentation;
    

    return Pdf::loadView('inspect.invoice', compact('inspect', 'report', 'documentation'))
        ->stream("invoice_inspection_{$inspect->id}.pdf");
}



public function preInspectionImages()
{
    return $this->hasMany(Image::class)->where('context', 'pre_inspection');
}

public function postInspectionImages()
{
    return $this->hasMany(Image::class)->where('context', 'post_inspection');
}




public function delete($id)
{
    $inspection = Inspection::findOrFail($id);

    // Update status report terkait jadi 'baru'
    $report = $inspection->report;  // Pastikan relasi Inspection->report ada
    if ($report) {
        $report->status = 'Baru';
        $report->save();
    }

    // Hapus inspeksi
    $inspection->delete();

    return response()->json(['message' => 'Inspeksi berhasil dihapus dan status laporan diubah menjadi baru']);
}




}
