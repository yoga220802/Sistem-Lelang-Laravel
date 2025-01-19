@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Items</h1>
    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">Add Item</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Starting Price</th>
                <th>Final Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->starting_price }}</td>
                <td>{{ $item->final_price }}</td>
                <td>
                    <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" style="display:inline;">
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
@endsection