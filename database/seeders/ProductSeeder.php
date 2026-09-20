<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ModifierGroup;
use App\Models\Modifier;
use App\Models\ProductModifierGroup;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Modifier Groups
        $nasiGroup = ModifierGroup::create(['name' => 'Pilihan Nasi', 'type' => 'NASI', 'is_required' => true, 'min_selection' => 1, 'max_selection' => 1, 'sort_order' => 1]);
        $extraGroup = ModifierGroup::create(['name' => 'Extra', 'type' => 'EXTRA', 'is_required' => false, 'sort_order' => 2]);

        // Nasi modifiers
        Modifier::create(['modifier_group_id' => $nasiGroup->id, 'name' => 'Nasi Putih', 'price' => 0, 'sort_order' => 0]);
        Modifier::create(['modifier_group_id' => $nasiGroup->id, 'name' => 'Nasi Uduk', 'price' => 2000, 'sort_order' => 1]);
        Modifier::create(['modifier_group_id' => $nasiGroup->id, 'name' => 'Nasi Goreng', 'price' => 3000, 'sort_order' => 2]);

        // Extra modifiers
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Telur Ceplok', 'price' => 5000, 'sort_order' => 0]);
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Tempe Goreng', 'price' => 3000, 'sort_order' => 1]);
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Tahu Goreng', 'price' => 3000, 'sort_order' => 2]);
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Lalapan', 'price' => 5000, 'sort_order' => 3]);

        // [category_slug, name, slug, description, base_price, is_featured, variants, is_food]
        $products = [
            // Ayam
            ['ayam', 'Ayam Goreng Luwene', 'ayam-goreng-luwene', 'Ayam goreng bumbu khas, renyah di luar juicy di dalam', 15000, true, [
                ['code' => 'ALA_CARTE', 'name' => 'Ala Carte', 'price' => 15000],
                ['code' => 'PAKET_NASI', 'name' => 'Paket Nasi', 'price' => 17000],
            ], true],
            ['ayam', 'Ayam Bakar Madu', 'ayam-bakar-madu', 'Ayam bakar olesan madu, manis gurih', 18000, false, [
                ['code' => 'ALA_CARTE', 'name' => 'Ala Carte', 'price' => 18000],
                ['code' => 'PAKET_NASI', 'name' => 'Paket Nasi', 'price' => 20000],
            ], true],
            ['ayam', 'Ayam Geprek', 'ayam-geprek', 'Ayam crispy digeprek dengan sambal bawang', 16000, false, [
                ['code' => 'ALA_CARTE', 'name' => 'Ala Carte', 'price' => 16000],
                ['code' => 'PAKET_NASI', 'name' => 'Paket Nasi', 'price' => 18000],
            ], true],
            ['ayam', 'Sate Ayam', 'sate-ayam', '5 tusuk sate ayam bumbu kacang', 12000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 12000],
            ], true],
            // Daging
            ['daging', 'Rendang Sapi', 'rendang-sapi', 'Rendang sapi empuk dimasak perlahan', 25000, true, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 25000],
            ], true],
            ['daging', 'Empal Goreng', 'empal-goreng', 'Empal sapi manis gurih', 22000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 22000],
            ], true],
            ['daging', 'Sate Sapi', 'sate-sapi', '5 tusuk sate sapi bumbu kecap', 20000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 20000],
            ], true],
            // Seafood
            ['seafood', 'Lele Goreng', 'lele-goreng', 'Lele goreng garing dengan lalapan', 12000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 12000],
            ], true],
            ['seafood', 'Nila Bakar', 'nila-bakar', 'Ikan nila bakar bumbu kecap', 22000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 22000],
            ], true],
            ['seafood', 'Udang Crispy', 'udang-crispy', 'Udang goreng tepung renyah', 24000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 24000],
            ], true],
            ['seafood', 'Cumi Goreng Tepung', 'cumi-goreng-tepung', 'Cumi goreng tepung gurih', 24000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 24000],
            ], true],
            // Sambal (standalone products)
            ['sambal', 'Sambal Bawang', 'sambal-bawang', 'Sambal bawang pedas segar', 0, false, [], false],
            ['sambal', 'Sambal Terasi', 'sambal-terasi', 'Sambal terasi matang', 0, false, [], false],
            ['sambal', 'Sambal Ijo', 'sambal-ijo', 'Sambal cabai hijau', 0, false, [], false],
            ['sambal', 'Sambal Matah', 'sambal-matah', 'Sambal matah Bali yang segar', 2000, false, [], false],
            // Cemal Cemil
            ['cemal-cemil', 'Kentang Goreng', 'kentang-goreng', 'Kentang goreng renyah', 10000, false, [], false],
            ['cemal-cemil', 'Tahu Isi', 'tahu-isi', 'Tahu goreng isi sayur', 8000, false, [], false],
            ['cemal-cemil', 'Tempe Mendoan', 'tempe-mendoan', 'Tempe mendoan setengah matang', 8000, false, [], false],
            ['cemal-cemil', 'Pisang Goreng Coklat Keju', 'pisang-goreng-coklat-keju', 'Pisang goreng topping coklat keju', 12000, false, [], false],
            // Minuman
            ['minuman', 'Es Teh Manis', 'es-teh-manis', 'Es teh manis segar', 5000, true, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 5000],
                ['code' => 'JUMBO', 'name' => 'Jumbo', 'price' => 7000],
            ], false],
            ['minuman', 'Es Jeruk Segar', 'es-jeruk-segar', 'Jeruk peras asli', 8000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 8000],
            ], false],
            ['minuman', 'Teh Hangat', 'teh-hangat', 'Teh manis hangat', 4000, false, [], false],
            ['minuman', 'Kopi Tubruk', 'kopi-tubruk', 'Kopi tubruk robusta', 8000, false, [], false],
        ];

        $sortOrder = 1;
        foreach ($products as [$catSlug, $name, $slug, $description, $price, $featured, $variants, $isFood]) {
            $category = Category::where('slug', $catSlug)->firstOrFail();

            $product = Product::create([
                'category_id' => $category->id,
                'name' => $name,
                'slug' => $slug,
                'description' => $description,
                'base_price' => $price,
                'is_featured' => $featured,
                'is_active' => true,
                'is_published' => true,
                'sort_order' => $sortOrder++,
            ]);

            foreach ($variants as $index => $variant) {
                ProductVariant::create(array_merge($variant, [
                    'product_id' => $product->id,
                    'sort_order' => $index,
                ]));
            }

            if ($isFood) {
                // Modifier groups and sambals are assigned manually per product via admin panel
            }
        }
    }
}
