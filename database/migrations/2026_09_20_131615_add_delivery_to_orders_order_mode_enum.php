<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY COLUMN order_mode ENUM('DINE_IN', 'TAKE_AWAY', 'DELIVERY') NOT NULL");
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE orders MODIFY COLUMN order_mode ENUM('DINE_IN', 'TAKE_AWAY') NOT NULL");
    }
};
