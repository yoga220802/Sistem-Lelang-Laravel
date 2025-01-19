@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="my-4">Daftar Auctions (Admin)</h1>

        <!-- Active Auctions -->
        <div class="row justify-content-center">
            @foreach ($auctionsActive as $auction)
                <div class="col-md-4">
                    <div class="card mb-4 auction-card shadow-success" data-status="active">
                        <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size"
                            alt="{{ $auction->item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->item->name }}</h5>
                            <p class="card-text"><strong>Status:</strong> {{ $auction->status }}</p>
                            <p class="card-text"><strong>Starting Price:</strong>
                                Rp.{{ number_format($auction->starting_price, 2) }}</p>
                            <p class="card-text"><strong>Current Price:</strong>
                                Rp.{{ number_format($auction->current_price, 2) }}</p>
                            @if ($auction->end_time)
                                <p class="card-text"><strong>Sisa Waktu:</strong> <span
                                        id="countdown-{{ $auction->id }}">{{ $auction->end_time->diffInSeconds(now()) }}
                                        detik</span></p>
                            @endif
                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3">View
                                Details</a>
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

        <!-- Not Started Auctions -->
        <h2 class="my-4">Upcoming Auctions</h2>
        <div class="row">
            @if ($auctionsNotStarted->isEmpty())
                <p class="text-center">Tidak ada item yang akan dilelang.</p>
            @else
                @foreach ($auctionsNotStarted as $auction)
                    <div class="col-md-4">
                        <div class="card mb-4 auction-card shadow-primary" data-status="not-started">
                            <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size"
                                alt="{{ $auction->item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $auction->item->name }}</h5>
                                <p class="card-text"><strong>Starting Price:</strong>
                                    Rp.{{ number_format($auction->starting_price, 2) }}</p>
                                <p class="card-text"><strong>Current Price:</strong>
                                    Rp.{{ number_format($auction->current_price, 2) }}</p>
                                <p class="card-text"><strong>Auction Starts In:</strong>
                                    {{ $auction->start_time->diffForHumans() }}</p>
                                <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3">View
                                    Details</a>
                                <a href="{{ route('admin.items.edit', $auction->item->id) }}"
                                    class="btn btn-warning mt-3 w-100">Edit Item</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Ended Auctions -->
        <h2 class="my-4">Ended Auctions</h2>
        <div class="row">
            @foreach ($auctionsEnded as $auction)
                <div class="col-md-4">
                    <div class="card mb-4 auction-card shadow-danger" data-status="ended">
                        <img src="{{ asset('storage/' . $auction->item->image) }}" class="card-img-top img-fixed-size"
                            alt="{{ $auction->item->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $auction->item->name }}</h5>
                            <p class="card-text"><strong>Status:</strong> {{ $auction->status }}</p>
                            <p class="card-text"><strong>Starting Price:</strong>
                                Rp.{{ number_format($auction->starting_price, 2) }}</p>
                            <p class="card-text"><strong>Current Price:</strong>
                                Rp.{{ number_format($auction->current_price, 2) }}</p>
                            @if ($auction->user_id)
                                <p class="card-text"><strong>Terjual kepada:</strong> {{ $auction->user->name }}</p>
                            @else
                                <p class="card-text"><strong>Status:</strong> Barang tidak terjual</p>
                            @endif
                            <a href="{{ route('auctions.show', $auction->id) }}" class="btn btn-primary mt-3">View
                                Details</a>
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
        @foreach ($auctionsActive as $auction)
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
                        countdownElement.innerText =
                            `${days} hari, ${hours} jam, ${minutes} menit, ${seconds} detik`;
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
