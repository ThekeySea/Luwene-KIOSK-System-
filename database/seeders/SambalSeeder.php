<?php

namespace Database\Seeders;

use App\Models\Sambal;
use Illuminate\Database\Seeder;

class SambalSeeder extends Seeder
{
    public function run(): void
    {
        $sambals = [
            ['name' => 'Sambal Bawang', 'description' => 'Sambal klasik berbahan bawang merah dan cabai', 'price' => 0, 'sort_order' => 1],
            ['name' => 'Sambal Korek', 'description' => 'Sambal mentah cabai rawit dengan minyak panas', 'price' => 0, 'sort_order' => 2],
            ['name' => 'Sambal Ijo', 'description' => 'Sambal dari cabai hijau yang ditumbuk kasar', 'price' => 0, 'sort_order' => 3],
            ['name' => 'Sambal Terasi', 'description' => 'Sambal dengan terasi udang bakar', 'price' => 0, 'sort_order' => 4],
            ['name' => 'Sambal Tomat', 'description' => 'Sambal segar dengan dasar tomat matang', 'price' => 0, 'sort_order' => 5],
            ['name' => 'Sambal Matah', 'description' => 'Sambal mentah khas Bali dengan serai dan bawang', 'price' => 0, 'sort_order' => 6],
            ['name' => 'Sambal Kemangi', 'description' => 'Sambal dengan daun kemangi segar', 'price' => 0, 'sort_order' => 7],
            ['name' => 'Sambal Bajak', 'description' => 'Sambal matang yang ditumis dengan bumbu kaya', 'price' => 0, 'sort_order' => 8],
            ['name' => 'Sambal Pete', 'description' => 'Sambal dengan pete (stink bean) goreng', 'price' => 2000, 'sort_order' => 9],
            ['name' => 'Sambal Cumi', 'description' => 'Sambal dengan cumi-cumi asin', 'price' => 3000, 'sort_order' => 10],
            ['name' => 'Sambal Udang', 'description' => 'Sambal dengan udang goreng renyah', 'price' => 3000, 'sort_order' => 11],
        ];

        foreach ($sambals as $sambal) {
            Sambal::firstOrCreate(
                ['name' => $sambal['name']],
                $sambal
            );
        }
    }
}
