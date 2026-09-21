<?php

namespace App\Livewire\Staff;

use App\Models\DiningSession;
use App\Models\Order;
use App\Models\RestaurantTable;
use Livewire\Component;

class Pos extends Component
{
    public ?string $driverName = null;
    public ?string $driverPhone = null;
    public ?string $advanceOrderId = null;
    public bool $showDriverModal = false;
    public bool $showCancelModal = false;
    public ?string $cancelOrderId = null;

    public function openDriverModal(string $orderId): void
    {
        $this->advanceOrderId = $orderId;
        $this->driverName = '';
        $this->driverPhone = '';
        $this->showDriverModal = true;
    }

    public function confirmAdvanceWithDriver(): void
    {
        $this->validate([
            'driverName' => 'required|string|max:255',
        ]);

        $order = Order::find($this->advanceOrderId);

        if (! $order || ! $order->canTransitionTo('OUT_FOR_DELIVERY')) {
            $this->dispatch('toast', message: 'Status tidak dapat diubah.', type: 'error');
            $this->showDriverModal = false;
            return;
        }

        $order->update([
            'status' => 'OUT_FOR_DELIVERY',
            'driver_name' => $this->driverName,
            'driver_phone' => $this->driverPhone,
        ]);

        $this->showDriverModal = false;
        $this->dispatch('toast', message: "Pesanan #{$order->order_number} sedang dikirim oleh {$this->driverName}.", type: 'success');
    }

    public function openCancelModal(string $orderId): void
    {
        $this->cancelOrderId = $orderId;
        $this->showCancelModal = true;
    }

    public function confirmCancel(): void
    {
        $order = Order::find($this->cancelOrderId);

        if (! $order || ! $order->canTransitionTo('CANCELLED')) {
            $this->dispatch('toast', message: 'Pesanan tidak dapat dibatalkan.', type: 'error');
            $this->showCancelModal = false;
            return;
        }

        $order->update([
            'status' => 'CANCELLED',
            'cancelled_at' => now(),
        ]);

        $this->releaseTable($order);

        $this->showCancelModal = false;
        $this->dispatch('toast', message: "Pesanan #{$order->order_number} dibatalkan.", type: 'success');
    }

    public function advance(string $orderId): void
    {
        $order = Order::find($orderId);

        if (! $order) {
            $this->dispatch('toast', message: 'Pesanan tidak ditemukan.', type: 'error');
            return;
        }

        $next = match ($order->status) {
            'PENDING' => 'CONFIRMED',
            'CONFIRMED' => 'PREPARING',
            'PREPARING' => 'READY',
            'READY' => 'COMPLETED',
            'OUT_FOR_DELIVERY' => 'DELIVERED',
            default => null,
        };

        if ($order->status === 'READY' && $order->order_mode === 'DELIVERY') {
            $this->openDriverModal($orderId);
            return;
        }

        if (! $next || ! $order->canTransitionTo($next)) {
            $this->dispatch('toast', message: 'Status tidak dapat diubah.', type: 'error');
            return;
        }

        $order->update(array_merge(
            ['status' => $next],
            in_array($next, ['COMPLETED', 'DELIVERED']) ? ['completed_at' => now()] : [],
        ));

        if (in_array($next, ['COMPLETED', 'DELIVERED'])) {
            $this->releaseTable($order);
        }

        $this->dispatch('toast', message: "Pesanan #{$order->order_number} menjadi {$next}.", type: 'success');
    }

    private function releaseTable(Order $order): void
    {
        if ($order->table_id) {
            RestaurantTable::where('id', $order->table_id)
                ->where('status', 'OCCUPIED')
                ->update(['status' => 'AVAILABLE']);
        }

        if ($order->dining_session_id) {
            DiningSession::where('id', $order->dining_session_id)
                ->where('status', 'ACTIVE')
                ->update(['status' => 'CLOSED', 'closed_at' => now()]);
        }
    }

    public function render()
    {
        $pendingOrders = Order::with(['items', 'table'])
            ->whereNotIn('status', ['COMPLETED', 'CANCELLED', 'DELIVERED'])
            ->latest()
            ->get();

        return view('livewire.staff.pos', [
            'pendingOrders' => $pendingOrders,
        ])->layout('components.layouts.staff');
    }
}
