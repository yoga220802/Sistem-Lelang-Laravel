@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Completed Auctions</h1>

    <div class="row">
        <div class="col-md-12">
            <h2>Sold Items</h2>
            <div class="row">
                @foreach($completedAuctions->where('user_id', '!=', null) as $auction)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-lg border-0 rounded-lg">
                            <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $auction->item->name }}</h5>
                                <p class="card-text"><strong>Final Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                                <p class="card-text"><strong>Buyer:</strong> {{ $auction->user->name }}</p>
                                <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3 w-100">View Details</a>
                                <form action="{{ route('auctions.sendInvoice', $auction->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">Send Invoice</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-12">
            <h2>Unsold Items</h2>
            <div class="row">
                @foreach($completedAuctions->where('user_id', null) as $auction)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-lg border-0 rounded-lg">
                            <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $auction->item->name }}</h5>
                                <p class="card-text"><strong>Final Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                                <p class="card-text text-muted">No buyer</p>
                                <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3 w-100">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
    .img-fixed-size {
        height: 200px;
        object-fit: cover;
    }

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
    }

    .card:hover {
        transform: scale(1.02);
    }

    .shadow-lg {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .shadow-lg:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
    }
</style>
@endsection