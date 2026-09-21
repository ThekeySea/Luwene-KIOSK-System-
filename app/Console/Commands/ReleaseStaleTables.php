<?php

namespace App\Console\Commands;

use App\Models\DiningSession;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Console\Command;

class ReleaseStaleTables extends Command
{
    protected $signature = 'tables:release-stale {--hours=4 : Hours after which an OCCUPIED table is considered stale}';
    protected $description = 'Release tables that have been OCCUPIED for too long without a completed order';

    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $threshold = now()->subHours($hours);

        $staleOrders = Order::where('order_mode', 'DINE_IN')
            ->where('status', '!=', 'COMPLETED')
            ->where('status', '!=', 'CANCELLED')
            ->where('table_id', '!=', null)
            ->where('created_at', '<', $threshold)
            ->get();

        $released = 0;

        foreach ($staleOrders as $order) {
            if ($order->table_id) {
                RestaurantTable::where('id', $order->table_id)
                    ->where('status', 'OCCUPIED')
                    ->update(['status' => 'AVAILABLE']);
            }

            if ($order->dining_session_id) {
                DiningSession::where('id', $order->dining_session_id)
                    ->where('status', 'ACTIVE')
                    ->update(['status' => 'CLOSED', 'closed_at' => now()]);
            }

            $order->update([
                'status' => 'CANCELLED',
                'cancelled_at' => $order->cancelled_at ?? now(),
            ]);

            $released++;
        }

        $this->info("Released {$released} stale table(s) (older than {$hours}h).");
        return Command::SUCCESS;
    }
}
