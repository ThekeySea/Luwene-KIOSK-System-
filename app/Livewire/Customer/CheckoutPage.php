<?php

namespace App\Livewire\Customer;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckoutPage extends Component
{
    public string $paymentMethod = 'CASH';
    public ?string $error = null;
    public bool $processing = false;

    public function mount(): void
    {
        if (empty(session('cart'))) {
            $this->redirectRoute('customer.menu');
            return;
        }
    }

    public function getSubtotalProperty(): float
    {
        return collect(session('cart', []))->sum('subtotal');
    }

    public function getTaxProperty(): float
    {
        return round($this->subtotal * 0.10);
    }

    public function getTotalProperty(): float
    {
        return $this->subtotal + $this->tax;
    }

    public function selectPayment(string $method): void
    {
        $this->paymentMethod = $method;
    }

    private function getGuestToken(): ?string
    {
        if (session('auth_token')) {
            return session('auth_token');
        }

        $guestEmail = 'guest-' . Str::slug(Str::uuid()) . '@luwene.local';
        $branch = Branch::where('status', 'ACTIVE')->first();

        $response = Http::post(url('/api/v1/auth/login'), [
            'email' => 'guest@luwene.id',
            'password' => 'password',
        ]);

        if ($response->successful()) {
            $token = $response->json('data.token');
            session(['auth_token' => $token]);
            return $token;
        }

        return null;
    }

    public function placeOrder(): void
    {
        $this->processing = true;
        $this->error = null;

        try {
            $cart = session('cart', []);
            $orderMode = session('order_mode');
            $tableId = session('table_id');
            $sessionId = session('dining_session_id');

            $token = $this->getGuestToken();
            if (!$token) {
                $this->error = 'Gagal melakukan autentikasi.';
                return;
            }

            $clientId = (string) Str::uuid();

            $items = [];
            foreach ($cart as $item) {
                $modifiers = [];
                foreach ($item['modifiers'] as $mod) {
                    $modifiers[] = [
                        'type' => $mod['type'],
                        'id' => $mod['id'],
                        'quantity' => $mod['quantity'] ?? 1,
                    ];
                }

                $items[] = [
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'modifiers' => $modifiers,
                ];
            }

            $payload = [
                'client_order_id' => $clientId,
                'order_mode' => $orderMode,
                'items' => $items,
                'payment_method' => $this->paymentMethod,
            ];

            if ($orderMode === 'DINE_IN') {
                $payload['table_id'] = $tableId;
                $payload['dining_session_id'] = $sessionId;
            }

            $response = Http::withToken($token)
                ->post(url('/api/v1/orders'), $payload);

            if ($response->successful()) {
                $data = $response->json('data');
                session(['cart' => []]);
                $this->dispatch('cartUpdated');
                $this->redirectRoute('customer.order-tracking', ['id' => $data['id']]);
            } else {
                $this->error = $response->json('message') ?? 'Gagal membuat order. Silakan coba lagi.';
            }
        } catch (\Exception $e) {
            $this->error = 'Terjadi kesalahan: ' . $e->getMessage();
        } finally {
            $this->processing = false;
        }
    }

    public function render()
    {
        $cart = session('cart', []);
        $orderMode = session('order_mode');
        $tableName = session('table_name');

        return view('livewire.customer.checkout-page', [
            'cart' => $cart,
            'orderMode' => $orderMode,
            'tableName' => $tableName,
        ])->layout('layouts.customer');
    }
}
