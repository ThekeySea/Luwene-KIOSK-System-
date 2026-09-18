<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiningSession;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemModifier;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\RestaurantTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerOrderController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'client_order_id' => 'required|string|max:100',
            'order_mode' => 'required|in:DINE_IN,TAKE_AWAY',
            'table_id' => 'required_if:order_mode,DINE_IN|nullable|uuid',
            'dining_session_id' => 'required_if:order_mode,DINE_IN|nullable|uuid',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|uuid|exists:products,id',
            'items.*.variant_id' => 'required|uuid|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.modifiers' => 'nullable|array',
            'items.*.modifiers.*.type' => 'required|in:nasi,sambal,spice_level,extra',
            'items.*.modifiers.*.id' => 'required|uuid',
            'items.*.modifiers.*.quantity' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:CASH,QRIS',
        ]);

        $branch = $request->user()->branch ?? \App\Models\Branch::where('status', 'ACTIVE')->first();

        $existingOrder = Order::where('branch_id', $branch->id)
            ->where('client_order_id', $validated['client_order_id'])
            ->first();

        if ($existingOrder) {
            return response()->json([
                'success' => true,
                'data' => $existingOrder->load('items.modifiers'),
                'message' => 'Order sudah diproses sebelumnya.',
            ]);
        }

        $order = DB::transaction(function () use ($validated, $branch, $request) {
            $table = null;
            $session = null;

            if ($validated['order_mode'] === 'DINE_IN') {
                $table = RestaurantTable::findOrFail($validated['table_id']);
                $session = DiningSession::findOrFail($validated['dining_session_id']);

                if ($session->status !== 'OPEN') {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'dining_session_id' => 'Sesi makan sudah ditutup.',
                    ]);
                }

                if ($table->status === 'OCCUPIED' && !$table->diningSessions()->where('id', $session->id)->exists()) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'table_id' => 'Meja sedang digunakan oleh sesi lain.',
                    ]);
                }
            }

            $subtotal = 0;
            $itemsData = [];

            foreach ($validated['items'] as $itemData) {
                $product = Product::where('is_active', true)->where('is_available', true)->findOrFail($itemData['product_id']);
                $variant = ProductVariant::where('is_active', true)->findOrFail($itemData['variant_id']);

                if ($variant->product_id !== $product->id) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        "items.{$itemData['product_id']}.variant_id" => 'Variant bukan milik produk ini.',
                    ]);
                }

                $itemSubtotal = $variant->price * $itemData['quantity'];
                $modifierTotal = 0;
                $modifiersData = [];

                if (!empty($itemData['modifiers'])) {
                    foreach ($itemData['modifiers'] as $mod) {
                        $modPrice = 0;
                        $modName = '';

                        switch ($mod['type']) {
                            case 'sambal':
                                $sambal = \App\Models\Sambal::where('is_active', true)->findOrFail($mod['id']);
                                $modPrice = $sambal->price;
                                $modName = $sambal->name;
                                break;
                            case 'spice_level':
                                $level = \App\Models\SpiceLevel::where('is_active', true)->findOrFail($mod['id']);
                                $modPrice = 0;
                                $modName = "{$level->name}";
                                break;
                            case 'extra':
                                $modifier = \App\Models\Modifier::where('is_active', true)->findOrFail($mod['id']);
                                $modPrice = $modifier->price;
                                $modName = $modifier->name;
                                break;
                            case 'nasi':
                                $modifier = \App\Models\Modifier::findOrFail($mod['id']);
                                $modPrice = $modifier->price;
                                $modName = $modifier->name;
                                break;
                        }

                        $modQty = $mod['quantity'] ?? 1;
                        $modifierTotal += $modPrice * $modQty;

                        $modifiersData[] = [
                            'type' => $mod['type'],
                            'id' => $mod['id'],
                            'name' => $modName,
                            'price' => $modPrice,
                            'quantity' => $modQty,
                        ];
                    }
                }

                $itemSubtotal += $modifierTotal;
                $subtotal += $itemSubtotal;

                $itemsData[] = [
                    'product' => $product,
                    'variant' => $variant,
                    'quantity' => $itemData['quantity'],
                    'subtotal' => $itemSubtotal,
                    'modifiers' => $modifiersData,
                ];
            }

            $taxRate = 0.10;
            $taxAmount = round($subtotal * $taxRate);
            $serviceCharge = 0;
            $grandTotal = $subtotal + $taxAmount + $serviceCharge;

            $orderNumber = Order::generateOrderNumber($branch->id);

            $order = Order::create([
                'branch_id' => $branch->id,
                'customer_id' => $request->user()->isCustomer() ? $request->user()->id : null,
                'table_id' => $table?->id,
                'dining_session_id' => $session?->id,
                'client_order_id' => $validated['client_order_id'],
                'order_number' => $orderNumber,
                'order_mode' => $validated['order_mode'],
                'status' => 'PENDING_PAYMENT',
                'fulfillment_status' => 'WAITING',
                'payment_status' => 'PENDING',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'service_charge' => $serviceCharge,
                'grand_total' => $grandTotal,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($itemsData as $itemData) {
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $itemData['product']->id,
                    'product_variant_id' => $itemData['variant']->id,
                    'product_name_snapshot' => $itemData['product']->name,
                    'variant_name_snapshot' => $itemData['variant']->name,
                    'unit_price' => $itemData['variant']->price,
                    'quantity' => $itemData['quantity'],
                    'subtotal' => $itemData['subtotal'],
                ]);

                foreach ($itemData['modifiers'] as $mod) {
                    OrderItemModifier::create([
                        'order_item_id' => $orderItem->id,
                        'modifier_id' => $mod['type'] === 'extra' || $mod['type'] === 'nasi' ? $mod['id'] : null,
                        'sambal_id' => $mod['type'] === 'sambal' ? $mod['id'] : null,
                        'spice_level_id' => $mod['type'] === 'spice_level' ? $mod['id'] : null,
                        'name_snapshot' => $mod['name'],
                        'type' => $mod['type'],
                        'price_snapshot' => $mod['price'],
                        'quantity' => $mod['quantity'],
                    ]);
                }
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $grandTotal,
                'status' => 'PENDING',
            ]);

            if ($table && $table->status !== 'OCCUPIED') {
                $table->update(['status' => 'OCCUPIED']);
            }

            return $order;
        });

        $order->load('items.modifiers', 'table', 'payment');

        return response()->json([
            'success' => true,
            'data' => $order,
            'message' => 'Order berhasil dibuat.',
        ], 201);
    }

    public function show(Request $request, string $id): JsonResponse
    {
        $order = Order::with(['items.modifiers', 'table', 'payment', 'diningSession'])
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'ORDER_NOT_FOUND', 'message' => 'Order tidak ditemukan.'],
            ], 404);
        }

        if ($request->user()->isCustomer() && $order->customer_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'FORBIDDEN', 'message' => 'Tidak memiliki akses ke order ini.'],
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }

    public function status(Request $request, string $id): JsonResponse
    {
        $order = Order::with(['table', 'payment'])
            ->where('id', $id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'error' => ['code' => 'ORDER_NOT_FOUND', 'message' => 'Order tidak ditemukan.'],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'fulfillment_status' => $order->fulfillment_status,
                'payment_status' => $order->payment_status,
                'grand_total' => $order->grand_total,
                'table_number' => $order->table?->table_number,
                'updated_at' => $order->updated_at,
            ],
        ]);
    }
}
