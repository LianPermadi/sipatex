@extends('layouts.app')
@section('content')
<h3>📜 Riwayat Checkout Racikan</h3>

@foreach($riwayat as $nama => $items)
    <div class="card mb-3">
        <div class="card-header fw-bold bg-info text-white">{{ $nama }}</div>
        <div class="card-body">
            <ul>
                @foreach($items as $item)
                    <li>{{ $item->obat->obatalkes_nama ?? '-' }} — Qty: {{ $item->qty }} — {{ $item->signa->signa_nama ?? '-' }} — <small>{{ $item->checkout_at }}</small></li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach
@endsection
