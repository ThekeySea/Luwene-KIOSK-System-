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
            $table->enum('method', ['CASH', 'QRIS', 'CARD', 'OTHER']);
            $table->decimal('amount', 14, 2);
            $table->enum('status', ['UNPAID', 'PAID', 'FAILED', 'REFUNDED'])->default('UNPAID');
            $table->decimal('amount_received', 14, 2)->nullable();
            $table->decimal('change_amount', 14, 2)->nullable();
            $table->string('reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
