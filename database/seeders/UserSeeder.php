<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@luwene.id',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
            'branch_id' => $branch->id,
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@luwene.id',
            'password' => Hash::make('password'),
            'role' => 'CASHIER',
            'branch_id' => $branch->id,
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'customer@luwene.id',
            'password' => Hash::make('password'),
            'role' => 'CUSTOMER',
        ]);
    }
}
