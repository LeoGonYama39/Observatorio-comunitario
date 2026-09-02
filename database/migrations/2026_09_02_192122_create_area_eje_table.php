<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('area_eje', function (Blueprint $table) {
            $table->integer('area_id');
            $table->integer('eje_id')->index('eje_id');

            $table->primary(['area_id', 'eje_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_eje');
    }
};
