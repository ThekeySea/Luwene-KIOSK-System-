<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\RestaurantTable;
use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::firstOrCreate(
            ['code' => 'MAIN'],
            [
                'name' => 'LUWENE Main',
                'address' => 'Jl. Utama No. 1, Jakarta',
                'timezone' => 'Asia/Jakarta',
                'status' => 'ACTIVE',
            ]
        );

        $tables = [
            ['table_number' => '1', 'capacity' => 2],
            ['table_number' => '2', 'capacity' => 2],
            ['table_number' => '3', 'capacity' => 4],
            ['table_number' => '4', 'capacity' => 4],
            ['table_number' => '5', 'capacity' => 4],
            ['table_number' => '6', 'capacity' => 6],
            ['table_number' => '7', 'capacity' => 6],
            ['table_number' => '8', 'capacity' => 8],
            ['table_number' => '9', 'capacity' => 8],
            ['table_number' => '10', 'capacity' => 10],
        ];

        foreach ($tables as $table) {
            RestaurantTable::firstOrCreate(
                ['branch_id' => $branch->id, 'table_number' => $table['table_number']],
                [
                    'qr_token_hash' => \Illuminate\Support\Str::random(32),
                    'capacity' => $table['capacity'],
                    'status' => 'AVAILABLE',
                ]
            );
        }
    }
}
