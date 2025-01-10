@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $item->name }}</h1>
    <div class="item-details">
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid">
        <p><strong>Description:</strong> {{ $item->description }}</p>
        <p><strong>Starting Price:</strong> ${{ number_format($item->starting_price, 2) }}</p>
        <p><strong>Current Highest Bid:</strong> ${{ number_format($item->current_bid, 2) }}</p>
        <p><strong>Auction Ends In:</strong> <span id="countdown">{{ $item->auction_end_time->diffInSeconds(now()) }} seconds</span></p>
    </div>

    <h2>Bids</h2>
    <ul class="list-group">
        @foreach($bids as $bid)
            <li class="list-group-item">
                <strong>{{ $bid->user->name }}</strong>: ${{ number_format($bid->amount, 2) }} at {{ $bid->created_at->format('H:i:s') }}
            </li>
        @endforeach
    </ul>

    @if(Auth::check())
        <form action="{{ route('auctions.bid', $item->auction_id) }}" method="POST" class="mt-3">
            @csrf
            <div class="form-group">
                <label for="bid_amount">Your Bid:</label>
                <input type="number" name="bid_amount" id="bid_amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Place Bid</button>
        </form>
    @else
        <p class="mt-3">You need to <a href="{{ route('login') }}">login</a> to place a bid.</p>
    @endif
</div>

<script>
    // Countdown timer
    // Countdown timer
let countdownElement = document.getElementById('countdown');
// let countdownTime = {{ $item->auction_end_time->diffInSeconds(now()) }};
let countdownInterval = setInterval(function() {
    if (countdownTime > 0) {
        countdownTime--;
        countdownElement.innerText = countdownTime + ' seconds';
    } else {
        countdownElement.innerText = 'Auction has ended';
        clearInterval(countdownInterval); // Use the interval ID stored in countdownInterval
    }
}, 1000);

</script>
@endsection