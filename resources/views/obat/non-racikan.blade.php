@extends('layouts.app')

@section('title', 'Checkout Obat Non-Racikan')

@section('content')
<h3 class="mb-4">💊 Checkout Obat Non-Racikan</h3>

<form method="POST" action="{{ route('obat.nonRacikan.checkout') }}">
    @csrf
    <div class="row">
        @foreach($obatList as $obat)
            <div class="col-md-6 mb-3">
                <div class="card p-3">
                    <strong>{{ $obat->nama }}</strong><br>
                    <small>Stok: {{ $obat->stok }}</small>
                    <input type="hidden" name="obat_id[]" value="{{ $obat->id }}">
                    <input type="number" name="qty[]" class="form-control mt-2" placeholder="Qty" min="0">
                </div>
            </div>
        @endforeach
    </div>
    <button type="submit" class="btn btn-success mt-3">🛒 Checkout dan Print</button>
</form>
@endsection
