<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CashierOrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Order::with(['items', 'table', 'payment']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $query->where('order_number', 'like', "%{$request->search}%");
        }

        $orders = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $order = Order::with(['items.modifiers', 'table', 'payment'])->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'ORDER_NOT_FOUND', 'message' => 'Order tidak ditemukan.'],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function updateStatus(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:PREPARING,READY,COMPLETED,CANCELLED',
        ]);

        $order = Order::findOrFail($id);

        $validTransitions = [
            'PENDING_PAYMENT' => ['PREPARING', 'CANCELLED'],
            'PAID' => ['PREPARING', 'CANCELLED'],
            'PREPARING' => ['READY', 'CANCELLED'],
            'READY' => ['COMPLETED'],
        ];

        $currentStatus = $order->status;

        if (!isset($validTransitions[$currentStatus]) || !in_array($validated['status'], $validTransitions[$currentStatus])) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'INVALID_TRANSITION', 'message' => "Transisi dari {$currentStatus} ke {$validated['status']} tidak valid."],
            ], 422);
        }

        $order->update(['status' => $validated['status']]);

        if ($validated['status'] === 'COMPLETED' && $order->payment && $order->payment->status !== 'PAID') {
            $order->payment->update([
                'status' => 'PAID',
                'verified_by' => $request->user()->id,
                'paid_at' => now(),
            ]);
        }

        $order->load(['items', 'table', 'payment']);

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => "Order {$validated['status']}.",
        ]);
    }

    public function verifyPayment(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'amount_received' => 'nullable|numeric|min:0',
        ]);

        $order = Order::with('payment')->findOrFail($id);

        if (!$order->payment) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'NO_PAYMENT', 'message' => 'Tidak ada data pembayaran untuk order ini.'],
            ], 404);
        }

        $order->payment->update([
            'status' => 'PAID',
            'verified_by' => $request->user()->id,
            'paid_at' => now(),
        ]);

        $order->update(['status' => 'PAID']);

        return response()->json([
            'success' => true,
            'data' => $order->payment,
            'message' => 'Pembayaran berhasil diverifikasi.',
        ]);
    }
}
