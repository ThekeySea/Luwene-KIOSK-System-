<?php

namespace App\Livewire\Customer;

use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemModifier;
use App\Models\Payment;
use App\Models\RestaurantTable;
use App\Models\Setting;
use App\Services\CartPricing;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{
    public string $paymentMethod = 'CASH';
    public string $notes = '';
    public bool $isSubmitting = false;

    protected array $rules = [
        'paymentMethod' => 'required|in:CASH,QRIS',
    ];

    public function getItemsProperty(): array
    {
        return CartPricing::items();
    }

    public function getSubtotalProperty(): float
    {
        return CartPricing::subtotal();
    }

    public function getDiscountProperty(): float
    {
        return CartPricing::discount();
    }

    public function getTaxProperty(): float
    {
        return CartPricing::tax();
    }

    public function getTotalProperty(): float
    {
        return CartPricing::total();
    }

    public function submitOrder()
    {
        $this->validate();

        if (! session('customer_name') || ! session('customer_phone')) {
            return redirect()->route('customer.info');
        }

        if (empty($this->items)) {
            session()->flash('error', 'Keranjang kosong.');
            return;
        }

        $this->isSubmitting = true;

        try {
            $orderMode = session('order_mode', 'TAKE_AWAY');
            $tableId = session('table_id');
            $diningSessionId = session('dining_session_id');
            $branchId = session('active_branch_id') ?? Branch::first()?->id;

            if (! $branchId) {
                session()->flash('error', 'Cabang belum tersedia.');
                return;
            }

            $maxNumber = Order::where('branch_id', $branchId)->max('order_number');
            $prefix = Setting::get('order_prefix', 'LW');
            $next = $maxNumber ? (int) substr($maxNumber, strlen($prefix) + 1) + 1 : 1;
            $orderNumber = $prefix . '-' . str_pad($next, 5, '0', STR_PAD_LEFT);

            $order = Order::create([
                'branch_id' => $branchId,
                'user_id' => auth()->id(),
                'customer_name' => session('customer_name'),
                'customer_email' => session('customer_email'),
                'customer_phone' => session('customer_phone'),
                'table_id' => $tableId,
                'dining_session_id' => $diningSessionId,
                'client_order_id' => Str::uuid()->toString(),
                'order_number' => $orderNumber,
                'order_mode' => $orderMode,
                'status' => 'PENDING',
                'payment_status' => 'UNPAID',
                'subtotal' => $this->subtotal,
                'tax_amount' => $this->tax,
                'discount_amount' => $this->discount,
                'total_amount' => $this->total,
                'notes' => $this->notes,
            ]);

            foreach ($this->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant']['id'] ?? null,
                    'product_name' => $item['product_name'],
                    'variant_name' => $item['variant']['name'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'] ?? $item['variant']['price'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                foreach ($item['modifiers'] as $mod) {
                    OrderItemModifier::create([
                        'order_item_id' => $orderItem->id,
                        // SAMBAL & SPICE_LEVEL hidup di tabel sendiri, simpan sebagai snapshot (FK null).
                        // Hanya EXTRA & NASI yang merujuk baris asli tabel modifiers.
                        'modifier_id' => in_array($mod['type'] ?? '', ['EXTRA', 'NASI'], true) ? $mod['id'] : null,
                        'modifier_name' => $mod['name'],
                        'modifier_type' => $mod['type'],
                        'price' => $mod['price'],
                    ]);
                }
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $this->paymentMethod,
                'amount' => $this->total,
                'status' => 'PAID',
                'paid_at' => now(),
            ]);

            $order->update(['payment_status' => 'PAID']);

            if ($promo = CartPricing::promo()) {
                $promo->increment('used_count');
            }

            session()->forget('cart');
            session()->forget('promo_code');

            return redirect()->route('customer.order-success', $order->id);
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        $orderMode = session('order_mode', 'TAKE_AWAY');
        $tableNumber = session('table_number');

        return view('livewire.customer.checkout', [
            'orderMode' => $orderMode,
            'tableNumber' => $tableNumber,
            'items' => $this->items,
            'customerName' => session('customer_name'),
            'customerEmail' => session('customer_email'),
            'customerPhone' => session('customer_phone'),
            'subtotal' => $this->subtotal,
            'promo' => CartPricing::promo(),
            'discount' => $this->discount,
            'tax' => $this->tax,
            'total' => $this->total,
        ])->layout('components.layouts.customer', ['showNav' => false]);
    }
}
