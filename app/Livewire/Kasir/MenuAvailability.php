<?php

namespace App\Livewire\Kasir;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class MenuAvailability extends Component
{
    public array $categories = [];
    public array $products = [];
    public string $selectedCategory = '';

    public function mount(): void
    {
        $this->categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->toArray();
        $this->loadProducts();
    }

    public function loadProducts(): void
    {
        $query = Product::with('category');

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        $this->products = $query->orderBy('name')->get()->toArray();
    }

    public function toggleAvailability(string $productId): void
    {
        $product = Product::findOrFail($productId);
        $product->update(['is_available' => !$product->is_available]);
        $this->loadProducts();
    }

    public function render()
    {
        return view('livewire.kasir.menu-availability')->layout('layouts.staff');
    }
}
