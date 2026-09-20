<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            // SQLite doesn't support MODIFY COLUMN for enums.
            // The original create migration already defines the enum;
            // tests using SQLite will just keep the original enum values.
            return;
        }

        DB::statement("ALTER TABLE modifier_groups MODIFY COLUMN type ENUM('NASI', 'EXTRA') NOT NULL");
    }

    public function down(): void
    {
        $driver = Schema::getConnection()->getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        DB::statement("ALTER TABLE modifier_groups MODIFY COLUMN type ENUM('NASI', 'SAMBAL', 'SPICE_LEVEL', 'EXTRA') NOT NULL");
    }
};
