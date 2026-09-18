<?php

namespace Database\Seeders;

use App\Models\SpiceLevel;
use Illuminate\Database\Seeder;

class SpiceLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['level_number' => 0, 'name' => 'Aman', 'description' => 'Tidak pedas, cocok untuk semua kalangan'],
            ['level_number' => 1, 'name' => 'Nyolek', 'description' => 'Sedikit pedas, mulai terasa di ujung lidah'],
            ['level_number' => 2, 'name' => 'Nampol', 'description' => 'Pedas yang terasa di mulut dan bibir'],
            ['level_number' => 3, 'name' => 'Dahsyat', 'description' => 'Pedas ekstrem, untuk pecinta tantangan'],
        ];

        foreach ($levels as $level) {
            SpiceLevel::firstOrCreate(
                ['level_number' => $level['level_number']],
                $level
            );
        }
    }
}
