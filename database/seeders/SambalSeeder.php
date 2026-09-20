<?php

namespace Database\Seeders;

use App\Models\Sambal;
use App\Models\SpiceLevel;
use Illuminate\Database\Seeder;

class SambalSeeder extends Seeder
{
    public function run(): void
    {
        $sambals = [
            [
                'name' => 'Sambal Bawang',
                'price' => 0,
                'sort_order' => 1,
                'levels' => [
                    ['name' => 'Original', 'level' => 0, 'sort_order' => 0],
                    ['name' => 'Nyolek', 'level' => 1, 'sort_order' => 1],
                    ['name' => 'Nampol', 'level' => 2, 'sort_order' => 2],
                    ['name' => 'Mampus', 'level' => 3, 'sort_order' => 3],
                ],
            ],
            [
                'name' => 'Sambal Terasi',
                'price' => 0,
                'sort_order' => 2,
                'levels' => [
                    ['name' => 'Original', 'level' => 0, 'sort_order' => 0],
                    ['name' => 'Nyolek', 'level' => 1, 'sort_order' => 1],
                    ['name' => 'Nampol', 'level' => 2, 'sort_order' => 2],
                    ['name' => 'Mampus', 'level' => 3, 'sort_order' => 3],
                ],
            ],
            [
                'name' => 'Sambal Ijo',
                'price' => 0,
                'sort_order' => 3,
                'levels' => [
                    ['name' => 'Original', 'level' => 0, 'sort_order' => 0],
                    ['name' => 'Nyolek', 'level' => 1, 'sort_order' => 1],
                ],
            ],
            [
                'name' => 'Sambal Matah',
                'price' => 2000,
                'sort_order' => 4,
                'levels' => [
                    ['name' => 'Original', 'level' => 0, 'sort_order' => 0],
                ],
            ],
            [
                'name' => 'Sambal Dabu-Dabu',
                'price' => 2000,
                'sort_order' => 5,
                'levels' => [
                    ['name' => 'Original', 'level' => 0, 'sort_order' => 0],
                ],
            ],
        ];

        foreach ($sambals as $data) {
            $levels = $data['levels'];
            unset($data['levels']);

            $sambal = Sambal::create($data);

            foreach ($levels as $level) {
                $sambal->spiceLevels()->create($level);
            }
        }
    }
}
