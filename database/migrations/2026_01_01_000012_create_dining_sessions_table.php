<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dining_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id');
            $table->uuid('table_id')->nullable();
            $table->enum('order_mode', ['DINE_IN', 'TAKE_AWAY']);
            $table->string('session_token')->unique();
            $table->enum('status', ['ACTIVE', 'CLOSED'])->default('ACTIVE');
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->index('branch_id');
            $table->index('table_id');
            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->foreign('table_id')->references('id')->on('restaurant_tables')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dining_sessions');
    }
};
