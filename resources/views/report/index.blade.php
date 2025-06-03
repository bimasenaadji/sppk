@extends('layouts.app')

@section('title', 'Data Laporan')

@section('content')
    <h1 class="mt-2 mb-4">Data Laporan</h1>

    <div class="mb-3">
        <button type="button" class="btn btn-success-dark" id="btn-add-report" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Laporan
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered" id="reportTable">
        <thead>
            <tr>
                <th>No</th>
                <th>No. Laporan</th>
                <th>Area Kejadian</th>
                <th>Jenis Kecelakaan</th>
                <th>Tanggal Kejadian</th> 
                <th>Nama Pelapor</th>
                <th>Nama Korban</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    {{-- Modal Tambah Data --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="reportForm" action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reporter_id" class="form-label">Nama Pelapor</label>
                            <select name="reporter_id" class="form-select" required>
                                <option value="">-- Pilih Pelapor --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="victim" class="form-label">Nama Korban</label>
                            <select name="victim" class="form-select" required>
                                <option value="">-- Pilih Korban --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="incident_area" class="form-label">Area Kejadian</label>
                            <input type="text" name="incident_area" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="incident_type" class="form-label">Jenis Kecelakaan</label>
                            <input type="text" name="incident_type" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="incident_date" class="form-label">Tanggal Kejadian</label>
                            <input type="date" name="incident_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
    <label for="description" class="form-label">Keterangan</label>
    <textarea name="description" class="form-control" rows="3" required></textarea>
</div>

                        <div class="mb-3">
                            <label for="documentation" class="form-label">Dokumentasi Gambar</label>
                            <input type="file" name="documentation[]" class="form-control" multiple>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
@endsection

@push('js')
<script>
    $(document).ready(function () {
        $('#reportTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('report.data') }}',
            columns: [
                { data: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'report_number', name: 'report_number' },
                { data: 'incident_area', name: 'incident_area' },
                { data: 'incident_type', name: 'incident_type' },
                { data: 'incident_date', name: 'incident_date' },
                { data: 'reporter_name', name: 'reporter_name' },
                { data: 'victim', name: 'victim' },
                { 
                    data: 'status', 
                    render: function (data) {
                        const badgeMap = {
                            'pending': 'badge bg-warning text-white',
                            'proses': 'badge bg-primary text-white',
                            'selesai': 'badge bg-success text-white',
                        };
                        return `<span class="${badgeMap[data] || 'badge bg-secondary'}">${data}</span>`;
                    } 
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return `
                            <a href="/inspect" class="btn btn-sm btn-warning btn-action">
                                Inspeksi
                            </a> 
                            <form action="/report/${data.id}/delete" method="POST" class="d-inline btn-action" onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Hapus
                                </button>
                            </form>
                        `;
                    }
                }
            ]
        });

        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                $.ajax({
                    url: `/report/${id}/delete`,
                    type: 'DELETE',
                    data: { _token: csrf },
                    success: function () {
                        $('#inspectTable').DataTable().ajax.reload();
                        alert('Transaksi berhasil dihapus.');
                    },
                    error: function () {
                        alert('Gagal menghapus transaksi.');
                    }
                });
            }
        });
    });
</script>
@endpush
