<?php

namespace App\Livewire\Delivery;

use Livewire\Component;

class Cart extends Component
{
    public function getItemsProperty(): array
    {
        return session('delivery_cart', []);
    }

    public function getSubtotalProperty(): float
    {
        return (float) collect($this->items)->sum('subtotal');
    }

    public function removeItem(string $itemId): void
    {
        $cart = session('delivery_cart', []);
        $cart = array_values(array_filter($cart, fn ($item) => $item['id'] !== $itemId));
        session()->put('delivery_cart', $cart);
    }

    public function updateQuantity(string $itemId, int $delta): void
    {
        $cart = session('delivery_cart', []);

        foreach ($cart as &$item) {
            if ($item['id'] === $itemId) {
                $item['quantity'] = max(1, min(20, $item['quantity'] + $delta));
                $item['subtotal'] = $item['unit_price'] * $item['quantity'];
                break;
            }
        }
        unset($item);

        session()->put('delivery_cart', $cart);
    }

    public function render()
    {
        $deliveryFee = (float) \App\Models\Setting::get('delivery_fee', 5000);

        return view('livewire.delivery.cart', [
            'items' => $this->items,
            'subtotal' => $this->subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $this->subtotal + $deliveryFee,
        ])->layout('components.layouts.delivery');
    }
}
