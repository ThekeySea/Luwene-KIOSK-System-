<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_sambals', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id');
            $table->uuid('sambal_id');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'sambal_id']);
            $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
            $table->foreign('sambal_id')->references('id')->on('sambals')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sambals');
    }
};
