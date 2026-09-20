<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_sections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('package_id');
            $table->string('name');
            $table->enum('choice_type', ['SINGLE', 'MULTIPLE'])->default('SINGLE');
            $table->integer('max_pick')->default(1);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_sections');
    }
};
