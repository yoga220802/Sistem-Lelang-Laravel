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
                        <!-- Content removed as per request -->
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>You do not have access to this page.</p>
    @endif
</div>
@endsection