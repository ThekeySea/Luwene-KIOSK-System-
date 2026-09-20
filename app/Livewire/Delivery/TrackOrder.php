<?php

namespace App\Livewire\Delivery;

use App\Models\Order;
use Livewire\Component;

class TrackOrder extends Component
{
    public Order $order;

    public function mount(string $orderId): void
    {
        $this->order = Order::with(['items', 'branch'])
            ->where('user_id', auth()->id())
            ->where('order_mode', 'DELIVERY')
            ->findOrFail($orderId);
    }

    public function getStatusStepsProperty(): array
    {
        $steps = [
            ['key' => 'PENDING', 'label' => 'Pesanan Diterima', 'icon' => '📋'],
            ['key' => 'CONFIRMED', 'label' => 'Dikonfirmasi', 'icon' => '✅'],
            ['key' => 'PREPARING', 'label' => 'Disiapkan', 'icon' => '👨‍🍳'],
            ['key' => 'READY', 'label' => 'Siap Dikirim', 'icon' => '📦'],
            ['key' => 'OUT_FOR_DELIVERY', 'label' => 'Dalam Perjalanan', 'icon' => '🛵'],
            ['key' => 'DELIVERED', 'label' => 'Tiba', 'icon' => '🎉'],
        ];

        $statusOrder = array_column($steps, 'key');
        $currentIndex = array_search($this->order->status, $statusOrder);
        $currentIndex = $currentIndex !== false ? $currentIndex : -1;

        foreach ($steps as $i => &$step) {
            if ($this->order->status === 'CANCELLED') {
                $step['state'] = 'cancelled';
            } elseif ($i < $currentIndex) {
                $step['state'] = 'completed';
            } elseif ($i === $currentIndex) {
                $step['state'] = 'current';
            } else {
                $step['state'] = 'upcoming';
            }
        }

        return $steps;
    }

    public function getEstMinutesProperty(): ?int
    {
        if (! $this->order->delivery_estimated_at) {
            return null;
        }
        $remaining = $this->order->delivery_estimated_at->diffInSeconds(now());
        return max(0, (int) ceil($remaining / 60));
    }

    public function render()
    {
        return view('livewire.delivery.track-order', [
            'order' => $this->order,
            'statusSteps' => $this->statusSteps,
            'estMinutes' => $this->estMinutes,
        ])->layout('components.layouts.delivery');
    }
}
