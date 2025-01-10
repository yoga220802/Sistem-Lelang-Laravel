<!-- FILE: resources/views/auctions/completed.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Completed Auctions</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Completed Auctions</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Starting Price</th>
                            <th>Final Price</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedAuctions as $auction)
                        <tr>
                            <td>{{ $auction->item->name }}</td>
                            <td>{{ $auction->starting_price }}</td>
                            <td>{{ $auction->current_price }}</td>
                            <td>{{ $auction->end_time }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection