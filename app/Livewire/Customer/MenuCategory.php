<?php

namespace App\Livewire\Customer;

use App\Models\Category;
use Livewire\Component;

class MenuCategory extends Component
{
    public Category $category;

    public function mount(string $categorySlug): void
    {
        $this->category = Category::where('slug', $categorySlug)
            ->where('is_active', true)
            ->with(['products' => function ($query) {
                $query->where('is_active', true)->orderBy('sort_order')->with('variants');
            }])
            ->firstOrFail();
    }

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

        return view('livewire.customer.menu-category', [
            'categories' => $categories,
            'orderMode' => $orderMode,
            'tableNumber' => $tableNumber,
        ])->layout('components.layouts.customer');
    }
}
