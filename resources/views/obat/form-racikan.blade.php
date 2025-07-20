@extends('layouts.app')

@section('title', 'Racikan Obat AJAX')

@section('content')
<h3 class="mb-4">🧪 Buat Racikan Obat (AJAX)</h3>

<form action="{{ route('obat.storeRacikan') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Nama Racikan</label>
        <input type="text" class="form-control" name="racikan_nama" required>
    </div>

    <div id="obat-container">
        <div class="obat-row mb-3 row">
            <div class="col-md-6">
                <label>Obat</label>
                <select class="form-control obat-select" name="obat_id[]" required></select>
            </div>
            <div class="col-md-2">
                <label>Qty</label>
                <input type="number" class="form-control" name="qty[]" min="1" required>
            </div>
            <div class="col-md-3">
                <label>Signa</label>
                <select class="form-control" name="signa_id[]" required>
                    @foreach ($signaList as $signa)
                        <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-row">✖</button>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-3" id="add-row">➕ Tambah Obat</button>

    <button type="submit" class="btn btn-primary">💾 Simpan Racikan</button>
</form>
@endsection

@push('scripts')
<script>
    function initSelect2() {
        $('.obat-select').select2({
            placeholder: 'Cari Obat...',
            ajax: {
                url: '{{ route("ajax.obat.search") }}',
                dataType: 'json',
                delay: 250,
                data: params => ({ q: params.term }),
                processResults: data => ({ results: data }),
                cache: true
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initSelect2();

document.getElementById('add-row').addEventListener('click', function () {
    let container = document.getElementById('obat-container');

    let newRow = document.createElement('div');
    newRow.classList.add('obat-row', 'mb-3', 'row');
    newRow.innerHTML = `
        <div class="col-md-6">
            <label>Obat</label>
            <select class="form-control obat-select" name="obat_id[]" required></select>
        </div>
        <div class="col-md-2">
            <label>Qty</label>
            <input type="number" class="form-control" name="qty[]" min="1" required>
        </div>
        <div class="col-md-3">
            <label>Signa</label>
            <select class="form-control" name="signa_id[]" required>
                @foreach ($signaList as $signa)
                    <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <button type="button" class="btn btn-danger remove-row">✖</button>
        </div>
    `;

    container.appendChild(newRow);
    $(newRow).find('.obat-select').select2({
        placeholder: 'Cari Obat...',
        ajax: {
            url: '{{ route("ajax.obat.search") }}',
            dataType: 'json',
            delay: 250,
            data: params => ({ q: params.term }),
            processResults: data => ({ results: data }),
            cache: true
        }
    });
});


        document.getElementById('obat-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-row')) {
                const row = e.target.closest('.obat-row');
                if (document.querySelectorAll('.obat-row').length > 1) {
                    row.remove();
                }
            }
        });
    });
</script>
@endpush
