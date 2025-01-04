<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'starting_price',
        'current_price',
        'auction_id',
        'status',
        'image',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}