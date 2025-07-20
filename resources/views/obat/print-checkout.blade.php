@extends('layouts.app')
@section('content')
<h3>🖨️ Bukti Checkout Racikan</h3>
@foreach($data as $nama => $items)
    <div class="mb-4">
        <h5>{{ $nama }}</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Qty</th>
                    <th>Signa</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->obat->obatalkes_nama ?? '-' }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->signa->signa_nama ?? '-' }}</td>
                        <td>{{ $item->checkout_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endforeach

<button class="btn btn-primary" onclick="window.print()">🖨️ Cetak</button>
@endsection
