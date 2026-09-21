<?php

namespace Database\Seeders;

use App\Models\DeliveryAddress;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@luwene.id',
            'password' => Hash::make('password'),
            'role' => 'ADMIN',
        ]);

        User::create([
            'name' => 'Kasir',
            'email' => 'kasir@luwene.id',
            'password' => Hash::make('password'),
            'role' => 'CASHIER',
        ]);

        $customer = User::create([
            'name' => 'Customer',
            'email' => 'customer@luwene.id',
            'password' => Hash::make('password'),
            'role' => 'CUSTOMER',
        ]);

        DeliveryAddress::create([
            'user_id' => $customer->id,
            'label' => 'Rumah',
            'address' => 'Jl. Pemuda No. 123, RT 03/RW 05, Keputih, Sukolilo, Surabaya',
            'latitude' => -7.2891,
            'longitude' => 112.7960,
            'is_default' => true,
        ]);

        DeliveryAddress::create([
            'user_id' => $customer->id,
            'label' => 'Kantor',
            'address' => 'Jl. Raya Darmo No. 88, Wonokromo, Surabaya',
            'latitude' => -7.2917,
            'longitude' => 112.7356,
            'is_default' => false,
        ]);
    }
}
