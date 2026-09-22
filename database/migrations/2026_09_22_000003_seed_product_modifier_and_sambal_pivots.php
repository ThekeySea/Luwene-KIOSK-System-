<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $nasiGroupId = DB::table('modifier_groups')->where('type', 'NASI')->value('id');
        $extraGroupId = DB::table('modifier_groups')->where('type', 'EXTRA')->value('id');

        $foodCategories = DB::table('categories')
            ->whereIn('slug', ['ayam', 'daging', 'seafood'])
            ->pluck('id')
            ->toArray();

        $foodProducts = DB::table('products')
            ->where('is_active', true)
            ->where('is_published', true)
            ->whereIn('category_id', $foodCategories)
            ->whereNull('deleted_at')
            ->get();

        $sambalIds = DB::table('sambals')->pluck('id')->toArray();
        $now = now();

        foreach ($foodProducts as $product) {
            if ($nasiGroupId) {
                $exists = DB::table('product_modifier_groups')
                    ->where('product_id', $product->id)
                    ->where('modifier_group_id', $nasiGroupId)
                    ->exists();
                if (!$exists) {
                    DB::table('product_modifier_groups')->insert([
                        'product_id' => $product->id,
                        'modifier_group_id' => $nasiGroupId,
                        'is_required' => true,
                        'min_selection' => 1,
                        'max_selection' => 1,
                        'sort_order' => 1,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            if ($extraGroupId) {
                $exists = DB::table('product_modifier_groups')
                    ->where('product_id', $product->id)
                    ->where('modifier_group_id', $extraGroupId)
                    ->exists();
                if (!$exists) {
                    DB::table('product_modifier_groups')->insert([
                        'product_id' => $product->id,
                        'modifier_group_id' => $extraGroupId,
                        'is_required' => false,
                        'min_selection' => 0,
                        'max_selection' => null,
                        'sort_order' => 2,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            foreach ($sambalIds as $index => $sambalId) {
                $sambalName = DB::table('sambals')->where('id', $sambalId)->value('name');

                $sambalPrice = match(true) {
                    str_contains($sambalName, 'Matah') => 2000,
                    str_contains($sambalName, 'Dabu') => 2000,
                    default => 0,
                };

                $isRequired = $sambalPrice === 0;

                $exists = DB::table('product_sambals')
                    ->where('product_id', $product->id)
                    ->where('sambal_id', $sambalId)
                    ->exists();
                if (!$exists) {
                    DB::table('product_sambals')->insert([
                        'product_id' => $product->id,
                        'sambal_id' => $sambalId,
                        'price' => $sambalPrice,
                        'is_required' => $isRequired,
                        'sort_order' => $index,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }
        }
    }

    public function down(): void
    {
        DB::table('product_modifier_groups')->delete();
        DB::table('product_sambals')->delete();
    }
};
