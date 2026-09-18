<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;

class OrderSuccess extends Component
{
    public Order $order;

    public function mount(string $orderId): void
    {
        $this->order = Order::with(['items', 'payment'])->findOrFail($orderId);
    }

    public function render()
    {
        return view('livewire.customer.order-success')->layout('components.layouts.customer', ['showNav' => false]);
    }
}
