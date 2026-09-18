<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;

class OrderTracking extends Component
{
    public Order $order;

    public function mount(string $orderId): void
    {
        $this->order = Order::with(['items.modifiers', 'payment', 'table'])
            ->findOrFail($orderId);
    }

    public function getStatusStepsProperty(): array
    {
        $steps = [
            ['key' => 'PENDING', 'label' => 'Dibuat', 'icon' => '📋'],
            ['key' => 'CONFIRMED', 'label' => 'Dikonfirmasi', 'icon' => '✅'],
            ['key' => 'PREPARING', 'label' => 'Diproses', 'icon' => '👨‍🍳'],
            ['key' => 'READY', 'label' => 'Siap', 'icon' => '🎉'],
            ['key' => 'COMPLETED', 'label' => 'Selesai', 'icon' => '🏠'],
        ];

        $orderStatuses = ['PENDING', 'CONFIRMED', 'PREPARING', 'READY', 'COMPLETED'];
        $currentIndex = array_search($this->order->status, $orderStatuses);

        if ($this->order->status === 'CANCELLED') {
            $currentIndex = -1;
        }

        foreach ($steps as &$step) {
            $stepIndex = array_search($step['key'], $orderStatuses);
            $step['status'] = 'upcoming';
            if ($currentIndex >= $stepIndex) {
                $step['status'] = 'completed';
            }
            if ($step['key'] === $this->order->status) {
                $step['status'] = 'current';
            }
        }

        return $steps;
    }

    public function render()
    {
        return view('livewire.customer.order-tracking', [
            'statusSteps' => $this->statusSteps,
        ])->layout('components.layouts.customer', ['showNav' => false]);
    }
}
