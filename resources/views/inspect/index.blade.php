@extends('layouts.app')

@section('title', 'Inspection Page')

@section('content')
    <h1 class="mt-2 mb-4">Data Laporan Inspeksi</h1>

    <div class="mb-3">
        <button type="button" class="btn btn-success-dark" id="btn-add-transaction" data-bs-toggle="modal" data-bs-target="#modalCreate">
            Tambah Inspeksi
        </button>
    </div>

    <table class="table table-bordered" id="inspectTable">
        <thead>
            <tr>
                <th>Kode Laporan</th>
                <th>Tingkat Keparahan</th>
                <th>Tindakan Korektif</th>
                <th>Tindakan Preventif</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <!-- Modal Create Transaction -->
    <!-- Modal Inspeksi -->
<!-- Modal Inspeksi -->
<div class="modal fade" id="modalCreate" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="inspectForm" method="POST" enctype="multipart/form-data" action="{{ route('inspect.store') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Inspeksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="report_id">Pilih Laporan</label>
            <select name="report_id" class="form-control" required>
              <option value="">-- Pilih Laporan --</option>
              @foreach($reports as $report)
                <option value="{{ $report->id }}">{{ $report->report_number }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="inspected_by">Inspektur</label>
            <select name="inspected_by" class="form-control" required>
              @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="severity_level">Tingkat Keparahan</label>
            <select name="severity_level" class="form-control" required>
              <option value="normal">Normal</option>
              <option value="sedang">Sedang</option>
              <option value="tinggi">Tinggi</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Tindakan Korektif</label>
            <textarea name="corrective_action" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label>Tindakan Preventif</label>
            <textarea name="preventive_action" class="form-control" required></textarea>
          </div>

          <div class="mb-3">
            <label>Upload Gambar Bukti</label>
            <input type="file" name="image" class="form-control" accept="image/*" />
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Inspeksi</button>
        </div>
      </form>
    </div>
  </div>
</div>

    {{-- End Modal Create --}}
@endsection

@push('js')
    <script>
    $(document).ready(function () {
        const csrf = '{{ csrf_token() }}';

        // Initialize DataTable
        $('#inspectTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('inspect.data') }}',
                type: 'GET',
            },
            columns: [
                { data: 'report.report_number', name: 'id' },
                { data: 'severity_level', name: 'severity_level' },
                { data: 'corrective_action', name: 'corrective_action' },
                { data: 'preventive_action', name: 'preventive_action' },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        let actions = '';

                        if (row.report.status === 'selesai') {
                            actions += `<button class="btn btn-secondary btn-sm" onclick="printInvoice(${row.id})">Print</button>`;
                        }

                        actions += `<button class="btn btn-danger btn-sm btn-delete" data-id="${row.id}">Delete</button>`;

                        if (row.report.status !== 'selesai') {
                            actions += `
                                <form method="POST" action="/inspect/${row.report.id}/finish" style="display:inline;">
                                    <input type="hidden" name="_token" value="${csrf}">
                                    <button type="submit" class="btn btn-warning btn-sm">Selesaikan</button>
                                </form>`;
                        }

                        return actions;
                    }
                }
            ]

        });

        // Tambah inspeksi
        $('#btn-add-transaction').click(function () {
            $('#inspectForm')[0].reset();
            $('#inspectForm').attr('action', '{{ route('inspect.store') }}');
        });

        // Hapus transaksi
        $(document).on('click', '.btn-delete', function () {
            const id = $(this).data('id');
            if (confirm('Apakah Anda yakin ingin menghapus transaksi ini?')) {
                $.ajax({
                    url: `/inspect/${id}/delete`,
                    type: 'DELETE',
                    data: { _token: csrf },
                    success: function () {
                        $('#inspectTable').DataTable().ajax.reload();
                    },
                    error: function () {
                        alert('Gagal menghapus transaksi.');
                    }
                });
            }
        });

        // Print invoice
        window.printInvoice = function (id) {
            window.open(`/inspect/${id}/invoice`, '_blank');
        };
    });
</script>

@endpush
