<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ModifierGroup;
use App\Models\Modifier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $nasiGroup = ModifierGroup::create(['name' => 'Pilihan Nasi', 'type' => 'NASI', 'is_required' => true, 'min_selection' => 1, 'max_selection' => 1, 'sort_order' => 1]);
        $extraGroup = ModifierGroup::create(['name' => 'Extra', 'type' => 'EXTRA', 'is_required' => false, 'sort_order' => 2]);

        Modifier::create(['modifier_group_id' => $nasiGroup->id, 'name' => 'Nasi Putih', 'price' => 0, 'sort_order' => 0]);
        Modifier::create(['modifier_group_id' => $nasiGroup->id, 'name' => 'Nasi Uduk', 'price' => 2000, 'sort_order' => 1]);
        Modifier::create(['modifier_group_id' => $nasiGroup->id, 'name' => 'Nasi Goreng', 'price' => 3000, 'sort_order' => 2]);

        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Telur Ceplok', 'price' => 5000, 'sort_order' => 0]);
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Tempe Goreng', 'price' => 3000, 'sort_order' => 1]);
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Tahu Goreng', 'price' => 3000, 'sort_order' => 2]);
        Modifier::create(['modifier_group_id' => $extraGroup->id, 'name' => 'Lalapan', 'price' => 5000, 'sort_order' => 3]);

        // [category_slug, name, slug, description, base_price, is_featured, variants, is_food, image_url]
        $products = [
            ['ayam', 'Ayam Goreng Luwene', 'ayam-goreng-luwene', 'Ayam goreng bumbu khas, renyah di luar juicy di dalam', 15000, true, [
                ['code' => 'ALA_CARTE', 'name' => 'Ala Carte', 'price' => 15000],
                ['code' => 'PAKET_NASI', 'name' => 'Paket Nasi', 'price' => 17000],
            ], true, 'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=400&h=300&fit=crop'],
            ['ayam', 'Ayam Bakar Madu', 'ayam-bakar-madu', 'Ayam bakar olesan madu, manis gurih', 18000, false, [
                ['code' => 'ALA_CARTE', 'name' => 'Ala Carte', 'price' => 18000],
                ['code' => 'PAKET_NASI', 'name' => 'Paket Nasi', 'price' => 20000],
            ], true, 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=400&h=300&fit=crop'],
            ['ayam', 'Ayam Geprek', 'ayam-geprek', 'Ayam crispy digeprek dengan sambal bawang', 16000, false, [
                ['code' => 'ALA_CARTE', 'name' => 'Ala Carte', 'price' => 16000],
                ['code' => 'PAKET_NASI', 'name' => 'Paket Nasi', 'price' => 18000],
            ], true, 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=400&h=300&fit=crop'],
            ['ayam', 'Sate Ayam', 'sate-ayam', '5 tusuk sate ayam bumbu kacang', 12000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 12000],
            ], true, 'https://images.unsplash.com/photo-1529563021893-cc83c992d75d?w=400&h=300&fit=crop'],
            ['daging', 'Rendang Sapi', 'rendang-sapi', 'Rendang sapi empuk dimasak perlahan', 25000, true, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 25000],
            ], true, 'https://images.unsplash.com/photo-1545247181-516773cae754?w=400&h=300&fit=crop'],
            ['daging', 'Empal Goreng', 'empal-goreng', 'Empal sapi manis gurih', 22000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 22000],
            ], true, 'https://images.unsplash.com/photo-1607167986504-6e1d0f7e1a2b?w=400&h=300&fit=crop'],
            ['daging', 'Sate Sapi', 'sate-sapi', '5 tusuk sate sapi bumbu kecap', 20000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 20000],
            ], true, 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=300&fit=crop'],
            ['seafood', 'Lele Goreng', 'lele-goreng', 'Lele goreng garing dengan lalapan', 12000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 12000],
            ], true, 'https://images.unsplash.com/photo-1580476262798-bddd9f4b7369?w=400&h=300&fit=crop'],
            ['seafood', 'Nila Bakar', 'nila-bakar', 'Ikan nila bakar bumbu kecap', 22000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 22000],
            ], true, 'https://images.unsplash.com/photo-1534766555764-ce878a857731?w=400&h=300&fit=crop'],
            ['seafood', 'Udang Crispy', 'udang-crispy', 'Udang goreng tepung renyah', 24000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 24000],
            ], true, 'https://images.unsplash.com/photo-1565680018434-b513d5e5fd47?w=400&h=300&fit=crop'],
            ['seafood', 'Cumi Goreng Tepung', 'cumi-goreng-tepung', 'Cumi goreng tepung gurih', 24000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 24000],
            ], true, 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=300&fit=crop'],
            ['sambal', 'Sambal Bawang', 'sambal-bawang', 'Sambal bawang pedas segar', 0, false, [], false, 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=400&h=300&fit=crop'],
            ['sambal', 'Sambal Terasi', 'sambal-terasi', 'Sambal terasi matang', 0, false, [], false, 'https://images.unsplash.com/photo-1574484284002-952d92456975?w=400&h=300&fit=crop'],
            ['sambal', 'Sambal Ijo', 'sambal-ijo', 'Sambal cabai hijau', 0, false, [], false, 'https://images.unsplash.com/photo-1472476443507-c7a5948772fc?w=400&h=300&fit=crop'],
            ['sambal', 'Sambal Matah', 'sambal-matah', 'Sambal matah Bali yang segar', 2000, false, [], false, 'https://images.unsplash.com/photo-1596591868231-05e787b82b4c?w=400&h=300&fit=crop'],
            ['cemal-cemil', 'Kentang Goreng', 'kentang-goreng', 'Kentang goreng renyah', 10000, false, [], false, 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=400&h=300&fit=crop'],
            ['cemal-cemil', 'Tahu Isi', 'tahu-isi', 'Tahu goreng isi sayur', 8000, false, [], false, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=300&fit=crop'],
            ['cemal-cemil', 'Tempe Mendoan', 'tempe-mendoan', 'Tempe mendoan setengah matang', 8000, false, [], false, 'https://images.unsplash.com/photo-1585032226651-759b368d7246?w=400&h=300&fit=crop'],
            ['cemal-cemil', 'Pisang Goreng Coklat Keju', 'pisang-goreng-coklat-keju', 'Pisang goreng topping coklat keju', 12000, false, [], false, 'https://images.unsplash.com/photo-1528207776546-365bb710ee93?w=400&h=300&fit=crop'],
            ['minuman', 'Es Teh Manis', 'es-teh-manis', 'Es teh manis segar', 5000, true, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 5000],
                ['code' => 'JUMBO', 'name' => 'Jumbo', 'price' => 7000],
            ], false, 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=300&fit=crop'],
            ['minuman', 'Es Jeruk Segar', 'es-jeruk-segar', 'Jeruk peras asli', 8000, false, [
                ['code' => 'REGULER', 'name' => 'Reguler', 'price' => 8000],
            ], false, 'https://images.unsplash.com/photo-1621263764928-df1444c5e859?w=400&h=300&fit=crop'],
            ['minuman', 'Teh Hangat', 'teh-hangat', 'Teh manis hangat', 4000, false, [], false, 'https://images.unsplash.com/photo-1571934811356-5cc061b6201f?w=400&h=300&fit=crop'],
            ['minuman', 'Kopi Tubruk', 'kopi-tubruk', 'Kopi tubruk robusta', 8000, false, [], false, 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefda?w=400&h=300&fit=crop'],
        ];

        $sortOrder = 1;
        foreach ($products as [$catSlug, $name, $slug, $description, $price, $featured, $variants, $isFood, $imageUrl]) {
            $category = Category::where('slug', $catSlug)->firstOrFail();

            $product = Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'name' => $name,
                    'description' => $description,
                    'base_price' => $price,
                    'is_featured' => $featured,
                    'is_active' => true,
                    'is_published' => true,
                    'is_published_delivery' => true,
                    'is_available' => true,
                    'image' => $imageUrl,
                    'sort_order' => $sortOrder++,
                ]
            );

            foreach ($variants as $index => $variant) {
                ProductVariant::create(array_merge($variant, [
                    'product_id' => $product->id,
                    'sort_order' => $index,
                ]));
            }
        }
    }
}
