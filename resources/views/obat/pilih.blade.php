@extends('layouts.app')

@section('title', 'Pilih Obat')

@section('content')
<div class="card">
    <div class="card-header">Pilih Obat</div>
    <div class="card-body">
        <form action="{{ route('obat.prosesPilih') }}" method="POST">
            @csrf
            <input type="hidden" name="line" value="pilih">
            <div class="mb-3">
                <label for="obat_id" class="form-label">Nama Obat</label>
                    <select name="obat_id" id="obat_id" class="form-select select-obat" required>
                        <option value="">-- Pilih Obat --</option>
                        @foreach ($obatList as $obat)
                            <option value="{{ $obat->obatalkes_id }}">
                                {{ $obat->obatalkes_nama }} ({{ $obat->obatalkes_kode }})
                            </option>
                        @endforeach
                    </select>

            </div>
            <div class="mb-3">
                <label for="qty" class="form-label">qty</label>
                <input type="number" name="qty" class="form-control">
            </div>
            <div class="mb-3">
                <label for="signa_id" class="form-label">Aturan Pakai (Signa)</label>
                <select name="signa_id" id="signa_id" class="form-select select-signa" required>
                    <option value="">-- Pilih Signa --</option>
                    @foreach ($signaList as $signa)
                        <option value="{{ $signa->signa_id }}">{{ $signa->signa_nama }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-primary">Lihat Detail</button>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.select-obat').select2({ placeholder: 'Cari obat...', width: '100%' });
        $('.select-signa').select2({ placeholder: 'Cari aturan pakai...', width: '100%' });
    });
</script>
@endpush


