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
        Schema::create('evento', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->date('fecha')->nullable();
            $table->text('alcance')->nullable();
            $table->text('evaluacion')->nullable();
            $table->text('objetivos')->nullable();
            $table->string('auditable', 2048)->nullable();
            $table->string('pobl_obj')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento');
    }
};
