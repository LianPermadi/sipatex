@extends('layouts.app')

@section('title', 'Print Non-Racikan')

@section('content')
<div class="card">
    <div class="card-header">🖨️ Bukti Checkout Non-Racikan</div>
    <div class="card-body">
        <table class="table">
            <tr><th>Kode</th><td>{{ $checkout->obat->obatalkes_kode }}</td></tr>
            <tr><th>Nama</th><td>{{ $checkout->obat->obatalkes_nama }}</td></tr>
            <tr><th>Qty</th><td>{{ $checkout->qty }}</td></tr>
            <tr><th>Stok Sekarang</th><td>{{ $checkout->obat->stok }}</td></tr>
            <tr><th>Signa</th><td>{{ $checkout->signa->signa_nama }}</td></tr>
            <tr><th>Tanggal</th><td>{{ $checkout->tanggal }}</td></tr>
        </table>
    </div>
</div>

<script>
    window.onload = function () {
        window.print();
        setTimeout(() => {
            window.location.href = "{{ route('checkout.nonracikan.history') }}";
        }, 1500);
    };
</script>
@endsection
