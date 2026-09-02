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
        Schema::create('tallerista_comunidad', function (Blueprint $table) {
            $table->integer('taller_gen_id')->index('taller_gen_id');
            $table->integer('comunidad_id');

            $table->primary(['comunidad_id', 'taller_gen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tallerista_comunidad');
    }
};
