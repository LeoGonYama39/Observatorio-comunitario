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
        Schema::create('proyecto_colonia', function (Blueprint $table) {
            $table->integer('proyecto_id')->index('proyecto_id');
            $table->integer('colonia_id');

            $table->primary(['colonia_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_colonia');
    }
};
