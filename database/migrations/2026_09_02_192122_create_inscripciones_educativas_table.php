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
        Schema::create('inscripciones_educativas', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('comunidad_id')->unique('comunidad_id');
            $table->string('rfe', 20)->nullable();
            $table->string('curp', 20)->nullable();
            $table->string('matricula', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones_educativas');
    }
};
