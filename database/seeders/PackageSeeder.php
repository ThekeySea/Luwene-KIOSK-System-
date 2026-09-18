<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'name' => 'LUWENE MAKNYUS',
                'code' => 'LW-MAKNYUS',
                'description' => 'Paket ayam goreng spesial dengan nasi uduk dan es teh',
                'price' => 22000,
                'items' => [
                    ['slug' => 'ayam-goreng-luwene', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-uduk', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-teh-manis', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
            [
                'name' => 'LUWENE MLEHOY',
                'code' => 'LW-MLEHOY',
                'description' => 'Paket ayam bakar dengan nasi daun jeruk dan sambal korek',
                'price' => 25000,
                'items' => [
                    ['slug' => 'ayam-bakar-luwene', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-daun-jeruk', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-jeruk', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
            [
                'name' => 'LUWENE MANTAP',
                'code' => 'LW-MANTAP',
                'description' => 'Paket kambing bakar dengan nasi putih dan minuman',
                'price' => 35000,
                'items' => [
                    ['slug' => 'kambing-bakar', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-putih', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-kelapa-muda', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
            [
                'name' => 'LUWENE MBOIS',
                'code' => 'LW-MBOIS',
                'description' => 'Paket sapi bakar dengan nasi uduk dan es jeruk peras',
                'price' => 32000,
                'items' => [
                    ['slug' => 'sapi-bakar', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-uduk', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-jeruk-peras', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
            [
                'name' => 'LUWENE KOMPLIT',
                'code' => 'LW-KOMPLIT',
                'description' => 'Paket ayam goreng komplit dengan nasi, telur, lalapan, dan minuman',
                'price' => 28000,
                'items' => [
                    ['slug' => 'ayam-goreng-luwene', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-putih', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'telur-ceplok', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'lalapan', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-teh-manis', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
            [
                'name' => 'LUWENE NAMPOL',
                'code' => 'LW-NAMPOL',
                'description' => 'Paket ayam geprek pedas dengan nasi dan es teh',
                'price' => 23000,
                'items' => [
                    ['slug' => 'ayam-geprek', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-putih', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-teh-manis', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
            [
                'name' => 'LUWENE DAHSYAT',
                'code' => 'LW-DAHSYAT',
                'description' => 'Paket premium seafood dengan nasi dan minuman',
                'price' => 40000,
                'items' => [
                    ['slug' => 'kepiting-saus-tiram', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'nasi-putih', 'quantity' => 2, 'role' => 'FIXED', 'is_required' => true],
                    ['slug' => 'es-kelapa-muda', 'quantity' => 1, 'role' => 'FIXED', 'is_required' => true],
                ],
            ],
        ];

        foreach ($packages as $packageData) {
            $items = $packageData['items'];
            unset($packageData['items']);

            $package = Package::firstOrCreate(
                ['code' => $packageData['code']],
                $packageData
            );

            foreach ($items as $item) {
                $product = Product::where('slug', $item['slug'])->first();
                if ($product) {
                    PackageItem::firstOrCreate(
                        ['package_id' => $package->id, 'product_id' => $product->id],
                        [
                            'quantity' => $item['quantity'],
                            'role' => $item['role'],
                            'is_required' => $item['is_required'],
                        ]
                    );
                }
            }
        }
    }
}
