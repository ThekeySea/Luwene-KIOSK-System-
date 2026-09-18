<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            SpiceLevelSeeder::class,
            SambalSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            PackageSeeder::class,
            RestaurantTableSeeder::class,
            UserSeeder::class,
        ]);
    }
}
