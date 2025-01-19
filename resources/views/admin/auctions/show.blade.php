@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="text-center mb-4">{{ $auction->item->name }}</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="carousel slide" id="itemCarousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/' . $auction->item->image) }}" class="d-block w-100 rounded"
                                    alt="{{ $auction->item->name }}">
                            </div>
                            <!-- Additional images can be added here if available -->
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#itemCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#itemCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <p><strong>Description:</strong> {{ $auction->item->description }}</p>
                        <p><strong>Starting Price:</strong> Rp {{ number_format($auction->starting_price, 2) }}</p>
                        <p><strong>Current Highest Bid:</strong> Rp
                            {{ number_format($highestBid->amount ?? $auction->starting_price, 2) }}
                            @if ($highestBid && $highestBid->user_id == auth()->id())
                                <span class="badge bg-success">(You)</span>
                            @endif
                        </p>
                        @if ($auction->status === 'active')
                            <p><strong>Auction Ends In:</strong> <span
                                    id="countdown">{{ $auction->end_time->diffInSeconds(now()) }} seconds</span></p>
                        @else
                            <p><strong>Status:</strong>
                                {{ $auction->status === 'ended' ? 'Auction ended' : 'Auction not started' }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($auction->status === 'active')
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
                    countdownElement.innerText = `${days} days, ${hours} hrs, ${minutes} mins, ${seconds} secs`;
                } else {
                    clearInterval(this);
                    countdownElement.innerText =
                        '{{ $auction->status === 'ended' ? 'Auction ended' : 'Auction not started' }}';
                }
            }, 1000);
        </script>
    @endif

    <style>
        .carousel-item img {
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .card {
            border-radius: 8px;
        }

        .card-body p {
            font-size: 1rem;
            margin-bottom: 0.8rem;
        }
    </style>
@endsection
