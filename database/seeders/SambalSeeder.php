<?php

namespace Database\Seeders;

use App\Models\Sambal;
use Illuminate\Database\Seeder;

class SambalSeeder extends Seeder
{
    public function run(): void
    {
        $sambals = [
            ['name' => 'Sambal Bawang', 'price' => 0],
            ['name' => 'Sambal Terasi', 'price' => 0],
            ['name' => 'Sambal Ijo', 'price' => 0],
            ['name' => 'Sambal Matah', 'price' => 2000],
            ['name' => 'Sambal Dabu-Dabu', 'price' => 2000],
        ];

        foreach ($sambals as $sambal) {
            Sambal::create($sambal);
        }
    }
}
