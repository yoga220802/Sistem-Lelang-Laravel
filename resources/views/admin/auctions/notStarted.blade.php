@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Not Started Auctions</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Not Started Auctions</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Starting Price</th>
                                <th>Start Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($notStartedAuctions as $auction)
                                <tr>
                                    <td>{{ $auction->item->name }}</td>
                                    <td>{{ $auction->starting_price }}</td>
                                    <td>{{ $auction->start_time }}</td>
                                    <td>
                                        <a href="{{ route('auctions.show', $auction->id) }}"
                                            class="btn btn-primary">Detail</a>
                                        <a href="{{ route('admin.items.edit', $auction->item_id) }}"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.items.destroy', $auction->item_id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
