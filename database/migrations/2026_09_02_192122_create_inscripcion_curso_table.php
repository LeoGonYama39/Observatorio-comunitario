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
        Schema::create('inscripcion_curso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('insc_edu_id')->index('insc_edu_id');
            $table->integer('cursos_id')->index('cursos_id');
            $table->date('fecha_ingreso')->nullable();
            $table->enum('estado', ['activo', 'concluido', 'baja'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_curso');
    }
};
