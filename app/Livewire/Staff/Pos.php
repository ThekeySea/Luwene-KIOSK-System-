<?php

namespace App\Livewire\Staff;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Pos extends Component
{
    public function render()
    {
        $pendingOrders = Order::with('items')
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
