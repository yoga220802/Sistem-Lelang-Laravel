<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Auction;

class UserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120'
        ]);

        $profileImage = null;
        if ($request->hasFile('profile_image')) {
            $profileImage = $request->file('profile_image')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'participant',
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $profileImage,
        ]);

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $activeAuctions = Auction::where('status', 'active')->get();

        $topBidders = User::select('users.name', \DB::raw('COUNT(auctions.user_id) as win_count'))
            ->join('auctions', 'users.id', '=', 'auctions.user_id')
            ->whereNotNull('auctions.user_id')
            ->groupBy('users.name')
            ->orderByRaw('COUNT(auctions.user_id) DESC')
            ->take(5)
            ->get();

            $highestBidItem = Auction::whereNotNull('user_id')
            ->get()
            ->sortByDesc(function ($auction) {
                return $auction->current_price - $auction->starting_price;
            })
            ->first();

        $highestBidWinner = $highestBidItem ? User::find($highestBidItem->user_id) : null;


        if ($user && $user->isParticipant()) {
            return redirect()->route('auctions.index');
        }

        return view('dashboard.index', compact('activeAuctions', 'topBidders', 'highestBidItem', 'highestBidWinner'));
    }
}
