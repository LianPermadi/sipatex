@extends('layouts.app')

@section('title', 'Input Obat Non-Racikan')

@section('content')
<div class="card">
    <div class="card-header fw-bold">📝 Input Obat Non-Racikan</div>
    <div class="card-body">
<form action="{{ route('obat.store') }}" method="POST">
    @csrf

    <h5 class="fw-bold">🟢 Obat Non-Racikan</h5>
    <div class="row mb-4 border p-3">
        <div class="col-md-4">
            <label>Obat</label>
            <select name="nonracik_obat_id" class="form-select" required>
                <option value="">-- Pilih Obat --</option>
                @foreach($obatList as $obat)
                    <option value="{{ $obat->obatalkes_id }}">{{ $obat->obatalkes_nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label>Signa</label>
            <select name="nonracik_signa_id" class="form-select" required>
                <option value="">-- Pilih Signa --</option>
                @foreach($signaList as $signa)
                    <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <label>Qty</label>
            <input type="number" name="nonracik_qty" class="form-control" min="1" required>
        </div>
    </div>
        <button type="submit" class="btn btn-success">💾 Simpan Semua</button>
</form>

<form action="{{ route('obat.store') }}" method="POST">
    @csrf
    <h5 class="fw-bold">🟣 Racikan</h5>
    <div class="mb-2">
        <label>Nama Racikan</label>
        <input type="text" name="racikan_nama" class="form-control" required>
    </div>

    <div id="racikan-container">
        <div class="row racikan-row mb-2">
            <div class="col-md-4">
                <select name="racik_obat_id[]" class="form-select" required>
                    <option value="">-- Pilih Obat --</option>
                    @foreach($obatList as $obat)
                        <option value="{{ $obat->obatalkes_id }}">{{ $obat->obatalkes_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="racik_signa_id[]" class="form-select" required>
                    <option value="">-- Pilih Signa --</option>
                    @foreach($signaList as $signa)
                        <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="racik_qty[]" class="form-control" min="1" placeholder="Qty" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-racikan">❌</button>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-sm btn-info my-2" id="tambah-racikan">➕ Tambah Komposisi</button>
    <br>
    <button type="submit" class="btn btn-success">💾 Simpan Semua</button>
</form>

    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#tambah-racikan').click(function () {
        let row = $('.racikan-row').first().clone();
        row.find('input, select').val('');
        $('#racikan-container').append(row);
    });

    $(document).on('click', '.remove-racikan', function () {
        if ($('.racikan-row').length > 1) {
            $(this).closest('.racikan-row').remove();
        }
    });
</script>
@endpush

