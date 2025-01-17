@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Auctions (Admin)</h1>

    <!-- Active Auctions -->
    <div class="row justify-content-center">
        @foreach($auctionsActive as $auction)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm border-success">
                    <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size" alt="{{ $auction->item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $auction->item->name }}</h5>
                        <p class="card-text"><strong>Status:</strong> {{ $auction->status }}</p>
                        <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                        <p class="card-text"><strong>Current Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                        @if($auction->end_time)
                            <p class="card-text"><strong>Auction Ends In:</strong> <span id="countdown-{{ $auction->id }}">{{ $auction->end_time->diffInSeconds(now()) }} seconds</span></p>
                        @endif
                        <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3">View Details</a>
                        @if($auction->status == 'active')
                            <form action="{{ route('auctions.end', $auction->id) }}" method="POST" class="mt-3">
                                @csrf
                                <button type="submit" class="btn btn-danger">End Auction Now</button>
                            </form>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        <small>Last updated {{ $auction->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Not Started Auctions -->
    <h2 class="my-4">Upcoming Auctions</h2>
    <div class="row">
        @if($auctionsNotStarted->isEmpty())
            <p class="text-center">Tidak ada item yang akan dilelang.</p>
        @else
            @foreach($auctionsNotStarted as $auction)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm border-primary">
                        <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size" alt="{{ $auction->item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->item->name }}</h5>
                            <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                            <p class="card-text"><strong>Current Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                            <p class="card-text"><strong>Auction Starts In:</strong> {{ $auction->start_time->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Ended Auctions -->
    <h2 class="my-4">Ended Auctions</h2>
    <div class="row">
        @foreach($auctionsEnded as $auction)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm border-danger">
                    <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size" alt="{{ $auction->item->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $auction->item->name }}</h5>
                        <p class="card-text"><strong>Status:</strong> {{ $auction->status }}</p>
                        <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                        <p class="card-text"><strong>Current Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                        @if($auction->user_id)
                            <p class="card-text"><strong>Terjual kepada:</strong> {{ $auction->user->name }}</p>
                        @else
                            <p class="card-text"><strong>Status:</strong> Barang tidak terjual</p>
                        @endif
                        <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3">View Details</a>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Last updated {{ $auction->updated_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    @foreach($auctionsActive as $auction)
        @if($auction->end_time)
            let countdownElement = document.getElementById('countdown-{{ $auction->id }}');
            let countdownTime = {{ $auction->end_time->diffInSeconds(now()) }};
            setInterval(function() {
                if (countdownTime > 0) {
                    countdownTime--;
                    let days = Math.floor(countdownTime / (60 * 60 * 24));
                    let hours = Math.floor((countdownTime % (60 * 60 * 24)) / (60 * 60));
                    let minutes = Math.floor((countdownTime % (60 * 60)) / 60);
                    let seconds = countdownTime % 60;
                    countdownElement.innerText = `${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
                } else {
                    countdownElement.innerText = 'Auction ended';
                }
            }, 1000);
        @endif
    @endforeach

    window.Echo.channel('auctions')
        .listen('AuctionUpdated', (e) => {
            location.reload();
        });
</script>

<style>
    .img-fixed-size {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
</style>
@endsection