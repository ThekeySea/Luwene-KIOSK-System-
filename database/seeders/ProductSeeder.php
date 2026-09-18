<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ModifierGroup;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $ayamCategory = Category::where('slug', 'ayam')->first();
        $kambingCategory = Category::where('slug', 'kambing')->first();
        $sapiCategory = Category::where('slug', 'sapi')->first();
        $ikanCategory = Category::where('slug', 'ikan')->first();
        $seafoodCategory = Category::where('slug', 'seafood')->first();
        $nasiCategory = Category::where('slug', 'nasi-tambahan')->first();
        $snackCategory = Category::where('slug', 'snack')->first();
        $minumanCategory = Category::where('slug', 'minuman')->first();

        // Ayam
        $ayamProducts = [
            ['name' => 'Ayam Goreng Luwene', 'slug' => 'ayam-goreng-luwene', 'base_price' => 12000, 'is_featured' => true],
            ['name' => 'Ayam Bakar Luwene', 'slug' => 'ayam-bakar-luwene', 'base_price' => 14000, 'is_featured' => true],
            ['name' => 'Ayam Geprek', 'slug' => 'ayam-geprek', 'base_price' => 13000],
            ['name' => 'Ayam Penyet', 'slug' => 'ayam-penyet', 'base_price' => 13000],
            ['name' => 'Ayam Kremes', 'slug' => 'ayam-kremes', 'base_price' => 14000],
        ];

        foreach ($ayamProducts as $product) {
            $p = Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $ayamCategory->id])
            );

            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'ALA_CARTE'],
                ['name' => 'Ala Carte', 'price' => $product['base_price']]
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'PAKET_NASI'],
                ['name' => 'Paket Nasi', 'price' => $product['base_price'] + 5000]
            );
        }

        // Kambing
        $kambingProducts = [
            ['name' => 'Kambing Bakar', 'slug' => 'kambing-bakar', 'base_price' => 25000],
            ['name' => 'Kambing Goreng', 'slug' => 'kambing-goreng', 'base_price' => 25000],
            ['name' => 'Sate Kambing', 'slug' => 'sate-kambing', 'base_price' => 22000],
            ['name' => 'Tongseng Kambing', 'slug' => 'tongseng-kambing', 'base_price' => 28000],
        ];

        foreach ($kambingProducts as $product) {
            $p = Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $kambingCategory->id])
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'ALA_CARTE'],
                ['name' => 'Ala Carte', 'price' => $product['base_price']]
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'PAKET_NASI'],
                ['name' => 'Paket Nasi', 'price' => $product['base_price'] + 5000]
            );
        }

        // Sapi
        $sapiProducts = [
            ['name' => 'Sapi Bakar', 'slug' => 'sapi-bakar', 'base_price' => 22000],
            ['name' => 'Sapi Goreng', 'slug' => 'sapi-goreng', 'base_price' => 22000],
            ['name' => 'Sate Sapi', 'slug' => 'sate-sapi', 'base_price' => 20000],
            ['name' => 'Tongseng Sapi', 'slug' => 'tongseng-sapi', 'base_price' => 25000],
        ];

        foreach ($sapiProducts as $product) {
            $p = Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $sapiCategory->id])
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'ALA_CARTE'],
                ['name' => 'Ala Carte', 'price' => $product['base_price']]
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'PAKET_NASI'],
                ['name' => 'Paket Nasi', 'price' => $product['base_price'] + 5000]
            );
        }

        // Ikan
        $ikanProducts = [
            ['name' => 'Ikan Bakar', 'slug' => 'ikan-bakar', 'base_price' => 18000],
            ['name' => 'Ikan Goreng', 'slug' => 'ikan-goreng', 'base_price' => 18000],
            ['name' => 'Ikan Penyet', 'slug' => 'ikan-penyet', 'base_price' => 18000],
        ];

        foreach ($ikanProducts as $product) {
            $p = Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $ikanCategory->id])
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'ALA_CARTE'],
                ['name' => 'Ala Carte', 'price' => $product['base_price']]
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'PAKET_NASI'],
                ['name' => 'Paket Nasi', 'price' => $product['base_price'] + 5000]
            );
        }

        // Seafood
        $seafoodProducts = [
            ['name' => 'Udang Goreng', 'slug' => 'udang-goreng', 'base_price' => 20000],
            ['name' => 'Cumi Goreng', 'slug' => 'cumi-goreng', 'base_price' => 22000],
            ['name' => 'Kepiting Saus Tiram', 'slug' => 'kepiting-saus-tiram', 'base_price' => 35000],
        ];

        foreach ($seafoodProducts as $product) {
            $p = Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $seafoodCategory->id])
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'ALA_CARTE'],
                ['name' => 'Ala Carte', 'price' => $product['base_price']]
            );
            ProductVariant::firstOrCreate(
                ['product_id' => $p->id, 'code' => 'PAKET_NASI'],
                ['name' => 'Paket Nasi', 'price' => $product['base_price'] + 5000]
            );
        }

        // Nasi & Tambahan
        $nasiProducts = [
            ['name' => 'Nasi Putih', 'slug' => 'nasi-putih', 'base_price' => 5000],
            ['name' => 'Nasi Uduk', 'slug' => 'nasi-uduk', 'base_price' => 7000],
            ['name' => 'Nasi Daun Jeruk', 'slug' => 'nasi-daun-jeruk', 'base_price' => 7000],
            ['name' => 'Telur Ceplok', 'slug' => 'telur-ceplok', 'base_price' => 5000],
            ['name' => 'Telur Dadar', 'slug' => 'telur-dadar', 'base_price' => 5000],
            ['name' => 'Kerupuk', 'slug' => 'kerupuk', 'base_price' => 3000],
            ['name' => 'Lalapan', 'slug' => 'lalapan', 'base_price' => 3000],
        ];

        foreach ($nasiProducts as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $nasiCategory->id])
            );
        }

        // Snack
        $snackProducts = [
            ['name' => 'Tempe Goreng', 'slug' => 'tempe-goreng', 'base_price' => 5000],
            ['name' => 'Tahu Goreng', 'slug' => 'tahu-goreng', 'base_price' => 5000],
            ['name' => 'Kentang Goreng', 'slug' => 'kentang-goreng', 'base_price' => 8000],
            ['name' => 'Jamur Crispy', 'slug' => 'jamur-crispy', 'base_price' => 10000],
        ];

        foreach ($snackProducts as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $snackCategory->id])
            );
        }

        // Minuman
        $minumanProducts = [
            ['name' => 'Es Teh Manis', 'slug' => 'es-teh-manis', 'base_price' => 5000],
            ['name' => 'Es Teh Tawar', 'slug' => 'es-teh-tawar', 'base_price' => 4000],
            ['name' => 'Es Jeruk', 'slug' => 'es-jeruk', 'base_price' => 7000],
            ['name' => 'Es Jeruk Peras', 'slug' => 'es-jeruk-peras', 'base_price' => 10000],
            ['name' => 'Es Kelapa Muda', 'slug' => 'es-kelapa-muda', 'base_price' => 12000],
            ['name' => 'Air Mineral', 'slug' => 'air-mineral', 'base_price' => 4000],
        ];

        foreach ($minumanProducts as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                array_merge($product, ['category_id' => $minumanCategory->id])
            );
        }

        // Nasi Modifier Group
        $nasiGroup = ModifierGroup::firstOrCreate(
            ['name' => 'Pilihan Nasi'],
            [
                'selection_type' => 'SINGLE',
                'min_selection' => 1,
                'max_selection' => 1,
                'is_required' => true,
                'sort_order' => 1,
            ]
        );

        $nasiProducts = ['Nasi Putih', 'Nasi Uduk', 'Nasi Daun Jeruk'];
        foreach ($nasiProducts as $index => $nasiName) {
            $nasiProduct = Product::where('slug', \Illuminate\Support\Str::slug($nasiName))->first();
            if ($nasiProduct) {
                \App\Models\Modifier::firstOrCreate(
                    ['modifier_group_id' => $nasiGroup->id, 'name' => $nasiName],
                    ['price' => 0, 'sort_order' => $index + 1]
                );
            }
        }

        // Extra Modifier Group
        $extraGroup = ModifierGroup::firstOrCreate(
            ['name' => 'Extra'],
            [
                'selection_type' => 'MULTIPLE',
                'min_selection' => 0,
                'max_selection' => 10,
                'is_required' => false,
                'sort_order' => 2,
            ]
        );

        $extras = [
            ['name' => 'Telur Ceplok', 'price' => 5000],
            ['name' => 'Telur Dadar', 'price' => 5000],
            ['name' => 'Kerupuk', 'price' => 3000],
            ['name' => 'Lalapan', 'price' => 3000],
            ['name' => 'Nasi Tambahan', 'price' => 5000],
        ];

        foreach ($extras as $index => $extra) {
            \App\Models\Modifier::firstOrCreate(
                ['modifier_group_id' => $extraGroup->id, 'name' => $extra['name']],
                ['price' => $extra['price'], 'sort_order' => $index + 1]
            );
        }
    }
}
