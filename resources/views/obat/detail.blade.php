@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="card">
    <div class="card-header">Detail Obat</div>
    <div class="card-body">
        <form method="POST" action="{{ route('obat.checkoutNonRacikan') }}">
            @csrf
            <input type="hidden" name="obat_id" value="{{ $obat->obatalkes_id }}">
            <input type="hidden" name="qty" value="{{ $qty }}">
            <input type="hidden" name="signa_id" value="{{ $signa->signa_id }}">

            <table class="table">
                <tr>
                    <th>Kode</th>
                    <td>{{ $obat->obatalkes_kode }}</td>
                </tr>
                <tr>
                    <th>Nama</th>
                    <td>{{ $obat->obatalkes_nama }}</td>
                </tr>
                <tr>
                    <th>Qty</th>
                    <td>{{ $qty }}</td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>{{ $obat->stok }}</td>
                </tr>
                <tr>
                    <th>Created Date</th>
                    <td>{{ $obat->created_date }}</td>
                </tr>
                <tr>
                    <th>Aturan Pakai</th>
                    <td>{{ $signa->signa_nama }}</td>
                </tr>
            </table>

            <div class="d-print-none mt-3">
                <button type="submit" class="btn btn-success">🛒 Checkout</button>
                <button type="button" onclick="window.print()" class="btn btn-outline-primary">🖨️ Print</button>
                <a href="{{ $redirect == 'pilih' ? route('obat.formPilih') : route('obat.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
