<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Auction System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <div class="container">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-6">
                <h2>Active Auctions</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeAuctions as $auction)
                        <tr>
                            <td>{{ $auction->id }}</td>
                            <td>{{ $auction->item->name }}</td>
                            <td>{{ $auction->start_time }}</td>
                            <td>{{ $auction->end_time }}</td>
                            <td>{{ $auction->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Participants</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($participants as $participant)
                        <tr>
                            <td>{{ $participant->id }}</td>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->email }}</td>
                            <td>{{ $participant->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h2>Recent Bids</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item</th>
                            <th>Bidder</th>
                            <th>Amount</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBids as $bid)
                        <tr>
                            <td>{{ $bid->id }}</td>
                            <td>{{ $bid->item->name }}</td>
                            <td>{{ $bid->user->name }}</td>
                            <td>{{ $bid->amount }}</td>
                            <td>{{ $bid->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>