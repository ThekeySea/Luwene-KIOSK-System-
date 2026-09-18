<?php

namespace App\Livewire\Customer;

use Livewire\Component;

class CartPage extends Component
{
    public array $cart = [];

    public function mount(): void
    {
        if (!session('order_mode')) {
            $this->redirectRoute('customer.entry');
            return;
        }

        $this->cart = session('cart', []);
    }

    public function removeItem(string $itemId): void
    {
        $cart = session('cart', []);
        $cart = array_filter($cart, fn ($item) => $item['id'] !== $itemId);
        session(['cart' => array_values($cart)]);
        $this->cart = session('cart', []);
        $this->dispatch('cartUpdated');
    }

    public function updateQuantity(string $itemId, int $delta): void
    {
        $cart = session('cart', []);
        foreach ($cart as &$item) {
            if ($item['id'] === $itemId) {
                $newQty = $item['quantity'] + $delta;
                if ($newQty >= 1 && $newQty <= 20) {
                    $modifierTotal = collect($item['modifiers'])->sum('price');
                    $item['quantity'] = $newQty;
                    $item['subtotal'] = ($item['unit_price'] + $modifierTotal) * $newQty;
                }
                break;
            }
        }
        session(['cart' => $cart]);
        $this->cart = session('cart', []);
        $this->dispatch('cartUpdated');
    }

    public function getSubtotalProperty(): float
    {
        return collect($this->cart)->sum('subtotal');
    }

    public function goToCheckout(): void
    {
        if (empty($this->cart)) {
            return;
        }
        $this->redirectRoute('customer.checkout');
    }

    public function render()
    {
        return view('livewire.customer.cart-page')->layout('layouts.customer');
    }
}
