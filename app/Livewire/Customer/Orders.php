<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Orders extends Component
{
    public function render()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->whereIn('order_mode', ['DINE_IN', 'TAKE_AWAY'])
            ->latest()
            ->get();

        return view('livewire.customer.orders', [
            'orders' => $orders,
        ])->layout('components.layouts.customer');
    }
}
