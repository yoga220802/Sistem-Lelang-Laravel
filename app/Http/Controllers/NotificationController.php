<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public function notifyBidUpdate(Bid $bid)
    {
        $item = Item::find($bid->item_id);
        $participants = User::where('role', 'participant')->get();

        Notification::send($participants, new \App\Notifications\BidUpdated($item, $bid));
    }

    public function notifyAuctionResult($auction)
    {
        $winner = $auction->winner; // Assuming the auction model has a winner relationship
        Notification::send($winner, new \App\Notifications\AuctionWon($auction));
    }
}