<!-- FILE: resources/views/auctions/won.blade.php -->

@extends('layouts.participant')

@section('content')
<div class="container">
    <h1 class="my-4 text-center">Lelang yang Dimenangkan</h1>
    <div class="row">
        @foreach($wonAuctions as $auction)
            <div class="col-md-4">
                <div class="card mb-4 shadow-lg border-0 rounded-lg">
                    <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $auction->item->name }}</h5>
                        <p class="card-text"><strong>Final Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                        <p class="card-text"><strong>Won At:</strong> {{ $auction->end_time->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection