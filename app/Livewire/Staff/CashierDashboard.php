<?php

namespace App\Livewire\Staff;

use App\Models\DiningSession;
use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CashierDashboard extends Component
{
    public function releaseTableById(string $tableId): void
    {
        $table = RestaurantTable::find($tableId);

        if (! $table || $table->status !== 'OCCUPIED') {
            $this->dispatch('toast', message: 'Meja tidak dalam status terpakai.', type: 'error');
            return;
        }

        RestaurantTable::where('id', $tableId)->update(['status' => 'AVAILABLE']);

        DiningSession::where('table_id', $tableId)
            ->where('status', 'ACTIVE')
            ->update(['status' => 'CLOSED', 'closed_at' => now()]);

        $this->dispatch('toast', message: "Meja {$table->table_number} berhasil dilepas.", type: 'success');
    }

    public function render()
    {
        $todayOrders = Order::where('branch_id', Auth::user()->branch_id)
            ->whereDate('created_at', today())
            ->count();

        $todayRevenue = Order::where('branch_id', Auth::user()->branch_id)
            ->whereDate('created_at', today())
            ->where('payment_status', 'PAID')
            ->sum('total_amount');

        $pendingOrders = Order::where('branch_id', Auth::user()->branch_id)
            ->where('status', 'PENDING')
            ->count();

        $tables = RestaurantTable::orderBy('table_number')->get();

        return view('livewire.staff.cashier-dashboard', [
            'todayOrders' => $todayOrders,
            'todayRevenue' => $todayRevenue,
            'pendingOrders' => $pendingOrders,
            'tables' => $tables,
        ])->layout('components.layouts.staff');
    }
}
