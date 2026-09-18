<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id');
            $table->uuid('user_id')->nullable();
            $table->uuid('table_id')->nullable();
            $table->uuid('dining_session_id')->nullable();
            $table->string('client_order_id');
            $table->string('order_number', 50);
            $table->enum('order_mode', ['DINE_IN', 'TAKE_AWAY']);
            $table->enum('status', ['PENDING', 'CONFIRMED', 'PREPARING', 'READY', 'COMPLETED', 'CANCELLED'])->default('PENDING');
            $table->enum('payment_status', ['UNPAID', 'PAID', 'FAILED', 'REFUNDED'])->default('UNPAID');
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['branch_id', 'order_number']);
            $table->unique(['branch_id', 'client_order_id']);
            $table->index('status');
            $table->index('payment_status');
            $table->index('order_mode');
            $table->index('user_id');
            $table->index('created_at');

            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('table_id')->references('id')->on('restaurant_tables')->nullOnDelete();
            $table->foreign('dining_session_id')->references('id')->on('dining_sessions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
