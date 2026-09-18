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
            $table->uuid('customer_id')->nullable();
            $table->uuid('table_id')->nullable();
            $table->uuid('dining_session_id')->nullable();
            $table->string('client_order_id');
            $table->string('order_number', 50);
            $table->enum('order_mode', ['DINE_IN', 'TAKE_AWAY']);
            $table->enum('status', ['DRAFT', 'PENDING_PAYMENT', 'PAID', 'CONFIRMED', 'PREPARING', 'READY', 'COMPLETED', 'CANCELLED'])->default('DRAFT');
            $table->enum('fulfillment_status', ['WAITING', 'PREPARING', 'READY', 'PICKED_UP', 'COMPLETED'])->default('WAITING');
            $table->enum('payment_status', ['PENDING', 'PAID', 'FAILED', 'CANCELLED', 'REFUNDED'])->default('PENDING');
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('service_charge', 12, 2)->default(0);
            $table->decimal('grand_total', 14, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['branch_id', 'order_number']);
            $table->unique(['branch_id', 'client_order_id']);
            $table->index('status');
            $table->index('payment_status');
            $table->index('fulfillment_status');
            $table->index('order_mode');
            $table->index('customer_id');
            $table->index('dining_session_id');
            $table->index('created_at');

            $table->foreign('branch_id')->references('id')->on('branches')->cascadeOnDelete();
            $table->foreign('customer_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('table_id')->references('id')->on('restaurant_tables')->nullOnDelete();
            $table->foreign('dining_session_id')->references('id')->on('dining_sessions')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
