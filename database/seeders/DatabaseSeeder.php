<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            BranchSeeder::class,
            RestaurantTableSeeder::class,
            CategorySeeder::class,
            SpiceLevelSeeder::class,
            SambalSeeder::class,
            ProductSeeder::class,
            PackageSeeder::class,
            PromoSeeder::class,
            UserSeeder::class,
        ]);
    }
}
