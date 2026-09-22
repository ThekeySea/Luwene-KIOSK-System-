<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $apiUrl;
    protected string $serverKey;
    protected string $clientKey;
    protected string $merchantId;

    public function __construct()
    {
        $this->apiUrl = config('services.midtrans.api_url');
        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->merchantId = config('services.midtrans.merchant_id');
    }

    public function chargeQRIS(Order $order): array
    {
        $payload = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total_amount,
            ],
            'merchant' => [
                'id' => $this->merchantId,
            ],
            'callbacks' => [
                'finish' => route('customer.order-success', $order->id),
            ],
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->timeout(15)
            ->post("{$this->apiUrl}/v2/charge", $payload);

        Log::info('Midtrans QRIS charge', [
            'order_number' => $order->order_number,
            'status' => $response->status(),
            'body' => $response->json(),
        ]);

        if (! $response->successful()) {
            throw new \RuntimeException('Midtrans charge failed: ' . $response->body());
        }

        return $response->json();
    }

    public function getQRStatus(string $orderNumber): array
    {
        $response = Http::withBasicAuth($this->serverKey, '')
            ->timeout(10)
            ->get("{$this->apiUrl}/v2/{$orderNumber}/status");

        if (! $response->successful()) {
            throw new \RuntimeException('Midtrans status check failed: ' . $response->body());
        }

        return $response->json();
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    public function isProduction(): bool
    {
        return config('services.midtrans.is_production', false);
    }
}
