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
        Schema::create('proyecto_area', function (Blueprint $table) {
            $table->integer('proyecto_id');
            $table->integer('area_id')->index('area_id');
            $table->timestamps();

            $table->primary(['proyecto_id', 'area_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_area');
    }
};
