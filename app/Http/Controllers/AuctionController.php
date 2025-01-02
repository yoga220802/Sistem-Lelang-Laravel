<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    public function index()
    {
        $auctions = Auction::with('item')->where('end_time', '>', now())->get();
        return view('auctions.index', compact('auctions'));
    }

    public function show($id)
    {
        $auction = Auction::with('item')->findOrFail($id);
        return view('auctions.show', compact('auction'));
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
}