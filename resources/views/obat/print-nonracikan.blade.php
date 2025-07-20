@extends('layouts.app')

@section('title', 'Print Checkout Non-Racikan')

@section('content')
<div class="card">
    <div class="card-header">🧾 Bukti Checkout Obat Non-Racikan</div>
    <div class="card-body">
        <p><strong>Kode Checkout:</strong> {{ $checkout->kode }}</p>
        <p><strong>Tanggal:</strong> {{ $checkout->tanggal->format('d M Y H:i') }}</p>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Obat</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($checkout->transaksis as $item)
                    <tr>
                        <td>{{ $item->obat->obatalkes_nama }}</td>
                        <td>{{ $item->qty }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('obat.index') }}" class="btn btn-secondary">🔙 Kembali</a>
        <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak</button>
    </div>
</div>
@endsection
