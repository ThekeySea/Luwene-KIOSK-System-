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
        $branch = Branch::firstOrCreate(
            ['code' => 'MAIN'],
            [
                'name' => 'LUWENE Main',
                'address' => 'Jl. Utama No. 1, Jakarta',
                'timezone' => 'Asia/Jakarta',
                'status' => 'ACTIVE',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@luwene.id'],
            [
                'name' => 'Admin LUWENE',
                'password' => Hash::make('password'),
                'role' => 'ADMIN',
                'status' => 'ACTIVE',
                'branch_id' => $branch->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'kasir@luwene.id'],
            [
                'name' => 'Kasir LUWENE',
                'password' => Hash::make('password'),
                'role' => 'CASHIER',
                'status' => 'ACTIVE',
                'branch_id' => $branch->id,
            ]
        );

        User::firstOrCreate(
            ['email' => 'customer@luwene.id'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password'),
                'role' => 'CUSTOMER',
                'status' => 'ACTIVE',
            ]
        );
    }
}
