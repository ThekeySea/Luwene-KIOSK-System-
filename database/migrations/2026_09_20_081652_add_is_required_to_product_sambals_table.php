<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_sambals', function (Blueprint $table) {
            $table->boolean('is_required')->default(true)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('product_sambals', function (Blueprint $table) {
            $table->dropColumn('is_required');
        });
    }
};
