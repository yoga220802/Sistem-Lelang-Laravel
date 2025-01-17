<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use Carbon\Carbon;

class UpdateAuctionStatus extends Command
{
    protected $signature = 'auction:update-status';
    protected $description = 'Update auction status based on start_time and end_time';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $now = Carbon::now('Asia/Jakarta');
        $this->info('Current time: ' . $now);

        $activeAuctions = Auction::where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->get();
        $this->info('Active auctions: ' . $activeAuctions->count());
        foreach ($activeAuctions as $auction) {
            $auction->update(['is_active' => 1, 'status' => 'active']);
            $this->info('Activating auction ID: ' . $auction->id);
        }

        $inactiveAuctions = Auction::where('end_time', '<', $now)
            ->orWhere('start_time', '>', $now)
            ->get();
        $this->info('Inactive auctions: ' . $inactiveAuctions->count());
        foreach ($inactiveAuctions as $auction) {
            $status = $auction->end_time < $now ? 'ended' : 'not started';
            $auction->update(['is_active' => 0, 'status' => $status]);
            $this->info('Deactivating auction ID: ' . $auction->id);
        }

        $this->info('Auction statuses updated successfully.');
    }
}