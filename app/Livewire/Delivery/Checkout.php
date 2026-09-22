<?php

namespace App\Livewire\Delivery;

use App\Models\DeliveryAddress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemModifier;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;

class Checkout extends Component
{
    public ?string $selectedAddressId = null;
    public string $paymentMethod = 'COD';
    public string $deliveryNotes = '';
    public bool $showConfirmModal = false;
    public bool $showSuccess = false;
    public ?string $successOrderNumber = null;
    public ?string $orderId = null;

    // QRIS overlay data
    public bool $showQRIS = false;
    public ?string $qrString = null;
    public ?string $qrOrderId = null;
    public ?string $qrOrderNumber = null;
    public ?string $qrCustomerName = null;
    public ?string $qrOrderTime = null;
    public ?string $qrOrderMode = 'DELIVERY';
    public ?float $qrTotal = null;
    public ?array $qrItems = null;

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

        $this->showConfirmModal = true;
    }

    public function confirmOrder()
    {
        $this->showConfirmModal = false;

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

        $isQRIS = $this->paymentMethod === 'QRIS';

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
            'payment_status' => $isQRIS ? 'UNPAID' : 'UNPAID',
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

        if ($isQRIS) {
            Payment::create([
                'order_id' => $order->id,
                'method' => 'QRIS',
                'amount' => $this->total,
                'status' => 'UNPAID',
            ]);

            $qrString = null;

            try {
                $midtransService = new MidtransService();
                $chargeResult = $midtransService->chargeQRIS($order);

                $qrString = $chargeResult['actions'][0]['url']
                    ?? $chargeResult['qr_string']
                    ?? $chargeResult['deeplink']
                    ?? null;
            } catch (\Exception $e) {
                Log::warning('Midtrans QRIS charge failed, using fallback QR', [
                    'order_number' => $orderNumber,
                    'error' => $e->getMessage(),
                ]);
            }

            if (! $qrString) {
                $qrString = 'MIDTRANS|' . $orderNumber . '|' . number_format($this->total, 0, ',', '.') . '|PAY';
            }

            $this->qrString = $qrString;
            $this->qrOrderId = $order->id;
            $this->qrOrderNumber = $orderNumber;
            $this->qrCustomerName = auth()->user()->name;
            $this->qrOrderTime = now()->format('d M Y, H:i');
            $this->qrOrderMode = 'DELIVERY';
            $this->qrTotal = $this->total;
            $this->qrItems = collect($this->items)->map(fn($i) => [
                'product_name' => $i['product_name'],
                'quantity' => $i['quantity'],
            ])->toArray();

            $this->dispatch('show-qris',
                qrString: $qrString,
                orderId: $order->id,
                orderNumber: $orderNumber,
                customerName: auth()->user()->name,
                orderTime: now()->format('d M Y, H:i'),
                orderMode: 'DELIVERY',
                items: $this->qrItems,
                total: $this->total,
                bypassUrl: route('payment.bypass', $order->id),
                timeoutUrl: route('payment.timeout', $order->id),
                statusUrl: route('payment.midtrans.status', $orderNumber),
                successUrl: route('delivery.track', $order->id),
            );

        } else {
            Payment::create([
                'order_id' => $order->id,
                'method' => 'COD',
                'amount' => $this->total,
                'status' => 'UNPAID',
                'paid_at' => null,
            ]);

            session()->forget('delivery_cart');

            $this->successOrderNumber = $orderNumber;
            $this->orderId = $order->id;
            $this->showSuccess = true;
        }
    }

    public function goToTrack(): void
    {
        $this->redirect(route('delivery.track', $this->orderId));
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
