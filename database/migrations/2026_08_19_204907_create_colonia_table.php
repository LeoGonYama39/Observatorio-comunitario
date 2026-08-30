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
        Schema::create('colonia', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->integer('viviendas')->nullable();
            $table->integer('adultos')->nullable();
            $table->integer('ninos')->nullable();
            $table->integer('poblacion_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colonia');
    }
};
