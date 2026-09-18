<?php

namespace App\Livewire\Staff;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        $totalOrders = Order::count();
        $totalRevenue = Order::where('payment_status', 'PAID')->sum('total_amount');
        $totalUsers = User::count();
        $totalProducts = Product::count();

        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())
            ->where('payment_status', 'PAID')
            ->sum('total_amount');

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.staff.admin-dashboard', [
            'totalOrders' => $totalOrders,
            'totalRevenue' => $totalRevenue,
            'totalUsers' => $totalUsers,
            'totalProducts' => $totalProducts,
            'todayOrders' => $todayOrders,
            'todayRevenue' => $todayRevenue,
            'recentOrders' => $recentOrders,
        ])->layout('components.layouts.staff');
    }
}
