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
        Schema::create('inscripcion_materia', function (Blueprint $table) {
            $table->integer('insc_curso_id');
            $table->integer('materia_id')->index('materia_id');
            $table->boolean('cursado')->nullable();

            $table->primary(['insc_curso_id', 'materia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_materia');
    }
};
