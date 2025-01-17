<!-- FILE: resources/views/auctions/show.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $auction->item->name }}</h1>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $auction->item->description }}</p>
                    <p><strong>Starting Price:</strong> ${{ number_format($auction->starting_price, 2) }}</p>
                    <p><strong>Current Highest Bid:</strong> 
                        ${{ number_format($highestBid->amount ?? $auction->starting_price, 2) }}
                        @if($highestBid && $highestBid->user_id == auth()->id())
                            <span class="badge badge-success">(You)</span>
                        @endif
                    </p>
                    @if($auction->status === 'active')
                        <p><strong>Auction Ends In:</strong> <span id="countdown">{{ $auction->end_time->diffInSeconds(now()) }} seconds</span></p>
                    @else
                        <p><strong>Status:</strong> {{ $auction->status === 'ended' ? 'Auction ended' : 'Auction not started' }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $auction->item->image) }}" alt="{{ $auction->item->name }}" class="img-fluid img-card-size">
        </div>
    </div>

    @if(auth()->check() && $auction->status === 'active')
        <form id="bid-form" action="{{ route('auctions.bid', $auction->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="amount">Your Bid:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Place Bid</button>
        </form>
    @elseif(!auth()->check())
        <p>You must <a href="{{ route('login') }}">login</a> to place a bid.</p>
    @endif
</div>

@if($auction->status === 'active')
<script>
    // Countdown timer
    let countdownElement = document.getElementById('countdown');
    let countdown = {{ $auction->end_time->diffInSeconds(now()) }};

    setInterval(() => {
        if (countdown > 0) {
            countdown--;
            let days = Math.floor(countdown / (60 * 60 * 24));
            let hours = Math.floor((countdown % (60 * 60 * 24)) / (60 * 60));
            let minutes = Math.floor((countdown % (60 * 60)) / 60);
            let seconds = countdown % 60;
            countdownElement.textContent = `${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
        } else {
            clearInterval(this);
            countdownElement.textContent = '{{ $auction->status === "ended" ? "Auction ended" : "Auction not started" }}';
        }
    }, 1000);
</script>
@endif

<style>
    .img-card-size {
        max-width: 100%;
        max-height: 300px;
        object-fit: cover;
    }
</style>
@endsection