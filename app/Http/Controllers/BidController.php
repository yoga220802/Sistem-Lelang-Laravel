<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function placeBid(Request $request, $itemId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $item = Item::findOrFail($itemId);

        if ($request->amount <= $item->current_bid) {
            return response()->json(['message' => 'Bid must be higher than the current bid.'], 400);
        }

        $bid = new Bid();
        $bid->user_id = Auth::id();
        $bid->item_id = $itemId;
        $bid->amount = $request->amount;
        $bid->save();

        $item->current_bid = $request->amount;
        $item->save();

        // Notify participants about the new bid (implementation not shown)
        // Notification::send($participants, new BidUpdatedNotification($item));

        return response()->json(['message' => 'Bid placed successfully.'], 201);
    }

    public function getBids($itemId)
    {
        $bids = Bid::where('item_id', $itemId)->orderBy('created_at', 'desc')->get();
        return response()->json($bids);
    }
}