@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Edit Item</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description">{{ $item->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="starting_price">Starting Price</label>
            <input type="number" class="form-control" id="starting_price" name="starting_price" value="{{ $item->starting_price }}" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" class="form-control" id="start_time" name="start_time" value="{{ \Carbon\Carbon::parse($item->auction->start_time)->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="datetime-local" class="form-control" id="end_time" name="end_time" value="{{ \Carbon\Carbon::parse($item->auction->end_time)->format('Y-m-d\TH:i') }}" required>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Update Item</button>
    </form>
</div>
@endsection