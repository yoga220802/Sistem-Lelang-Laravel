<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Item;
use Carbon\Carbon;
use App\Models\Bid;
use App\Events\AuctionUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $auctionsActive = Auction::where('status', 'active')->get();
        $auctionsNotStarted = Auction::where('status', 'not started')
            ->orderBy('start_time', 'asc')
            ->take(3)
            ->get();
        $auctionsEnded = Auction::where('status', 'ended')
            ->orderBy('end_time', 'desc')
            ->take(3)
            ->get();

        if (auth()->user()->isAdmin()) {
            return view('admin.auctions.index', compact('auctionsActive', 'auctionsNotStarted', 'auctionsEnded'));
        } else {
            return view('auctions.index', compact('auctionsActive', 'auctionsNotStarted', 'auctionsEnded'));
        }
    }

    public function show($id)
    {
        $auction = Auction::with('item')->findOrFail($id);
        $bids = Bid::where('item_id', $auction->item_id)->orderBy('created_at', 'desc')->get();
        $highestBid = $bids->first();
    
        return view('auctions.show', compact('auction', 'bids', 'highestBid'));
    }

    public function create()
    {
        $items = Item::all();
        return view('auctions.create', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        Auction::create([
            'item_id' => $request->item_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('auctions.index')->with('success', 'Auction created successfully.');
    }

    public function edit($id)
    {
        $auction = Auction::findOrFail($id);
        $items = Item::all();
        return view('auctions.edit', compact('auction', 'items'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $auction = Auction::findOrFail($id);
        $auction->update($request->only('item_id', 'start_time', 'end_time'));

        return redirect()->route('auctions.index')->with('success', 'Auction updated successfully.');
    }

    public function destroy($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->delete();

        return redirect()->route('auctions.index')->with('success', 'Auction deleted successfully.');
    }

    public function active()
    {
        $activeAuctions = Auction::where('is_active', true)->get();
        return view('auctions.active', compact('activeAuctions'));
    }

    public function completed()
    {
        $completedAuctions = Auction::where('is_active', false)->get();
        return view('auctions.completed', compact('completedAuctions'));
    }

    public function end($id)
    {
        $auction = Auction::findOrFail($id);
        $auction->end_time = Carbon::now();
        $auction->status = 'ended';
        $auction->is_active = false;
        $auction->save();

        return redirect()->route('auctions.index')->with('success', 'Auction ended successfully.');
    }
}
