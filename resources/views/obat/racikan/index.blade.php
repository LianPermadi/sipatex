@extends('layouts.app')
@section('title', 'List Racikan')

@section('content')
<h3 class="mb-4">🧾 Daftar Racikan Obat</h3>

<div class="mb-3">
    <input type="text" class="form-control" id="searchRacikan" placeholder="🔍 Cari Nama Racikan...">
</div>

@foreach($racikan as $nama => $data)
    <div class="card mb-3 racikan-card">
        <div class="card-header d-flex justify-content-between align-items-center {{ $data['status'] == 'tersedia' ? 'bg-success' : 'bg-danger' }} text-white">
            <span class="fw-bold">{{ $nama }}</span>
            <div>
                <span class="badge bg-light text-dark me-2">{{ $data['status'] == 'tersedia' ? '✅ Tersedia' : '❌ Tidak Tersedia' }}</span>
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
                <div class="text-warning mt-2">⚠️ Kekurangan: {{ implode(', ', $data['keterangan']) }}</div>
            @endif
        </div>
    </div>
@endforeach

{{-- Modal --}}
@include('obat.racikan.modal-edit', ['signaList' => $signaList])
@endsection

@push('scripts')
<script>
    const signaOptions = `{!! collect($signaList)->map(fn($s) => "<option value='$s->signa_id'>$s->signa_nama</option>")->implode('') !!}`;

    function initSelect2Obat(context) {
        $(context).find('.obat-select2').select2({
            placeholder: '🔍 Cari Obat...',
            dropdownParent: $('#editRacikanModal'),
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

    $(document).ready(function () {
        // 🔍 Search racikan
        $('#searchRacikan').on('keyup', function () {
            const keyword = $(this).val().toLowerCase();
            $('.racikan-card').each(function () {
                const title = $(this).find('.fw-bold').text().toLowerCase();
                $(this).toggle(title.includes(keyword));
            });
        });

        // ✏️ Buka modal edit
        $('.btn-edit').on('click', function () {
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
                            <select name="signa_id[]" class="form-select" required>${signaOptions}</select>
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

        // ➕ Tambah baris
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
                        <select name="signa_id[]" class="form-select" required>${signaOptions}</select>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-edit">✖</button>
                    </div>
                </div>
            `);
            $('#edit-obat-list').append(newRow);
            initSelect2Obat(newRow);
        });

        $('#editRacikanModal').on('click', '.btn-remove-edit', function () {
            $(this).closest('.obat-edit-row').remove();
        });
    });
</script>
@endpush
