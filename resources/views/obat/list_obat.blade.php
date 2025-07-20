@extends('layouts.app')

@section('title', 'List Obat')
@push('styles')
<style>
    .toast {
        animation: slideIn 0.5s ease;
    }
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endpush

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
<h2 class="h4 fw-bold mb-4">📦 Data Obat & Alkes</h2>
<a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#tambahObatModal">➕ Tambah Obat</a>
<!-- Modal Tambah Obat -->
<div class="modal fade" id="tambahObatModal" tabindex="-1" aria-labelledby="tambahObatModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('obat.storeinsert_obat') }}">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="tambahObatModalLabel">Tambah Obat</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-2">
            <label>Kode Obat</label>
            <input type="text" name="obatalkes_kode" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Nama Obat</label>
            <input type="text" name="obatalkes_nama" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Stok</label>
            <input type="number" step="0.01" name="stok" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Data Tambahan</label>
            <textarea name="additional_data" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">💾 Simpan</button>
        </div>
      </div>
    </form>
  </div>
</div>


<table id="obatTable" class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Kode</th>
            <th>Nama Obat</th>
            <th>Stok</th>
            <th>Created Date</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->obatalkes_id }}</td>
            <td>{{ $item->obatalkes_kode }}</td>
            <td>{{ $item->obatalkes_nama }}</td>
            <td>{{ $item->stok }}</td>
            <td>{{ $item->created_date }}</td>
            <td>
                <!-- Tombol Update Modal -->
                <button
                    class="btn btn-sm btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#updateModal"
                    data-id="{{ $item->obatalkes_id }}"
                    data-nama="{{ $item->obatalkes_nama }}">
                    Update Stok
                </button>
                <form action="/pilih-obat" method="POST">
                    @csrf
                    <input type="hidden" name="line" value="list">
                    <input type="hidden" name="obat_id" value="{{ $item->obatalkes_id }}">
                    <button type='submit'
                        class="btn btn-sm btn-outline-primary">
                        Detail
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Bootstrap -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="" id="stokForm">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="updateModalLabel">Update Stok</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="action" id="actionType" value="tambah">
          <input type="number" name="jumlah" class="form-control" placeholder="Masukkan jumlah" min="1" required>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" onclick="setAction('tambah')">Tambah</button>
          <button type="submit" class="btn btn-danger" onclick="setAction('kurang')">Kurangi</button>
        </div>
      </div>
    </form>
  </div>
</div>

@if (!empty($stokMenipis))
<div id="toastContainer" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
<script>
    const stokMenipis = json_decode($stokMenipis);
    let delay = 0;

    stokMenipis.forEach((nama, index) => {
        setTimeout(() => {
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-bg-warning border-0 mb-2 show';
            toast.role = 'alert';
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        ⚠️ Stok menipis: <strong>${nama}</strong>
                    </div>
                    <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;
            document.getElementById('toastContainer').appendChild(toast);

            // Auto dismiss after 4s
            setTimeout(() => toast.remove(), 4000);
        }, delay);

        delay += 4500; // jeda antar toast
    });
</script>
@endif


<!-- Script Modal Handling -->
<script>
    const modal = document.getElementById('updateModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const form = document.getElementById('stokForm');
        form.action = `/obat/${id}/update-stok`;
    });

    function setAction(act) {
        document.getElementById('actionType').value = act;
    }
</script>
@endsection
