@extends('layouts.app')

@section('title', 'Data Signa')
@push('styles')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<h2 class="h4 fw-bold mb-3">💊 Data Aturan Pakai (Signa)</h2>

<!-- @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif -->

<!-- Tambah Signa Form -->
<form method="POST" action="{{ route('signa.store') }}" class="row g-3 mb-4">
    @csrf
    <div class="col-md-4">
        <input type="text" name="signa_nama" class="form-control" placeholder="Nama Signa" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="signa_kode" class="form-control" placeholder="Kode Signa" required>
    </div>
    <div class="col-md-4">
        <input type="text" name="additional_data" class="form-control" placeholder="Keterangan (opsional)">
    </div>
    <div class="col-md-4">
        <button type="submit" class="btn btn-success">➕ Tambah</button>
    </div>
</form>

<!-- Tabel Signa -->
<table id="signaTable" class="table table-bordered">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Kode Signa</th>
            <th>Nama Signa</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $signa)
        <tr>
                @csrf
                @method('PUT')
                <td>{{ $signa->signa_id }}</td>
                <td>{{ $signa->signa_kode }}</td>
                <td>{{ $signa->signa_nama }}</td>
                <td>{{ $signa->additional_data }}</td>
<td class="d-flex gap-1">
    <button 
        type="button"
        class="btn btn-warning btn-sm" 
        data-bs-toggle="modal"
        data-bs-target="#editModal"
        data-id="{{ $signa->signa_id }}"
        data-kode="{{ $signa->signa_kode }}"
        data-nama="{{ $signa->signa_nama }}"
        data-keterangan="{{ $signa->additional_data }}">
        ✏️ Edit
    </button>

    <form method="POST" action="{{ route('signa.delete', $signa->signa_id) }}" onsubmit="return confirm('Hapus data ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm">🗑️</button>
    </form>
</td>


        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Edit Signa -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="editForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit Signa</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="editSignaId">
          <div class="mb-2">
            <label>Kode Signa</label>
            <input type="text" name="signa_kode" id="editSignaKode" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Nama Signa</label>
            <input type="text" name="signa_nama" id="editSignaNama" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Keterangan</label>
            <textarea name="additional_data" id="editSignaKet" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-success">💾 Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signaTable').DataTable({
            language: {
                search: "🔍 Cari:",
                lengthMenu: "Tampilkan _MENU_ data per halaman",
                zeroRecords: "Tidak ditemukan data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data tersedia",
                paginate: {
                    previous: "⏮️",
                    next: "⏭️"
                }
            }
        });

        // Setup data di modal saat edit
        const editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const kode = button.getAttribute('data-kode');
            const keterangan = button.getAttribute('data-keterangan');

            document.getElementById('editSignaNama').value = nama;
            document.getElementById('editSignaKode').value = kode;
            document.getElementById('editSignaKet').value = keterangan;

            document.getElementById('editForm').action = `/signa/${id}/update`;
        });
    });
</script>
@endpush

<script>
    const editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const nama = button.getAttribute('data-nama');
        const kode = button.getAttribute('data-kode');
        const keterangan = button.getAttribute('data-keterangan');

        // Isi nilai input di modal
        document.getElementById('editSignaNama').value = nama;
        document.getElementById('editSignaKode').value = kode;
        document.getElementById('editSignaKet').value = keterangan;

        const form = document.getElementById('editForm');
        form.action = `/signa/${id}/update`; // Sesuaikan route update kamu
    });
</script>
