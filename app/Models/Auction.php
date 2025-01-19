<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'start_time',
        'end_time',
        'starting_price',
        'current_price',
        'is_active',
        'status',
    ];

    use HasFactory;

    protected $casts = [
        'end_time' => 'datetime',
        'start_time' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function isActive()
    {
        return $this->status === 'active';
    }

    public function hasEnded()
    {
        return $this->status === 'ended';
    }

    public function startAuction()
    {
        $this->status = 'active';
        $this->save();
    }

    public function endAuction()
    {
        $this->status = 'ended';
        $this->save();
    }
}