@extends('layouts.app')

@section('title', 'Riwayat Checkout Non-Racikan')

@section('content')
<h3>🧾 Riwayat Checkout Obat Non-Racikan</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Nama Obat</th>
            <th>Qty</th>
            <th>Signa</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($riwayat as $r)
        <tr>
            <td>{{ $r->tanggal }}</td>
            <td>{{ $r->obat->obatalkes_nama ?? '-' }}</td>
            <td>{{ $r->qty }}</td>
            <td>{{ $r->signa->signa_nama ?? '-' }}</td>
            <td>
                <a href="{{ route('obat.printNonRacikan', $r->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">🖨️ Print Ulang</a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
@endsection
