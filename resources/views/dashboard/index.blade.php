<!-- FILE: resources/views/dashboard/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
    @if(Auth::user() && Auth::user()->isAdmin())
        <div class="row">
            <div class="col-lg-6">
                <!-- Active Auctions Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Active Auctions</h6>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            @foreach($activeAuctions as $auction)
                                <div class="col-md-12">
                                    <div class="card mb-4 auction-card shadow-success" data-status="active">
                                        <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size" alt="{{ $auction->item->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $auction->item->name }}</h5>
                                            <p class="card-text"><strong>Status:</strong> {{ $auction->status }}</p>
                                            <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($auction->starting_price, 2) }}</p>
                                            <p class="card-text"><strong>Current Price:</strong> Rp.{{ number_format($auction->current_price, 2) }}</p>
                                            @if ($auction->end_time)
                                                <p class="card-text"><strong>Sisa Waktu:</strong> <span id="countdown-{{ $auction->id }}">{{ $auction->end_time->diffInSeconds(now()) }} detik</span></p>
                                            @endif
                                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3">View Details</a>
                                            @if ($auction->status == 'active')
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
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Highest Bid Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Highest Bid</h6>
                    </div>
                    <div class="card-body">
                        @if($highestBidItem)
                            <div class="card mb-4 auction-card shadow-danger" data-status="ended">
                                <img src="{{ asset('storage/' . $highestBidItem->item->image) }}" class="card-img-top img-fixed-size" alt="{{ $highestBidItem->item->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $highestBidItem->item->name ?? 'N/A' }}</h5>
                                    <p class="card-text"><strong>Starting Price:</strong> Rp.{{ number_format($highestBidItem->starting_price, 2) }}</p>
                                    <p class="card-text"><strong>Final Price:</strong> Rp.{{ number_format($highestBidItem->current_price, 2) }}</p>
                                    <p class="card-text"><strong>Winner:</strong> {{ $highestBidWinner->name ?? 'N/A' }}</p>
                                </div>
                                <div class="card-footer text-muted">
                                    <small>Last updated {{ $highestBidItem->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @else
                            <p>No highest bid item available.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Bid Master Card Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Bid Master (Top 5)</h6>
                    </div>
                    <div class="card-body">
                        @foreach($topBidders as $bidder)
                            <p>{{ $bidder->name }} - {{ $bidder->win_count }} wins</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>You do not have access to this page.</p>
    @endif
</div>
<script>
    @foreach ($activeAuctions as $auction)
        @if ($auction->end_time)
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
                    countdownElement.innerText = 'Lelang telah berakhir';
                }
            }, 1000);
        @endif
    @endforeach
</script>
<style>
    /* Shared styles */
    .img-fixed-size {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .auction-card {
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 10px;
    }

    .auction-card:hover {
        transform: scale(1.02);
    }

    /* Shadow styles */
    .shadow-primary {
        box-shadow: 0 4px 8px rgba(0, 123, 255, 0.2);
    }

    .shadow-primary:hover {
        box-shadow: 0 8px 16px rgba(0, 123, 255, 0.4);
    }

    .shadow-success {
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.2);
    }

    .shadow-success:hover {
        box-shadow: 0 8px 16px rgba(40, 167, 69, 0.4);
    }

    .shadow-danger {
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
    }

    .shadow-danger:hover {
        box-shadow: 0 8px 16px rgba(220, 53, 69, 0.4);
    }
</style>
@endsection