<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class PopularProductsSeeder extends Seeder
{
    public function run(): void
    {
        $popularProducts = [
            'ayam-goreng-luwene' => 45,
            'ayam-geprek' => 38,
            'rendang-sapi' => 32,
        ];

        $customer = User::where('role', 'CUSTOMER')->first();
        if (! $customer) {
            return;
        }

        foreach ($popularProducts as $slug => $totalSold) {
            $product = Product::where('slug', $slug)->first();
            if (! $product) {
                continue;
            }

            $batches = (int) ceil($totalSold / 5);
            for ($i = 0; $i < $batches; $i++) {
                $qty = min(5, $totalSold - ($i * 5));

                $order = Order::create([
                    'user_id' => $customer->id,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'customer_phone' => '-',
                    'client_order_id' => \Illuminate\Support\Str::uuid()->toString(),
                    'order_number' => 'LW-' . str_pad(100 + $i, 5, '0', STR_PAD_LEFT),
                    'order_mode' => 'DINE_IN',
                    'status' => 'COMPLETED',
                    'payment_status' => 'PAID',
                    'subtotal' => $product->base_price * $qty,
                    'tax_amount' => 0,
                    'discount_amount' => 0,
                    'total_amount' => $product->base_price * $qty,
                    'completed_at' => now()->subDays(rand(1, 30)),
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $qty,
                    'unit_price' => $product->base_price,
                    'subtotal' => $product->base_price * $qty,
                ]);
            }
        }
    }
}
