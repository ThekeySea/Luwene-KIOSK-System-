<?php

namespace App\Livewire\Customer;

use App\Models\Category;
use App\Models\Package;
use App\Models\Product;
use Livewire\Component;

class MenuPage extends Component
{
    public ?string $selectedCategory = null;
    public string $search = '';
    public array $categories = [];
    public array $products = [];
    public array $packages = [];

    public function mount(): void
    {
        if (!session('order_mode')) {
            $this->redirectRoute('customer.entry');
            return;
        }

        $this->categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->toArray();

        $this->packages = Package::with('items.product:id,name,slug,image_url')
            ->where('is_active', true)
            ->get()
            ->toArray();

        $this->loadProducts();
    }

    public function selectCategory(?string $slug): void
    {
        $this->selectedCategory = $slug;
        $this->loadProducts();
    }

    public function loadProducts(): void
    {
        $query = Product::with(['category', 'variants'])
            ->where('is_active', true);

        if ($this->selectedCategory) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->selectedCategory));
        }

        if ($this->search) {
            $query->where('name', 'like', "%{$this->search}%");
        }

        $this->products = $query->orderBy('sort_order')
            ->get()
            ->toArray();
    }

    public function updatedSearch(): void
    {
        $this->loadProducts();
    }

    public function viewProduct(string $slug): void
    {
        $this->redirectRoute('customer.product', ['slug' => $slug]);
    }

    public function render()
    {
        return view('livewire.customer.menu-page')->layout('layouts.customer');
    }
}
