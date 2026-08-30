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
        Schema::create('acomp_acad', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->enum('tipo', ['basico', 'media_super'])->nullable();
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
        Schema::dropIfExists('acomp_acad');
    }
};
