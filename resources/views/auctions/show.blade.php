<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction Details</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>{{ $auction->item->name }}</h1>
        <p><strong>Description:</strong> {{ $auction->item->description }}</p>
        <p><strong>Starting Price:</strong> ${{ number_format($auction->starting_price, 2) }}</p>
        <p><strong>Current Highest Bid:</strong> ${{ number_format($highestBid->amount ?? $auction->starting_price, 2) }}</p>
        <p><strong>Auction Ends In:</strong> <span id="countdown">{{ $auction->end_time->diffInSeconds(now()) }} seconds</span></p>

        <h2>Bids</h2>
        <ul id="bid-list">
            @foreach($bids as $bid)
                <li>{{ $bid->user->name }}: ${{ number_format($bid->amount, 2) }} at {{ $bid->created_at->format('H:i:s') }}</li>
            @endforeach
        </ul>

        @if(auth()->check())
            <form id="bid-form" action="{{ route('bids.store', $auction->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="amount">Your Bid:</label>
                    <input type="number" name="amount" id="amount" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Place Bid</button>
            </form>
        @else
            <p>You must <a href="{{ route('login') }}">login</a> to place a bid.</p>
        @endif
    </div>

    <script>
        // Countdown timer
        let countdownElement = document.getElementById('countdown');
        let countdown = {{ $auction->end_time->diffInSeconds(now()) }};

        setInterval(() => {
            if (countdown > 0) {
                countdown--;
                countdownElement.textContent = countdown + ' seconds';
            } else {
                clearInterval(this);
                alert('Auction has ended!');
                // Optionally, redirect or disable bidding
            }
        }, 1000);
    </script>
    @endsection
</body>
</html>