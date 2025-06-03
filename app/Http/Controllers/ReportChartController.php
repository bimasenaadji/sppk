<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportChartController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startDate = $now->copy()->subYear()->startOfMonth();

        // Ambil data laporan dalam 1 tahun terakhir, group by bulan dan status inspeksi
        $reports = Report::select(
                DB::raw("DATE_FORMAT(incident_date, '%Y-%m') as month"),
                DB::raw('COUNT(CASE WHEN EXISTS (SELECT 1 FROM inspections WHERE inspections.report_id = reports.id) THEN 1 END) as inspected'),
                DB::raw('COUNT(CASE WHEN NOT EXISTS (SELECT 1 FROM inspections WHERE inspections.report_id = reports.id) THEN 1 END) as not_inspected')
            )
            ->whereBetween('incident_date', [$startDate, $now])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Siapkan data array bulan untuk grafik lengkap 12 bulan dari $startDate
        $labels = [];
        $inspectedData = [];
        $notInspectedData = [];

        for ($i = 0; $i < 12; $i++) {
            $month = $startDate->copy()->addMonths($i)->format('Y-m');
            $labels[] = $startDate->copy()->addMonths($i)->format('M Y');

            // Cari data laporan di bulan ini
            $record = $reports->firstWhere('month', $month);
            $inspectedData[] = $record ? (int)$record->inspected : 0;
            $notInspectedData[] = $record ? (int)$record->not_inspected : 0;
        }

        return view('report.chart', compact('labels', 'inspectedData', 'notInspectedData'));
    }
}
