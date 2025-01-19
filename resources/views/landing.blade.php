@extends('layouts.landing')

@section('content')
<div class="container">
    <h1 class="my-4 text-center display-4 text-primary">Welcome to Our Auction System</h1>
    <p class="text-center">Explore the ongoing, upcoming, and completed auctions. To place a bid, please <a href="{{ route('login') }}">login</a>.</p>

    <!-- Active Auctions -->
    <div class="section my-5">
        <h2 class="mb-4 text-success">Ongoing Auctions</h2>
        <div class="row justify-content-center">
            @foreach ($auctionsActive as $auction)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-lg border-0 rounded-lg">
                        <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ $auction->item->name }}</h5>
                            <p class="card-text"><strong>Status:</strong> <span class="badge bg-success text-white">{{ $auction->status }}</span></p>
                            <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                            <p class="card-text"><strong>Current Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                            <p class="card-text"><strong>Auction Ends In:</strong> <span id="countdown-{{ $auction->id }}">{{ $auction->end_time->diffInSeconds(now()) }} seconds</span></p>
                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3 w-100">View Details</a>
                        </div>
                        <div class="card-footer text-center bg-light">
                            <small>Last updated {{ $auction->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Upcoming Auctions -->
    <div class="section my-5">
        <h2 class="mb-4 text-primary">Upcoming Auctions</h2>
        <div class="row">
            @if ($auctionsNotStarted->isEmpty())
                <p class="text-center">No upcoming auctions.</p>
            @else
                @foreach ($auctionsNotStarted as $auction)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-lg border-0 rounded-lg">
                            <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $auction->item->name }}</h5>
                                <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                                <p class="card-text"><strong>Starts In:</strong> {{ $auction->start_time->diffForHumans() }}</p>
                                <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3 w-100">View Details</a>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <small>Last updated {{ $auction->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- Ended Auctions -->
    <div class="section my-5">
        <h2 class="mb-4 text-danger">Completed Auctions</h2>
        <div class="row">
            @foreach ($auctionsEnded as $auction)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-lg border-0 rounded-lg">
                        <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                        <div class="card-body">
                            <h5 class="card-title text-danger">{{ $auction->item->name }}</h5>
                            <p class="card-text"><strong>Status:</strong> <span class="badge bg-danger text-white">{{ $auction->status }}</span></p>
                            <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                            <p class="card-text"><strong>Final Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3 w-100">View Details</a>
                        </div>
                        <div class="card-footer text-center bg-light">
                            <small>Last updated {{ $auction->updated_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    @foreach ($auctionsActive as $auction)
        @if ($auction->end_time)
            let countdownElement{{ $auction->id }} = document.getElementById('countdown-{{ $auction->id }}');
            let countdownTime{{ $auction->id }} = {{ $auction->end_time->diffInSeconds(now()) }};
            setInterval(function() {
                if (countdownTime{{ $auction->id }} > 0) {
                    countdownTime{{ $auction->id }}--;
                    let days = Math.floor(countdownTime{{ $auction->id }} / (60 * 60 * 24));
                    let hours = Math.floor((countdownTime{{ $auction->id }} % (60 * 60 * 24)) / (60 * 60));
                    let minutes = Math.floor((countdownTime{{ $auction->id }} % (60 * 60)) / 60);
                    let seconds = countdownTime{{ $auction->id }} % 60;
                    countdownElement{{ $auction->id }}.textContent = `${days} days, ${hours} hrs, ${minutes} mins, ${seconds} secs`;
                } else {
                    countdownElement{{ $auction->id }}.textContent = 'Auction ended';
                }
            }, 1000);
        @endif
    @endforeach
</script>
@endsection