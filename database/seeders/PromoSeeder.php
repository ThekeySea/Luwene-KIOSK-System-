<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $promos = [
            [
                'code' => 'HEMAT10',
                'name' => 'Diskon 10% untuk Nampan',
                'type' => 'PERCENT',
                'value' => 10,
                'min_order_amount' => 20000,
                'max_discount_amount' => 15000,
            ],
            [
                'code' => 'LUWENE5K',
                'name' => 'Potongan Rp5.000',
                'type' => 'FIXED',
                'value' => 5000,
                'min_order_amount' => 30000,
                'max_discount_amount' => null,
            ],
            [
                'code' => 'WELCOME15',
                'name' => 'Diskon 15% pengguna baru',
                'type' => 'PERCENT',
                'value' => 15,
                'min_order_amount' => 15000,
                'max_discount_amount' => 20000,
            ],
        ];

        foreach ($promos as $promo) {
            Promo::create($promo);
        }
    }
}
