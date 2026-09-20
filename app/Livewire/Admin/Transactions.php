<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;

class Transactions extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $paymentFilter = '';
    public string $dateFilter = '';
    public string $modeFilter = '';
    public ?string $expandedId = null;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingPaymentFilter(): void
    {
        $this->resetPage();
    }

    public function updatingDateFilter(): void
    {
        $this->resetPage();
    }

    public function updatingModeFilter(): void
    {
        $this->resetPage();
    }

    public function toggleExpand(string $id): void
    {
        $this->expandedId = $this->expandedId === $id ? null : $id;
    }

    public function render()
    {
        $orders = Order::with(['items.modifiers', 'payment', 'table'])
            ->when($this->search !== '', fn ($q) => $q->where(function ($qq) {
                $qq->where('order_number', 'like', '%'.$this->search.'%')
                    ->orWhere('customer_name', 'like', '%'.$this->search.'%');
            }))
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter !== '', fn ($q) => $q->where('payment_status', $this->paymentFilter))
            ->when($this->dateFilter !== '', fn ($q) => $q->whereDate('created_at', $this->dateFilter))
            ->when($this->modeFilter !== '', fn ($q) => $q->where('order_mode', $this->modeFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.transactions', [
            'orders' => $orders,
        ])->layout('components.layouts.admin', [
            'pageTitle' => 'Transaksi',
        ]);
    }
}
