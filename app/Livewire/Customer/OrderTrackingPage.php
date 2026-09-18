<?php

namespace App\Livewire\Customer;

use App\Models\Order;
use Livewire\Component;

class OrderTrackingPage extends Component
{
    public string $orderId = '';
    public ?array $order = null;
    public bool $polling = true;

    public function mount(string $id): void
    {
        $this->orderId = $id;
        $this->loadOrder();
    }

    public function loadOrder(): void
    {
        $order = Order::with(['items.modifiers', 'table', 'payment'])
            ->where('id', $this->orderId)
            ->first();

        if ($order) {
            $this->order = $order->toArray();

            if (in_array($order->status, ['COMPLETED', 'CANCELLED'])) {
                $this->polling = false;
            }
        }
    }

    public function getStatusSteps(): array
    {
        if (!$this->order) return [];

        $currentStatus = $this->order['status'];
        $isTakeAway = $this->order['order_mode'] === 'TAKE_AWAY';

        $steps = [
            ['key' => 'PENDING_PAYMENT', 'label' => 'Menunggu Pembayaran', 'icon' => '💰'],
            ['key' => 'PAID', 'label' => 'Dibayar', 'icon' => '✅'],
            ['key' => 'PREPARING', 'label' => 'Sedang Diproses', 'icon' => '👨‍🍳'],
            ['key' => 'READY', 'label' => 'Siap', 'icon' => '🍽️'],
        ];

        if ($isTakeAway) {
            $steps[] = ['key' => 'PICKED_UP', 'label' => 'Diambil', 'icon' => '🤝'];
        }

        $steps[] = ['key' => 'COMPLETED', 'label' => 'Selesai', 'icon' => '🎉'];

        $statusOrder = array_column($steps, 'key');
        $currentIndex = array_search($currentStatus, $statusOrder);

        if ($currentStatus === 'CANCELLED') {
            return [
                ['key' => 'CANCELLED', 'label' => 'Dibatalkan', 'icon' => '❌', 'status' => 'current'],
            ];
        }

        foreach ($steps as $index => &$step) {
            if ($index < $currentIndex) {
                $step['status'] = 'completed';
            } elseif ($index === $currentIndex) {
                $step['status'] = 'current';
            } else {
                $step['status'] = 'pending';
            }
        }

        return $steps;
    }

    public function getFulfillmentLabel(): string
    {
        if (!$this->order) return '';

        return match($this->order['fulfillment_status']) {
            'WAITING' => 'Menunggu',
            'PREPARING' => 'Sedang Diproses',
            'READY' => 'Siap Diambil',
            'PICKED_UP' => 'Sudah Diambil',
            'COMPLETED' => 'Selesai',
            default => $this->order['fulfillment_status'],
        };
    }

    public function pollStatus(): void
    {
        if ($this->polling) {
            $this->loadOrder();
        }
    }

    public function render()
    {
        return view('livewire.customer.order-tracking-page')->layout('layouts.customer');
    }
}
