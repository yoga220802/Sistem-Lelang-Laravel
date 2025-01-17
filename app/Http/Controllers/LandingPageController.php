<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $auctionsActive = Auction::where('status', 'active')->get();
        $auctionsNotStarted = Auction::where('status', 'not started')
            ->orderBy('start_time', 'asc')
            ->take(2)
            ->get();
        $auctionsEnded = Auction::where('status', 'ended')
            ->orderBy('end_time', 'desc')
            ->take(2)
            ->get();

        return view('landing', compact('auctionsActive', 'auctionsNotStarted', 'auctionsEnded'));
    }
}