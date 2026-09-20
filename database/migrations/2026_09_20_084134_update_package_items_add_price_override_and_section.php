<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_items', function (Blueprint $table) {
            $table->decimal('price_override', 12, 2)->nullable()->after('quantity');
            $table->uuid('package_section_id')->nullable()->after('role');
            $table->foreign('package_section_id')->references('id')->on('package_sections')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('package_items', function (Blueprint $table) {
            $table->dropForeign(['package_section_id']);
            $table->dropColumn(['price_override', 'package_section_id']);
        });
    }
};
