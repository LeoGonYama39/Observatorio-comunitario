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
        Schema::create('taller', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->date('init');
            $table->enum('estado', ['activo', 'pausado', 'cancelado'])->nullable();
            $table->text('alcance')->nullable();
            $table->text('evaluacion')->nullable();
            $table->text('objetivos')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taller');
    }
};
