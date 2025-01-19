<!-- FILE: resources/views/profile/edit.blade.php -->

@extends('layouts.participant')

@section('content')
    <div class="container">
        <h1 class="my-4 text-center">Edit Profile</h1>
        <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ Auth::user()->name }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ Auth::user()->phone }}" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea name="address" id="address" class="form-control" required>{{ Auth::user()->address }}</textarea>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select name="role" id="role" class="form-control" disabled>
                    <option value="admin" {{ Auth::user()->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="participant" {{ Auth::user()->role == 'participant' ? 'selected' : '' }}>Participant</option>
                </select>
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" name="profile_image" id="profile_image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
        </form>
    </div>
@endsection