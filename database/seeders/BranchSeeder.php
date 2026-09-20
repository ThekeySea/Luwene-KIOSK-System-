<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'LUWENE Kenjeran',
            'address' => 'Jl. Kenjeran No. 123, Surabaya',
            'latitude' => -7.2368,
            'longitude' => 112.7525,
            'delivery_fee' => 5000,
            'estimated_delivery_minutes' => 25,
            'status' => 'ACTIVE',
        ]);

        Branch::create([
            'name' => 'LUWENE Darmo',
            'address' => 'Jl. Darmo No. 45, Surabaya',
            'latitude' => -7.2917,
            'longitude' => 112.7356,
            'delivery_fee' => 7000,
            'estimated_delivery_minutes' => 20,
            'status' => 'ACTIVE',
        ]);

        Branch::create([
            'name' => 'LUWENE Rungkut',
            'address' => 'Jl. Rungkut No. 67, Surabaya',
            'latitude' => -7.3400,
            'longitude' => 112.7766,
            'delivery_fee' => 8000,
            'estimated_delivery_minutes' => 30,
            'status' => 'ACTIVE',
        ]);

        Branch::create([
            'name' => 'LUWENE Citraland',
            'address' => 'Jl. Citraland No. 89, Surabaya',
            'latitude' => -7.3183,
            'longitude' => 112.6583,
            'delivery_fee' => 10000,
            'estimated_delivery_minutes' => 35,
            'status' => 'ACTIVE',
        ]);

        Branch::create([
            'name' => 'LUWENE Gubeng',
            'address' => 'Jl. Gubeng No. 10, Surabaya',
            'latitude' => -7.2575,
            'longitude' => 112.7522,
            'delivery_fee' => 6000,
            'estimated_delivery_minutes' => 20,
            'status' => 'ACTIVE',
        ]);
    }
}
