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
        $branchId = session('delivery_branch_id');
        $branch = $branchId ? \App\Models\Branch::find($branchId) : null;
        $deliveryFee = $branch?->delivery_fee ?? 0;

        return view('livewire.delivery.cart', [
            'items' => $this->items,
            'subtotal' => $this->subtotal,
            'deliveryFee' => $deliveryFee,
            'total' => $this->subtotal + $deliveryFee,
            'branchId' => $branchId,
        ])->layout('components.layouts.delivery');
    }
}
