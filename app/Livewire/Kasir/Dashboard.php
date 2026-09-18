<?php

namespace App\Livewire\Kasir;

use App\Models\Order;
use Livewire\Component;

class Dashboard extends Component
{
    public string $statusFilter = 'all';
    public string $search = '';
    public array $orders = [];
    public int $pendingCount = 0;
    public int $preparingCount = 0;
    public int $readyCount = 0;

    public function mount(): void
    {
        $this->loadOrders();
    }

    public function updatedStatusFilter(): void
    {
        $this->loadOrders();
    }

    public function updatedSearch(): void
    {
        $this->loadOrders();
    }

    public function loadOrders(): void
    {
        $query = Order::with(['items', 'table', 'payment']);

        if ($this->statusFilter !== 'all') {
            $query->where('status', strtoupper($this->statusFilter));
        }

        if ($this->search) {
            $query->where('order_number', 'like', "%{$this->search}%");
        }

        $this->orders = $query->latest()->get()->toArray();
        $this->pendingCount = Order::where('status', 'PENDING_PAYMENT')->count();
        $this->preparingCount = Order::where('status', 'PREPARING')->count();
        $this->readyCount = Order::where('status', 'READY')->count();
    }

    public function markPreparing(string $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'PREPARING']);
        $this->loadOrders();
    }

    public function markReady(string $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'READY']);
        $this->loadOrders();
    }

    public function markCompleted(string $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'COMPLETED']);
        $this->loadOrders();
    }

    public function verifyPayment(string $orderId): void
    {
        $order = Order::findOrFail($orderId);
        $order->update(['status' => 'PAID']);

        if ($order->payment) {
            $order->payment->update([
                'status' => 'PAID',
                'verified_by' => auth()->id(),
                'paid_at' => now(),
            ]);
        }

        $this->loadOrders();
    }

    public function render()
    {
        return view('livewire.kasir.dashboard')->layout('layouts.staff');
    }
}
