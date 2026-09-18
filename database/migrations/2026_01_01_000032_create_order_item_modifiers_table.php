<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_item_modifiers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_item_id');
            $table->uuid('modifier_id')->nullable();
            $table->uuid('sambal_id')->nullable();
            $table->uuid('spice_level_id')->nullable();
            $table->string('name_snapshot');
            $table->string('type');
            $table->decimal('price_snapshot', 12, 2)->default(0);
            $table->integer('quantity')->default(1);
            $table->timestamps();

            $table->index('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->cascadeOnDelete();
            $table->foreign('modifier_id')->references('id')->on('modifiers')->nullOnDelete();
            $table->foreign('sambal_id')->references('id')->on('sambals')->nullOnDelete();
            $table->foreign('spice_level_id')->references('id')->on('spice_levels')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_modifiers');
    }
};
