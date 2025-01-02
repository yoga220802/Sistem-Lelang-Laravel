<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('auction.{auctionId}', function ($user, $auctionId) {
    return true; // Allow all authenticated users to listen to auction channels
});

Broadcast::channel('bid.{itemId}', function ($user, $itemId) {
    return true; // Allow all authenticated users to listen to bid channels for specific items
});