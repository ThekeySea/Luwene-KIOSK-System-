<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->enum('payment_method', ['CASH', 'QRIS', 'OTHER'])->default('CASH');
            $table->string('provider')->nullable();
            $table->string('external_reference')->nullable();
            $table->decimal('amount', 14, 2);
            $table->decimal('amount_received', 14, 2)->nullable();
            $table->decimal('change_amount', 12, 2)->nullable();
            $table->enum('status', ['PENDING', 'PAID', 'FAILED', 'CANCELLED', 'REFUNDED'])->default('PENDING');
            $table->timestamp('paid_at')->nullable();
            $table->uuid('verified_by')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
