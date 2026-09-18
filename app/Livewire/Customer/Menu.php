<?php

namespace App\Livewire\Customer;

use App\Models\Category;
use Livewire\Component;

class Menu extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->withCount(['products' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        $orderMode = session('order_mode', 'TAKE_AWAY');
        $tableNumber = session('table_number');

        return view('livewire.customer.menu', [
            'categories' => $categories,
            'orderMode' => $orderMode,
            'tableNumber' => $tableNumber,
        ])->layout('components.layouts.customer');
    }
}
