<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Ayam', 'slug' => 'ayam', 'sort_order' => 1],
            ['name' => 'Daging', 'slug' => 'daging', 'sort_order' => 2],
            ['name' => 'Seafood', 'slug' => 'seafood', 'sort_order' => 3],
            ['name' => 'Sambal', 'slug' => 'sambal', 'sort_order' => 4],
            ['name' => 'Cemal Cemil', 'slug' => 'cemal-cemil', 'sort_order' => 5],
            ['name' => 'Minuman', 'slug' => 'minuman', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
