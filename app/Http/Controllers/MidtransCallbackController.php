<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function callback(Request $request)
    {
        $payload = $request->all();
        $orderNumber = $payload['order_id'] ?? null;

        Log::info('Midtrans callback received', $payload);

        if (! $orderNumber) {
            return response()->json(['message' => 'Invalid payload'], 400);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $status = $payload['transaction_status'] ?? '';
        $payment = $order->payment;

        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($status === 'capture' || $status === 'settlement') {
            $payment->update([
                'status' => 'PAID',
                'paid_at' => now(),
                'reference' => $payload['transaction_id'] ?? $payload['payment_type'] ?? null,
            ]);
            $order->update(['payment_status' => 'PAID']);

            Log::info('Midtrans payment PAID', ['order_number' => $orderNumber]);
        } elseif (in_array($status, ['deny', 'cancel', 'expire', 'failure'])) {
            $payment->update([
                'status' => 'FAILED',
                'reference' => $payload['transaction_id'] ?? null,
            ]);

            Log::info('Midtrans payment FAILED', ['order_number' => $orderNumber, 'status' => $status]);
        }

        return response()->json(['message' => 'OK']);
    }

    public function status(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();
        if (! $order) {
            return response()->json(['paid' => false, 'error' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if (! $payment) {
            return response()->json(['paid' => false, 'error' => 'Payment not found'], 404);
        }

        if ($payment->status === 'PAID') {
            return response()->json([
                'paid' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ]);
        }

        try {
            $midtransService = new MidtransService();
            $midtransStatus = $midtransService->getQRStatus($orderNumber);
            $transactionStatus = $midtransStatus['transaction_status'] ?? '';

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $payment->update([
                    'status' => 'PAID',
                    'paid_at' => now(),
                    'reference' => $midtransStatus['transaction_id'] ?? null,
                ]);
                $order->update(['payment_status' => 'PAID']);

                return response()->json([
                    'paid' => true,
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Midtrans status check error', ['error' => $e->getMessage()]);
        }

        return response()->json(['paid' => false]);
    }

    public function bypass(string $orderId)
    {
        $order = Order::find($orderId);
        if (! $order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if (! $payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        $payment->update([
            'status' => 'PAID',
            'paid_at' => now(),
            'reference' => 'BYPASS',
        ]);
        $order->update(['payment_status' => 'PAID']);

        Log::info('Payment bypassed', ['order_number' => $order->order_number]);

        return response()->json([
            'paid' => true,
            'order_id' => $order->id,
            'order_number' => $order->order_number,
        ]);
    }

    public function timeout(string $orderId)
    {
        $order = Order::find($orderId);
        if (! $order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $payment = $order->payment;
        if ($payment && $payment->status !== 'PAID') {
            $payment->update(['status' => 'FAILED']);
        }

        if ($order->status === 'PENDING') {
            $order->update([
                'status' => 'CANCELLED',
                'cancelled_at' => now(),
            ]);
        }

        Log::info('Payment timeout', ['order_number' => $order->order_number]);

        return response()->json(['timeout' => true]);
    }
}
