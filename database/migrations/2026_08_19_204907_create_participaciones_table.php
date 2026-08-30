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
        Schema::create('participaciones', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('externo_id')->index('externo_id');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('aport')->nullable();
            $table->enum('tipo', ['servicio_social', 'voluntariado', 'practica_profesional', 'proyecto_inv', 'materia_inmersion']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participaciones');
    }
};
