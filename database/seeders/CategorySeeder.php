<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Paket LUWENE', 'slug' => 'paket-luwene', 'sort_order' => 1],
            ['name' => 'Ayam', 'slug' => 'ayam', 'sort_order' => 2],
            ['name' => 'Kambing', 'slug' => 'kambing', 'sort_order' => 3],
            ['name' => 'Sapi', 'slug' => 'sapi', 'sort_order' => 4],
            ['name' => 'Ikan', 'slug' => 'ikan', 'sort_order' => 5],
            ['name' => 'Seafood', 'slug' => 'seafood', 'sort_order' => 6],
            ['name' => 'Sambal', 'slug' => 'sambal', 'sort_order' => 7],
            ['name' => 'Nasi & Tambahan', 'slug' => 'nasi-tambahan', 'sort_order' => 8],
            ['name' => 'Snack', 'slug' => 'snack', 'sort_order' => 9],
            ['name' => 'Minuman', 'slug' => 'minuman', 'sort_order' => 10],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}
