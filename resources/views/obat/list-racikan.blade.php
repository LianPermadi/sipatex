@extends('layouts.app')

@section('title', 'List Racikan')

@section('content')
<h3 class="mb-4">🧾 Daftar Racikan Obat</h3>

<div class="mb-3">
    <input type="text" class="form-control" id="searchRacikan" placeholder="🔍 Cari Nama Racikan...">
</div>
<a href="/racikan/buat"><button class="btn btn-primary">Tambah Racikan</button></a>
<a href="/racikan/riwayat"><button class="btn btn-success">History Checkout</button></a>
<!-- Box Detail Racikan -->
<div class="mt-4 mb-3">
    <h5>🧾 Detail Racikan Terpilih:</h5>
    <div id="selectedRacikanDetail" class="border rounded p-3" style="display: none;">
        <ul id="selectedRacikanList"></ul>
    </div>
</div>
<span style="color:red">*</span><small> Ceklis kolom untuk memilih racikan yang akan di checkout</small>
<!-- Tombol Checkout DI LUAR Box -->
<div class="mb-5" id="checkoutWrapper" style="display:none;">
    <form id="checkoutForm" method="POST" action="{{ route('obat.racikan.checkoutMultiple') }}">
        @csrf
        <input type="hidden" name="racikan_nama_list" id="racikan_nama_list">
        <button type="submit" class="btn btn-success">🛒 Checkout Racikan Terpilih</button>
    </form>
</div>



@foreach($racikan as $nama => $data)
    <div class="card mb-3 racikan-card">
        <div class="card-header d-flex justify-content-between align-items-center {{ $data['status'] == 'tersedia' ? 'bg-success' : 'bg-danger' }} text-white">
            <div>
                <input 
                type="checkbox" 
                class="form-check-input me-2 racikan-check" 
                value="{{ $nama }}"
                {{ $data['status'] == 'tidak tersedia' ? 'disabled' : '' }}>

                <span class="fw-bold">{{ $nama }}</span>
            </div>
            <span class="fw-bold">{{ $nama }}</span>
            <div class="d-flex align-items-center gap-2">

                <button class="btn btn-sm btn-warning btn-edit"
                    data-nama="{{ $nama }}"
                    data-items='@json($data["items"])'>✏️ Edit</button>

                <form action="{{ route('obat.racikan.delete', ['nama' => $nama]) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus racikan ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">🗑️ Hapus</button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <ul>
                @foreach($data['items'] as $item)
                    <li>
                        {{ $item->obat->obatalkes_nama ?? 'Obat ID: '.$item->obat_id }} —
                        Qty: {{ $item->qty }} —
                        Signa: {{ $item->signa->signa_nama ?? 'Tidak tersedia' }}
                    </li>
                @endforeach
            </ul>
            @if($data['status'] == 'tidak tersedia')
                <div class="text-warning mt-2">
                    ⚠️ Kekurangan stok: {{ implode(', ', $data['keterangan']) }}
                </div>
            @endif
        </div>
    </div>
@endforeach


<!-- Modal Edit -->
<div class="modal fade" id="editRacikanModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('obat.racikan.update') }}">
        @csrf
        <input type="hidden" name="racikan_nama_lama" id="racikan_nama_lama">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Racikan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label>Nama Racikan</label>
                    <input type="text" name="racikan_nama" id="racikan_nama_input" class="form-control" required>
                </div>
                <div id="edit-obat-list" class="row"></div>
                <button type="button" class="btn btn-secondary btn-sm mb-3" id="add-obat-edit">➕ Tambah Obat</button>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
    const signaOptions = `{!! collect($signaList)->map(fn($s) => "<option value='$s->signa_id'>$s->signa_nama</option>")->implode('') !!}`;

function initSelect2Obat(context) {
    $(context).find('.obat-select2').select2({
        placeholder: '🔍 Cari Obat...',
        dropdownParent: $('#editRacikanModal'), // ⬅️ ini biar dropdown muncul dalam modal
        ajax: {
            url: '{{ route("ajax.obat.search") }}',
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term }),
            processResults: data => ({ results: data }),
            cache: true
        },
        width: '100%'
    });
}

document.addEventListener('DOMContentLoaded', function () {
    const detailBox = $('#selectedRacikanDetail');
    const listBox = $('#selectedRacikanList');
    const btn = $('#checkoutBtn');
    const hiddenInput = $('#racikan_nama_list');

    $('.racikan-check').on('change', function () {
        const selected = $('.racikan-check:checked').map((_, el) => $(el).val()).get();

        if (selected.length === 0) {
            detailBox.hide();
            $('#checkoutWrapper').hide();
            btn.hide();
            listBox.empty();
            return;
        }

        // Kirim AJAX untuk ambil detail
        $.ajax({
            url: '{{ route("ajax.racikan.details") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                racikans: selected
            },
            success: function (data) {
                listBox.empty();
                data.forEach(r => {
                    listBox.append(`<li><strong>${r.nama}</strong><ul>${
                        r.items.map(i => `<li>${i.nama} — Qty: ${i.qty}</li>`).join('')
                    }</ul></li>`);
                });

                detailBox.show();
                $('#checkoutWrapper').show();
                hiddenInput.val(selected.join(','));
            }
        });
    });
});

    document.addEventListener('DOMContentLoaded', function () {
        // 🔍 Search racikan
        $('#searchRacikan').on('keyup', function () {
            const keyword = $(this).val().toLowerCase();
            $('.racikan-card').each(function () {
                const title = $(this).find('.fw-bold').text().toLowerCase();
                $(this).toggle(title.includes(keyword));
            });
        });

        // ✏️ Buka modal edit
        $('.btn-edit').click(function () {
            let nama = $(this).data('nama');
            let items = $(this).data('items');
            $('#racikan_nama_input').val(nama);
            $('#racikan_nama_lama').val(nama);
            const container = $('#edit-obat-list').empty();

            items.forEach(item => {
                const row = $(`
                    <div class="row g-2 align-items-end mb-2 obat-edit-row">
                        <div class="col-md-5">
                            <label>Obat</label>
                            <select class="form-select obat-select2" name="obat_id[]" required>
                                <option value="${item.obat_id}" selected>${item.obat?.obatalkes_nama ?? 'ID: '+item.obat_id}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Qty</label>
                            <input type="number" class="form-control" name="qty[]" value="${item.qty}" required>
                        </div>
                        <div class="col-md-4">
                            <label>Signa</label>
                            <select name="signa_id[]" class="form-select" required>
                                ${signaOptions}
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm btn-remove-edit">✖</button>
                        </div>
                    </div>
                `);
                container.append(row);
                initSelect2Obat(row);
                row.find('select[name="signa_id[]"]').val(item.signa_id);
            });

            $('#editRacikanModal').modal('show');
        });

        // ➕ Tambah baris obat
        $('#add-obat-edit').on('click', function () {
            const newRow = $(`
                <div class="row g-2 align-items-end mb-2 obat-edit-row">
                    <div class="col-md-5">
                        <label>Obat</label>
                        <select class="form-select obat-select2" name="obat_id[]" required></select>
                    </div>
                    <div class="col-md-2">
                        <label>Qty</label>
                        <input type="number" class="form-control" name="qty[]" required>
                    </div>
                    <div class="col-md-4">
                        <label>Signa</label>
                        <select name="signa_id[]" class="form-select" required>
                            ${signaOptions}
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-edit">✖</button>
                    </div>
                </div>
            `);
            $('#edit-obat-list').append(newRow);
            initSelect2Obat(newRow);
        });

        // ✖ Hapus baris
        $('#editRacikanModal').on('click', '.btn-remove-edit', function () {
            $(this).closest('.obat-edit-row').remove();
        });
    });
</script>
@endpush

