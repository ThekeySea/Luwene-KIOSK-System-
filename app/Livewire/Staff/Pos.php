<?php

namespace App\Livewire\Staff;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public function advance(string $orderId): void
    {
        $order = Order::where('branch_id', Auth::user()->branch_id)->find($orderId);

        if (! $order) {
            $this->dispatch('toast', message: 'Pesanan tidak ditemukan.', type: 'error');
            return;
        }

        $next = match ($order->status) {
            'PENDING' => 'CONFIRMED',
            'CONFIRMED' => 'PREPARING',
            'PREPARING' => 'READY',
            'READY' => 'COMPLETED',
            default => null,
        };

        if (! $next || ! $order->canTransitionTo($next)) {
            $this->dispatch('toast', message: 'Status tidak dapat diubah.', type: 'error');
            return;
        }

        $order->update(array_merge(
            ['status' => $next],
            $next === 'COMPLETED' ? ['completed_at' => now()] : [],
        ));

        $this->dispatch('toast', message: "Pesanan #{$order->order_number} menjadi {$next}.", type: 'success');
    }

    public function render()
    {
        $pendingOrders = Order::with(['items', 'table'])
            ->where('branch_id', Auth::user()->branch_id)
            ->where('status', '!=', 'COMPLETED')
            ->where('status', '!=', 'CANCELLED')
            ->latest()
            ->get();

        return view('livewire.staff.pos', [
            'pendingOrders' => $pendingOrders,
        ])->layout('components.layouts.staff');
    }
}
