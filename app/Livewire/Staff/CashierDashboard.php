<?php

namespace App\Livewire\Staff;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CashierDashboard extends Component
{
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

        return view('livewire.staff.cashier-dashboard', [
            'todayOrders' => $todayOrders,
            'todayRevenue' => $todayRevenue,
            'pendingOrders' => $pendingOrders,
        ])->layout('components.layouts.staff');
    }
}
