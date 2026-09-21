<?php

namespace App\Livewire\Delivery;

use App\Models\Category;
use App\Models\Setting;
use Livewire\Component;

class Home extends Component
{
    public string $search = '';

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
            ->with('variants');

        if ($this->search !== '') {
            $productsQuery->where('name', 'like', "%{$this->search}%");
        }

        $products = $productsQuery->orderBy('sort_order')->get();

        $cartCount = collect(session('delivery_cart', []))->sum('quantity');
        $deliveryFee = (float) Setting::get('delivery_fee', 5000);
        $estMinutes = (int) Setting::get('estimated_delivery_minutes', 30);

        return view('livewire.delivery.home', [
            'categories' => $categories,
            'products' => $products,
            'cartCount' => $cartCount,
            'deliveryFee' => $deliveryFee,
            'estMinutes' => $estMinutes,
            'user' => auth()->user(),
        ])->layout('components.layouts.delivery');
    }
}
