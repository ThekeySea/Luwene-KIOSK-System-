<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sambals', function (Blueprint $table) {
            $table->integer('sort_order')->default(0)->after('is_active');
        });

        Schema::table('spice_levels', function (Blueprint $table) {
            $table->uuid('sambal_id')->nullable()->after('id');
            $table->foreign('sambal_id')->references('id')->on('sambals')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('spice_levels', function (Blueprint $table) {
            $table->dropForeign(['sambal_id']);
            $table->dropColumn('sambal_id');
        });

        Schema::table('sambals', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
