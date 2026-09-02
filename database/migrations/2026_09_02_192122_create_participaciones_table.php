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
            $table->string('periodo')->nullable();
            $table->text('aport')->nullable();
            $table->enum('tipo', ['servicio_social', 'voluntariado', 'practica_profesional', 'prac_psicol', 'materia_inmersion']);
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
