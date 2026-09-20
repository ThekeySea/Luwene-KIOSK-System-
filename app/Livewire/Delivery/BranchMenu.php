<?php

namespace App\Livewire\Delivery;

use App\Models\Branch;
use App\Models\Category;
use Livewire\Component;

class BranchMenu extends Component
{
    public Branch $branch;
    public ?string $activeCategory = null;

    public function mount(string $branchId): void
    {
        $this->branch = Branch::where('status', 'ACTIVE')->findOrFail($branchId);
        session()->put('delivery_branch_id', $this->branch->id);
    }

    public function setCategory(?string $slug): void
    {
        $this->activeCategory = $slug;
    }

    public function render()
    {
        $categories = Category::where('is_active', true)
            ->where('is_published', true)
            ->withCount(['products' => function ($q) {
                $q->where('is_active', true)
                    ->where('is_published', true)
                    ->where('is_published_delivery', true);
            }])
            ->orderBy('sort_order')
            ->get()
            ->filter(fn ($cat) => $cat->products_count > 0)
            ->values();

        $productsQuery = \App\Models\Product::where('is_active', true)
            ->where('is_published', true)
            ->where('is_published_delivery', true)
            ->where('is_available', true)
            ->with('variants');

        if ($this->activeCategory) {
            $productsQuery->whereHas('category', fn ($q) => $q->where('slug', $this->activeCategory));
        }

        $products = $productsQuery->orderBy('sort_order')->get();

        $cartCount = collect(session('delivery_cart', []))->sum('quantity');

        return view('livewire.delivery.branch-menu', [
            'categories' => $categories,
            'products' => $products,
            'cartCount' => $cartCount,
        ])->layout('components.layouts.delivery');
    }
}
