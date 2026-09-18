<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::firstOrCreate(
            ['code' => 'MAIN'],
            [
                'name' => 'LUWENE Main',
                'address' => 'Jl. Utama No. 1, Jakarta',
                'timezone' => 'Asia/Jakarta',
                'status' => 'ACTIVE',
            ]
        );
    }
}
