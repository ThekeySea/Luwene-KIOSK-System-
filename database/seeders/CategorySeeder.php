<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ayam', 'slug' => 'ayam', 'sort_order' => 1, 'is_active' => true, 'is_published' => true],
            ['name' => 'Daging', 'slug' => 'daging', 'sort_order' => 2, 'is_active' => true, 'is_published' => true],
            ['name' => 'Seafood', 'slug' => 'seafood', 'sort_order' => 3, 'is_active' => true, 'is_published' => true],
            ['name' => 'Sambal', 'slug' => 'sambal', 'sort_order' => 4, 'is_active' => true, 'is_published' => true],
            ['name' => 'Cemal Cemil', 'slug' => 'cemal-cemil', 'sort_order' => 5, 'is_active' => true, 'is_published' => true],
            ['name' => 'Minuman', 'slug' => 'minuman', 'sort_order' => 6, 'is_active' => true, 'is_published' => true],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
