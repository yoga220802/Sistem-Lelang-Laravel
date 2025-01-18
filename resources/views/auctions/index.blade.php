@extends('layouts.participant')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center display-4 text-primary">Sistem Pelelangan Online</h1>

        <!-- Active Auctions -->
        <div class="section my-5">
            <h2 class="mb-4 text-success">Lelang Aktif</h2>
            <div class="row justify-content-center">
                @foreach ($auctionsActive as $auction)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-lg border-0 rounded-lg">
                            <img src="{{ asset('storage/' . $auction->item->image) }}"
                                class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                            <div class="card-body">
                                <h5 class="card-title text-primary">{{ $auction->item->name }}</h5>
                                <p class="card-text"><strong>Status:</strong> <span
                                        class="badge bg-success text-white">{{ $auction->status }}</span></p>
                                <p class="card-text"><strong>Harga Awal:</strong>
                                    Rp.{{ number_format($auction->starting_price, 2) }}</p>
                                <p class="card-text"><strong>Harga Saat Ini:</strong>
                                    Rp.{{ number_format($auction->current_price, 2) }}</p>
                                @if ($auction->end_time)
                                    <p class="card-text"><strong>Sisa Waktu:</strong> <span
                                            id="countdown-{{ $auction->id }}">{{ $auction->end_time->diffInSeconds(now()) }}
                                            detik</span></p>
                                @endif
                                @if (auth()->check() && $auction->status === 'active')
                                    <form id="bid-form" action="{{ route('auctions.bid', $auction->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="amount">Your Bid:</label>
                                            <input type="number" name="amount" id="amount" class="form-control"
                                                placeholder="Enter your bid" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Place Bid</button>
                                    </form>
                                @elseif(!auth()->check())
                                    <p class="text-center">You must <a href="{{ route('login') }}">login</a> to place a bid.
                                    </p>
                                @endif
                                <a href="{{ route('auctions.show', $auction->id) }}"
                                    class="btn btn-primary mt-3 w-100">Lihat Detail</a>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <small>Terakhir diperbarui {{ $auction->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Upcoming Auctions -->
        <div class="section my-5">
            <h2 class="mb-4 text-primary">Lelang Mendatang</h2>
            <div class="row">
                @if ($auctionsNotStarted->isEmpty())
                    <p class="text-center">Tidak ada item yang akan dilelang.</p>
                @else
                    @foreach ($auctionsNotStarted as $auction)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-lg border-0 rounded-lg">
                                <img src="{{ asset('storage/' . $auction->item->image) }}"
                                    class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{ $auction->item->name }}</h5>
                                    <p class="card-text"><strong>Harga Awal:</strong>
                                        Rp.{{ number_format($auction->starting_price, 2) }}</p>
                                    <p class="card-text"><strong>Harga Saat Ini:</strong>
                                        Rp.{{ number_format($auction->current_price, 2) }}</p>
                                    <p class="card-text"><strong>Mulai Dalam:</strong>
                                        {{ $auction->start_time->diffForHumans() }}</p>
                                    <a href="{{ route('auctions.show', $auction->id) }}"
                                        class="btn btn-primary mt-3 w-100">Lihat Detail</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Ended Auctions -->
        <div class="section my-5">
            <h2 class="mb-4 text-danger">Lelang Berakhir</h2>
            <div class="row">
                @foreach ($auctionsEnded as $auction)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-lg border-0 rounded-lg">
                            <img src="{{ asset('storage/' . $auction->item->image) }}"
                                class="card-img-top img-fixed-size rounded-top" alt="{{ $auction->item->name }}">
                            <div class="card-body">
                                <h5 class="card-title text-danger">{{ $auction->item->name }}</h5>
                                <p class="card-text"><strong>Status:</strong> <span
                                        class="badge bg-danger text-white">{{ $auction->status }}</span></p>
                                <p class="card-text"><strong>Harga Awal:</strong>
                                    Rp.{{ number_format($auction->starting_price, 2) }}</p>
                                <p class="card-text"><strong>Harga Akhir:</strong>
                                    Rp.{{ number_format($auction->current_price, 2) }}</p>
                                @if ($auction->user_id)
                                    <p class="card-text"><strong>Terjual kepada:</strong> {{ $auction->user->name }}</p>
                                @else
                                    <p class="card-text text-muted">Barang tidak terjual</p>
                                @endif
                                <a href="{{ route('auctions.show', $auction->id) }}"
                                    class="btn btn-primary mt-3 w-100">Lihat Detail</a>
                            </div>
                            <div class="card-footer text-center bg-light">
                                <small>Terakhir diperbarui {{ $auction->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
        body {
            background: linear-gradient(120deg, #f3f4f6, #e8f0fe);
            color: #343a40;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .img-fixed-size {
            height: 200px;
            object-fit: cover;
        }
    </style>

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
@endsection
