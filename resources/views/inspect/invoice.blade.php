<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inspeksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.5; }
        .logo { float: right; }
        .section { margin-bottom: 20px; }
        .title { text-align: center; font-size: 18px; font-weight: bold; margin-top: 20px; }
        .label { font-weight: bold; width: 160px; display: inline-block; }
        .page-break { page-break-after: always; }
        img { margin-top: 10px; }
    </style>
</head>
<body>
    {{-- LEMBAR 1 --}}
    <img src="{{ 'file://' . public_path('assets/img/logo.png') }}" class="logo" width="100" />

    <div class="title">LAPORAN KECELAKAAN KERJA</div>
    <p><strong>NO LAPORAN:</strong> {{ $report->report_number }}</p>

    <div class="section">
        <h4>Data Pelapor</h4>
        <p><span class="label">Nama:</span> {{ $report->reporter->name ?? '-' }}</p>
        <p><span class="label">Jabatan:</span> {{ $report->reporter->position ?? '-' }}</p>
        <p><span class="label">No. HP:</span> {{ $report->reporter->phone ?? '-' }}</p>
        <p><span class="label">Email:</span> {{ $report->reporter->email ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Data Korban</h4>
        <p><span class="label">Nama:</span> {{ $report->victim ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Area Kejadian</h4>
        <p>{{ $report->incident_area ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Jenis Kecelakaan</h4>
        <p>{{ $report->incident_type ?? '-' }}</p>
    </div>

    <div class="section">
        <h4>Deskripsi</h4>
        <p>{{ $documentation->note ?? '-' }}</p>
    </div>

    <div class="section">
    <h4>Dokumentasi</h4>
    @php
        $reportImages = $report->images->where('context', 'report');
    @endphp

    @if ($reportImages->count())
        @foreach ($reportImages as $image)
            <img src="{{ public_path('storage/' . $image->image_path) }}" width="200" style="margin-bottom: 10px;">
        @endforeach
    @else
        <p>-</p>
    @endif
</div>


    <div class="page-break"></div>

    {{-- LEMBAR 2 --}}
    <img src="{{ 'file://' . public_path('assets/img/logo.png') }}" class="logo" width="100" />
    <div class="title">LAPORAN KECELAKAAN KERJA</div>

<div class="section">
    <h4>Dokumentasi Lanjutan</h4>
    @php
        $inspectionImages = $report->images->where('context', 'inspection');
    @endphp

    @if ($inspectionImages->count())
        @foreach ($inspectionImages as $image)
            <img src="{{ public_path('storage/' . $image->image_path) }}" width="200" style="margin-bottom: 10px;">
        @endforeach
    @else
        <p>-</p>
    @endif
</div>

    <div class="section">
        <h4>Tindakan Korektif</h4>
        <p>{{ $inspect->corrective_action ?? '-' }}</p> 
    </div>
    <div class="section">
        <h4>Tindakan Preventif</h4>
        <p>{{ $inspect->preventive_action ?? '-' }}</p>
    </div>

    <div class="section">   
        <h4>Disusun oleh</h4>
        <p>{{ $report->reporter->name ?? '-' }}</p>
        <p>{{ $report->reporter->position ?? '-' }}</p>
        <p>Tanggal: {{ \Carbon\Carbon::parse($report->incident_date)->isoFormat('D MMMM Y') }}</p>
    </div>
</body>
</html>
