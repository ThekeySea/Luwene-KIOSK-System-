<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\RestaurantTable;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();

        for ($i = 1; $i <= 10; $i++) {
            RestaurantTable::create([
                'branch_id' => $branch->id,
                'table_number' => $i,
                'capacity' => $i <= 4 ? 2 : ($i <= 8 ? 4 : 6),
                'status' => 'AVAILABLE',
            ]);
        }
    }
}
