<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auction System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1 class="my-4">Ongoing Auctions</h1>
        <div class="row">
            @foreach($auctions as $auction)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $auction->item->image_url }}" class="card-img-top" alt="{{ $auction->item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->item->name }}</h5>
                            <p class="card-text">Current Bid: ${{ $auction->current_bid }}</p>
                            <p class="card-text">Ends in: <span id="countdown-{{ $auction->id }}">{{ $auction->end_time->diffInSeconds(now()) }} seconds</span></p>
                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary">View Auction</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Countdown timer for each auction
        @foreach($auctions as $auction)
            let countdownElement = document.getElementById('countdown-{{ $auction->id }}');
            let countdownTime = {{ $auction->end_time->diffInSeconds(now()) }};
            setInterval(function() {
                if (countdownTime > 0) {
                    countdownTime--;
                    countdownElement.innerText = countdownTime + ' seconds';
                } else {
                    countdownElement.innerText = 'Auction ended';
                }
            }, 1000);
        @endforeach
    </script>
    @endsection
</body>
</html>