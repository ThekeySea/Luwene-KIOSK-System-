<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('delivery_address')->nullable()->after('notes');
            $table->decimal('delivery_fee', 10, 2)->nullable()->after('delivery_address');
            $table->text('delivery_notes')->nullable()->after('delivery_fee');
            $table->timestamp('delivery_estimated_at')->nullable()->after('delivery_notes');
            $table->string('driver_name')->nullable()->after('delivery_estimated_at');
            $table->string('driver_phone', 20)->nullable()->after('driver_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_address', 'delivery_fee', 'delivery_notes',
                'delivery_estimated_at', 'driver_name', 'driver_phone',
            ]);
        });
    }
};
