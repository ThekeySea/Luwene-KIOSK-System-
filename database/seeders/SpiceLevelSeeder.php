<?php

namespace Database\Seeders;

use App\Models\SpiceLevel;
use Illuminate\Database\Seeder;

class SpiceLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['name' => 'Original', 'level' => 0, 'sort_order' => 0],
            ['name' => 'Nyolek', 'level' => 1, 'sort_order' => 1],
            ['name' => 'Nampol', 'level' => 2, 'sort_order' => 2],
            ['name' => 'Mampus', 'level' => 3, 'sort_order' => 3],
        ];

        foreach ($levels as $level) {
            SpiceLevel::create($level);
        }
    }
}
