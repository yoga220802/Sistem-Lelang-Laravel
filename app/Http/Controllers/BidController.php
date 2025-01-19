<?php

namespace App\Http\Controllers;

use App\Models\Bid;
use App\Models\Item;
use App\Models\Auction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function placeBid(Request $request, $auctionId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $auction = Auction::findOrFail($auctionId);
        $item = $auction->item;

        if ($request->amount <= $item->starting_price || $request->amount <= $auction->current_price) {
            return response()->json(['message' => 'Bid must be higher than the starting price and the current price.'], 400);
        }

        $bid = new Bid();
        $bid->user_id = Auth::id();
        $bid->item_id = $item->id;
        $bid->amount = $request->amount;
        $bid->save();

        // Update item final price
        $item->final_price = $request->amount;
        $item->save();

        // Update auction current price and user id
        $auction->current_price = $request->amount;
        $auction->user_id = Auth::id();
        $auction->save();

        // Notify participants about the new bid (implementation not shown)
        // Notification::send($participants, new BidUpdatedNotification($item));

        return redirect()->route('auctions.show', $auction->id)->with('success', 'Bid placed successfully.');
    }
    public function getBids($itemId)
    {
        $bids = Bid::where('item_id', $itemId)->orderBy('created_at', 'desc')->get();
        return response()->json($bids);
    }
}
