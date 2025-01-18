<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\admin\ItemController;
use App\Http\Controllers\NotificationController;

// Authentication Routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

// Auction Routes
Route::get('/auctions', [AuctionController::class, 'index']);
Route::get('/auctions/{id}', [AuctionController::class, 'show']);
Route::post('/auctions', [AuctionController::class, 'store']);
Route::put('/auctions/{id}', [AuctionController::class, 'update']);
Route::delete('/auctions/{id}', [AuctionController::class, 'destroy']);

// Item Routes
Route::get('/items', [ItemController::class, 'index']);
Route::get('/items/{id}', [ItemController::class, 'show']);
Route::post('/items', [ItemController::class, 'store']);
Route::put('/items/{id}', [ItemController::class, 'update']);
Route::delete('/items/{id}', [ItemController::class, 'destroy']);

// Bid Routes
Route::post('/auctions/{auctionId}/bids', [BidController::class, 'store']);

// Notification Routes
Route::get('/notifications', [NotificationController::class, 'index']);