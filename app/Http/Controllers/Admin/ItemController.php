<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Auction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('admin.items.index', compact('items'));
    }

    public function create()
    {
        return view('admin.items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
        ]);

        $this->validateAuctionTime($request);

        $imagePath = $request->file('image') ? $request->file('image')->store('items_pictures', 'public') : null;

        $item = Item::create([
            'name' => $request->name,
            'description' => $request->description,
            'starting_price' => $request->starting_price,
            'final_price' => 0,
            'image' => $imagePath,
        ]);

        $auction = Auction::create([
            'item_id' => $item->id,
            'starting_price' => $request->starting_price,
            'current_price' => 0,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            // 'is_active' => true,
        ]);

        // Update the item with the auction_id
        $item->update(['auction_id' => $auction->id]);

        return redirect()->route('admin.items.index')->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        return view('admin.items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('admin.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'starting_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $this->validateAuctionTime($request, $item->id);

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('items_pictures', 'public');
                $item->image = $imagePath;
            }

            $item->update([
                'name' => $request->name,
                'description' => $request->description,
                'starting_price' => $request->starting_price,
            ]);

            $item->auction->update([
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
            ]);

            // Update auction status based on start_time and end_time
            $now = Carbon::now('Asia/Jakarta');
            $status = 'not started';
            if ($request->start_time <= $now && $request->end_time >= $now) {
                $status = 'active';
            } elseif ($request->end_time < $now) {
                $status = 'ended';
            }
            $item->auction->update(['status' => $status, 'is_active' => $status === 'active' ? 1 : 0]);

            return redirect()->route('admin.items.index')->with('success', 'Item updated successfully.');
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('admin.items.index')->with('success', 'Item deleted successfully.');
    }

    private function validateAuctionTime(Request $request, $itemId = null)
    {
        $query = Auction::where(function ($query) use ($request) {
            $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                ->orWhere(function ($query) use ($request) {
                    $query->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time);
                });
        });

        if ($itemId) {
            $query->where('item_id', '!=', $itemId);
        }

        if ($query->exists()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'start_time' => 'The selected time range overlaps with another auction.',
            ]);
        }
    }
}
