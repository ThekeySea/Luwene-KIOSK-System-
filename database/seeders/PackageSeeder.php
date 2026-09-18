<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $ayam = Product::where('slug', 'ayam-goreng-luwene')->first();
        $esTeh = Product::where('slug', 'es-teh-manis')->first();

        if ($ayam && $esTeh) {
            $pkg = Package::create([
                'name' => 'Paket Hemat Ayam',
                'code' => 'PAKET_HEMAT',
                'description' => 'Ayam Goreng Luwene + Es Teh Manis',
                'price' => 18000,
            ]);

            PackageItem::create(['package_id' => $pkg->id, 'product_id' => $ayam->id, 'quantity' => 1, 'role' => 'FIXED']);
            PackageItem::create(['package_id' => $pkg->id, 'product_id' => $esTeh->id, 'quantity' => 1, 'role' => 'FIXED']);
        }
    }
}
