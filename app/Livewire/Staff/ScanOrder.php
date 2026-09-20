<?php

namespace App\Livewire\Staff;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ScanOrder extends Component
{
    public string $code = '';
    public ?array $result = null;

    public function mount(): void
    {
        $code = trim((string) request()->query('code', ''));

        if ($code !== '') {
            $this->code = $code;
            $this->process();
        }
    }

    public function process(): void
    {
        $this->result = null;
        $code = strtoupper(trim($this->code));

        if ($code === '') {
            $this->dispatch('toast', message: 'Masukkan atau scan nomor pesanan.', type: 'error');
            return;
        }

        $query = Order::with(['items', 'payment', 'table'])->where('order_number', $code);

        if (! Auth::user()->isAdmin()) {
            $query->where('branch_id', Auth::user()->branch_id);
        }

        $order = $query->first();

        if (! $order) {
            $this->dispatch('toast', message: "Pesanan {$code} tidak ditemukan.", type: 'error');
            return;
        }

        $confirmedNow = false;

        if ($order->status === 'PENDING') {
            $order->update(['status' => 'CONFIRMED']);
            $order->refresh();
            $confirmedNow = true;
            $this->dispatch('toast', message: "Pesanan #{$order->order_number} terkonfirmasi.", type: 'success');
        }

        $this->result = [
            'order_number' => $order->order_number,
            'customer_name' => $order->customer_name ?? 'Tanpa nama',
            'status' => $order->status,
            'total' => (float) $order->total_amount,
            'mode' => $order->order_mode,
            'table' => $order->table?->table_number,
            'item_count' => $order->items->sum('quantity'),
            'confirmed_now' => $confirmedNow,
        ];
        $this->code = '';
        $this->dispatch('scan-done');
    }

    public function render()
    {
        return view('livewire.staff.scan-order')->layout('components.layouts.staff');
    }
}
