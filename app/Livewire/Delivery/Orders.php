<?php

namespace App\Livewire\Delivery;

use App\Models\Order;
use Livewire\Component;

class Orders extends Component
{
    public function render()
    {
        $orders = Order::with(['items', 'branch'])
            ->where('user_id', auth()->id())
            ->where('order_mode', 'DELIVERY')
            ->latest()
            ->get();

        return view('livewire.delivery.orders', [
            'orders' => $orders,
        ])->layout('components.layouts.delivery');
    }
}
