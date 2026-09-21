<?php

namespace App\Livewire\Delivery;

use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemModifier;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{
    public ?string $selectedAddressId = null;
    public string $paymentMethod = 'COD';
    public string $deliveryNotes = '';
    public bool $isSubmitting = false;

    protected array $rules = [
        'selectedAddressId' => 'required',
        'paymentMethod' => 'required|in:COD,QRIS',
    ];

    public function getItemsProperty(): array
    {
        return session('delivery_cart', []);
    }

    public function getSubtotalProperty(): float
    {
        return (float) collect($this->items)->sum('subtotal');
    }

    public function getDeliveryFeeProperty(): float
    {
        return (float) Setting::get('delivery_fee', 5000);
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal + $this->deliveryFee;
    }

    public function getAddressesProperty()
    {
        return DeliveryAddress::where('user_id', auth()->id())->latest('is_default')->get();
    }

    public function mount(): void
    {
        $cart = session('delivery_cart', []);
        if (empty($cart)) {
            redirect()->route('delivery.cart');
            return;
        }

        $default = DeliveryAddress::where('user_id', auth()->id())->where('is_default', true)->first();
        if ($default) {
            $this->selectedAddressId = $default->id;
        } else {
            $first = DeliveryAddress::where('user_id', auth()->id())->first();
            $this->selectedAddressId = $first?->id;
        }
    }

    public function submitOrder()
    {
        $this->validate();

        if (empty($this->items)) {
            $this->dispatch('toast', message: 'Keranjang kosong.', type: 'error');
            return;
        }

        $this->isSubmitting = true;

        try {
            $branch = \App\Models\Branch::first();
            $address = DeliveryAddress::where('user_id', auth()->id())->find($this->selectedAddressId);

            if (! $branch || ! $address) {
                $this->dispatch('toast', message: 'Data tidak lengkap.', type: 'error');
                return;
            }

            $maxNumber = Order::max('order_number');
            $prefix = Setting::get('order_prefix', 'LW');
            $next = $maxNumber ? (int) substr($maxNumber, strlen($prefix) + 1) + 1 : 1;
            $orderNumber = $prefix . '-' . str_pad($next, 5, '0', STR_PAD_LEFT);

            $estMinutes = (int) Setting::get('estimated_delivery_minutes', 30);
            $deliveryAddressFull = $address->address . ($address->label ? " ({$address->label})" : '');

            $order = Order::create([
                'branch_id' => $branch->id,
                'user_id' => auth()->id(),
                'customer_name' => auth()->user()->name,
                'customer_email' => auth()->user()->email,
                'customer_phone' => auth()->user()->phone ?? '-',
                'client_order_id' => Str::uuid()->toString(),
                'order_number' => $orderNumber,
                'order_mode' => 'DELIVERY',
                'status' => 'PENDING',
                'payment_status' => 'UNPAID',
                'subtotal' => $this->subtotal,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => $this->total,
                'notes' => $this->deliveryNotes,
                'delivery_address' => $deliveryAddressFull,
                'delivery_fee' => $this->deliveryFee,
                'delivery_notes' => $this->deliveryNotes,
                'delivery_estimated_at' => now()->addMinutes($estMinutes),
            ]);

            foreach ($this->items as $item) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant']['id'] ?? null,
                    'product_name' => $item['product_name'],
                    'variant_name' => $item['variant']['name'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'subtotal' => $item['subtotal'],
                ]);

                foreach ($item['modifiers'] ?? [] as $mod) {
                    OrderItemModifier::create([
                        'order_item_id' => $orderItem->id,
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
                'status' => $this->paymentMethod === 'QRIS' ? 'PAID' : 'PENDING',
                'paid_at' => $this->paymentMethod === 'QRIS' ? now() : null,
            ]);

            if ($this->paymentMethod === 'QRIS') {
                $order->update(['payment_status' => 'PAID']);
            }

            session()->forget('delivery_cart');

            return redirect()->route('delivery.track', $order->id);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Gagal membuat pesanan: ' . $e->getMessage(), type: 'error');
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function render()
    {
        return view('livewire.delivery.checkout', [
            'items' => $this->items,
            'subtotal' => $this->subtotal,
            'deliveryFee' => $this->deliveryFee,
            'total' => $this->total,
            'addresses' => $this->addresses,
        ])->layout('components.layouts.delivery');
    }
}
