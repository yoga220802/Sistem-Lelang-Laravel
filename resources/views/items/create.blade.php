<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Item</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Create New Item</h1>
        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Item Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group">
                <label for="starting_price">Starting Price</label>
                <input type="number" class="form-control" id="starting_price" name="starting_price" required>
            </div>
            <div class="form-group">
                <label for="image">Item Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="auction_id">Select Auction</label>
                <select class="form-control" id="auction_id" name="auction_id" required>
                    <!-- Options will be populated from the database -->
                    @foreach($auctions as $auction)
                        <option value="{{ $auction->id }}">{{ $auction->title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Item</button>
        </form>
    </div>
    @endsection

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>