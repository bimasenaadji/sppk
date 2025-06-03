@extends('layouts.app')

@section('title', 'Grafik Laporan')

@section('content')
    <h1 class="mt-2 mb-4">Grafik Laporan Inspeksi</h1>

    <div class="card mb-4">
        <div class="card-body">
            <canvas id="reportChart" height="100"></canvas>
        </div>
    </div>
@endsection

@push('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('reportChart').getContext('2d');

        const labels = @json($labels);
        const inspectedData = @json($inspectedData);
        const notInspectedData = @json($notInspectedData);

        const data = {
            labels: labels,
            datasets: [
                {
                    label: 'Inspected',
                    data: inspectedData,
                    backgroundColor: 'rgba(25, 105, 44, 0.5)',
                    borderColor: 'rgba(25, 105, 44, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: 'Not Inspected',
                    data: notInspectedData,
                    backgroundColor: 'rgba(108, 117, 125, 0.5)',
                    borderColor: 'rgba(108, 117, 125, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Laporan'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Bulan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Grafik Laporan Inspeksi per Bulan'
                    }
                }
            }
        };

        new Chart(ctx, config);
    });
</script>
@endpush
