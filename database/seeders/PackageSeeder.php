<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\PackageItem;
use App\Models\PackageSection;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $ayamGoreng = Product::where('slug', 'ayam-goreng-luwene')->first();
        $ayamBakar = Product::where('slug', 'ayam-bakar-madu')->first();
        $ayamGeprek = Product::where('slug', 'ayam-geprek')->first();
        $esTeh = Product::where('slug', 'es-teh-manis')->first();
        $esJeruk = Product::where('slug', 'es-jeruk-segar')->first();
        $tehHangat = Product::where('slug', 'teh-hangat')->first();
        $kentang = Product::where('slug', 'kentang-goreng')->first();
        $telur = Product::where('name', 'Telur Ceplok')->first();

        // === PAKET TETAP: Paket Hemat Ayam ===
        if ($ayamGoreng && $esTeh) {
            $pkg = Package::create([
                'name' => 'Paket Hemat Ayam',
                'code' => 'PAKET_HEMAT',
                'description' => 'Ayam Goreng Luwene + Es Teh Manis, hemat lebih murah!',
                'price' => 18000,
                'type' => 'FIXED',
                'is_active' => true,
                'is_published' => true,
                'is_published_delivery' => true,
            ]);

            PackageItem::create([
                'package_id' => $pkg->id,
                'product_id' => $ayamGoreng->id,
                'quantity' => 1,
                'role' => 'FIXED',
                'price_override' => null,
                'is_required' => true,
                'sort_order' => 0,
            ]);

            PackageItem::create([
                'package_id' => $pkg->id,
                'product_id' => $esTeh->id,
                'quantity' => 1,
                'role' => 'FIXED',
                'price_override' => null,
                'is_required' => true,
                'sort_order' => 1,
            ]);
        }

        // === PAKET MODULAR: Paket Pedas 1 ===
        if ($ayamGoreng && $ayamBakar && $ayamGeprek && $esTeh && $esJeruk && $tehHangat) {
            $pkg = Package::create([
                'name' => 'Paket Pedas 1',
                'code' => 'PAKET_PEDAS_1',
                'description' => 'Pilih ayam, sambal, dan minum sesuai selera kamu!',
                'price' => 0,
                'type' => 'MODULAR',
                'is_active' => true,
                'is_published' => true,
                'is_published_delivery' => true,
            ]);

            // Section: Pilih Ayam (single)
            $ayamSection = $pkg->sections()->create([
                'name' => 'Pilih Ayam',
                'choice_type' => 'SINGLE',
                'max_pick' => 1,
                'sort_order' => 0,
            ]);

            PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $ayamSection->id, 'product_id' => $ayamGoreng->id, 'quantity' => 1, 'role' => 'CHOICE', 'is_required' => false, 'sort_order' => 0]);
            PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $ayamSection->id, 'product_id' => $ayamBakar->id, 'quantity' => 1, 'role' => 'CHOICE', 'is_required' => false, 'sort_order' => 1]);
            PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $ayamSection->id, 'product_id' => $ayamGeprek->id, 'quantity' => 1, 'role' => 'CHOICE', 'is_required' => false, 'sort_order' => 2]);

            // Section: Pilih Minum (single)
            $minumSection = $pkg->sections()->create([
                'name' => 'Pilih Minum',
                'choice_type' => 'SINGLE',
                'max_pick' => 1,
                'sort_order' => 1,
            ]);

            PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $minumSection->id, 'product_id' => $esTeh->id, 'quantity' => 1, 'role' => 'CHOICE', 'is_required' => false, 'sort_order' => 0]);
            PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $minumSection->id, 'product_id' => $esJeruk->id, 'quantity' => 1, 'role' => 'CHOICE', 'is_required' => false, 'sort_order' => 1]);
            PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $minumSection->id, 'product_id' => $tehHangat->id, 'quantity' => 1, 'role' => 'CHOICE', 'is_required' => false, 'sort_order' => 2]);

            // Section: Tambahan (multiple, max 2)
            if ($kentang && $telur) {
                $tambahanSection = $pkg->sections()->create([
                    'name' => 'Tambahan',
                    'choice_type' => 'MULTIPLE',
                    'max_pick' => 2,
                    'sort_order' => 2,
                ]);

                PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $tambahanSection->id, 'product_id' => $kentang->id, 'quantity' => 1, 'role' => 'CHOICE', 'price_override' => 8000, 'is_required' => false, 'sort_order' => 0]);
                PackageItem::create(['package_id' => $pkg->id, 'package_section_id' => $tambahanSection->id, 'product_id' => $telur->id, 'quantity' => 1, 'role' => 'CHOICE', 'price_override' => 4000, 'is_required' => false, 'sort_order' => 1]);
            }
        }
    }
}
