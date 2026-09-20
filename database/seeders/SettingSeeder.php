<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'tax_rate' => '11',
            'order_prefix' => 'LW',
            'receipt_footer' => 'Terima kasih telah memesan di LUWENE!',
            'opening_hours' => '08:00',
            'closing_hours' => '22:00',
        ];

        foreach ($defaults as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
