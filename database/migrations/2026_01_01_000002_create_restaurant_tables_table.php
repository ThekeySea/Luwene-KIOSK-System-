<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id');
            $table->string('table_number');
            $table->string('qr_token_hash');
            $table->integer('capacity')->default(4);
            $table->enum('status', ['AVAILABLE', 'OCCUPIED', 'RESERVED', 'INACTIVE'])->default('AVAILABLE');
            $table->timestamps();

            $table->unique(['branch_id', 'table_number']);
            $table->index('status');
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_tables');
    }
};
