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
        Schema::create('proyecto', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->text('antecedentes')->nullable();
            $table->text('objetivos')->nullable();
            $table->string('repo')->nullable();
            $table->boolean('prioritario')->nullable();
            $table->text('alcance')->nullable();
            $table->text('evaluacion')->nullable();
            $table->enum('estado', ['en_proceso', 'concluido', 'cancelado', 'pausado'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto');
    }
};
