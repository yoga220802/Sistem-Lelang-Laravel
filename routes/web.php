<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
// use App\Http\Controllers\ItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserManageController;
use App\Http\Controllers\Admin\ItemController;
// Redirect root URL to main content
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Authentication Routes
Route::get('login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('login', [UserController::class, 'login']);
Route::get('register', [UserController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [UserController::class, 'register']);
Route::post('logout', [UserController::class, 'logout'])->name('logout');

// Dashboard Route for all users
Route::middleware(['auth'])->get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

// 
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::resource('items', App\Http\Controllers\Admin\ItemController::class);
});


Route::post('/auctions/{id}/end', [AuctionController::class, 'end'])->name('auctions.end');
Route::post('/auctions/{auction}/bid', [BidController::class, 'placeBid'])->name('auctions.bid');
// Auction Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/auctions', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/auctions/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
    Route::post('/auctions/{auction}/bid', [BidController::class, 'placeBid'])->name('auctions.bid');

    // Item Management Routes (for auction managers)
    Route::middleware(['can:manage-auctions'])->group(function () {
        Route::get('auctions/active', [AuctionController::class, 'active'])->name('auctions.active');
        Route::get('auctions/completed', [AuctionController::class, 'completed'])->name('auctions.completed');
        Route::resource('auctions', AuctionController::class)->except(['index', 'show']);
        Route::resource('items', ItemController::class);
        Route::resource('auctions', AuctionController::class)->except(['index', 'show']);
    });

    Route::middleware(['auth', 'can:manage-users'])->group(function () {
        Route::get('users', [UserManageController::class, 'index'])->name('users.index');
        Route::get('users/create', [UserManageController::class, 'create'])->name('users.create');
        Route::post('users', [UserManageController::class, 'store'])->name('users.store');
        Route::get('users/{id}/edit', [UserManageController::class, 'edit'])->name('users.edit');
        Route::put('users/{id}', [UserManageController::class, 'update'])->name('users.update');
        Route::delete('users/{id}', [UserManageController::class, 'destroy'])->name('users.destroy');
    });

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

// Item Management Routes (for admin)
Route::middleware(['auth', 'can:manage-items'])->group(function () {
    Route::resource('items', ItemController::class);
});

// Auction Management Routes (for admin)
Route::middleware(['auth', 'can:manage-auctions'])->group(function () {
    Route::resource('auctions', AuctionController::class)->except(['index', 'show']);
});
