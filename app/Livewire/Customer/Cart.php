<?php

namespace App\Livewire\Customer;

use App\Services\CartPricing;
use Livewire\Component;

class Cart extends Component
{
    public function updateQuantity(string $itemId, int $newQty): void
    {
        if ($newQty < 1) return;

        $cart = session('cart', []);
        foreach ($cart as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] = $newQty;
                $unit = $item['unit_price'] ?? (($item['variant']['price'] ?? 0) + collect($item['modifiers'])->sum('price'));
                $item['unit_price'] = $unit;
                $item['subtotal'] = $unit * $newQty;
                break;
            }
        }
        session()->put('cart', $cart);
    }

    public function removeItem(string $itemId): void
    {
        $cart = session('cart', []);
        $cart = array_filter($cart, fn($item) => $item['id'] !== $itemId);
        session()->put('cart', array_values($cart));
    }

    public function clearCart(): void
    {
        session()->forget('cart');
    }

    public function render()
    {
        return view('livewire.customer.cart', [
            'orderMode' => session('order_mode', 'TAKE_AWAY'),
            'tableNumber' => session('table_number'),
            'items' => CartPricing::items(),
            'subtotal' => CartPricing::subtotal(),
            'promo' => CartPricing::promo(),
            'promoCode' => CartPricing::promoCode(),
            'discount' => CartPricing::discount(),
            'tax' => CartPricing::tax(),
            'total' => CartPricing::total(),
        ])->layout('components.layouts.customer');
    }
}
