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
            $table->string('modifier_name');
            $table->enum('modifier_type', ['NASI', 'SAMBAL', 'SPICE_LEVEL', 'EXTRA']);
            $table->decimal('price', 12, 2)->default(0);
            $table->timestamps();

            $table->index('order_item_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->cascadeOnDelete();
            $table->foreign('modifier_id')->references('id')->on('modifiers')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_item_modifiers');
    }
};
