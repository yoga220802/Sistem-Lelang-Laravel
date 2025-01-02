<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items for Auction</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1 class="my-4">Items for Auction</h1>
        @can('manage-items')
            <a href="{{ route('items.create') }}" class="btn btn-success mb-3">Create New Item</a>
        @endcan
        <div class="row">
            @foreach($items as $item)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ asset('storage/' . $item->image) }}" class="card-img-top" alt="{{ $item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <p class="card-text">Starting Bid: ${{ number_format($item->starting_price, 2) }}</p>
                            <p class="card-text">Auction Ends: {{ \Carbon\Carbon::parse($item->auction_end)->diffForHumans() }}</p>
                            <a href="{{ route('items.show', $item->id) }}" class="btn btn-primary">View Details</a>
                            @can('manage-items')
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning mt-2">Edit</a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger mt-2">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endsection

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>