<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        Branch::create([
            'name' => 'LUWENE Main',
            'address' => 'Jl. Contoh No. 123, Jakarta Selatan',
            'status' => 'ACTIVE',
        ]);
    }
}
