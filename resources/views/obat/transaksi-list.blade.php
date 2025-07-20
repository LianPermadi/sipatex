@extends('layouts.app')
@section('title', 'Transaksi Obat')

@section('content')
<h2 class="mb-4 fw-bold">🧾 Data Transaksi Obat</h2>

<table class="table table-bordered" id="transaksiTable">
    <thead class="table-dark">
        <tr>
            <th>Nama</th>
            <th>Qty</th>
            <th>Signa</th>
            <th>Tipe</th>
        </tr>
    </thead>
    <tbody>
        @foreach($grouped as $key => $items)
            @if($items->first()->tipe === 'racikan')
                <tr class="table-primary fw-bold">
                    <td colspan="4">🧪 Racikan: {{ $key }}</td>
                </tr>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->obat->obatalkes_nama }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>{{ $item->signa->signa_nama ?? '-' }}</td>
                        <td>Racikan</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td>{{ $items->first()->obat->obatalkes_nama }}</td>
                    <td>{{ $items->first()->qty }}</td>
                    <td>{{ $items->first()->signa->signa_nama ?? '-' }}</td>
                    <td>Non-Racikan</td>
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot>
        <tr class="table-success">
            <td colspan="4" class="fw-bold text-end">
                Total Transaksi Obat: {{ $total }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection
