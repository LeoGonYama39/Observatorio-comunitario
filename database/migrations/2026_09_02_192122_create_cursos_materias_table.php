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
        Schema::create('cursos_materias', function (Blueprint $table) {
            $table->integer('cursos_id');
            $table->integer('materias_id')->index('materias_id');

            $table->primary(['cursos_id', 'materias_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos_materias');
    }
};
