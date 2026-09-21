<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'LUWENE Benowo',
            'address' => 'Jl. Benowo No. 1, Surabaya',
            'latitude' => -7.2456,
            'longitude' => 112.6401,
            'delivery_fee' => 5000,
            'estimated_delivery_minutes' => 30,
            'status' => 'ACTIVE',
        ]);
    }
}
