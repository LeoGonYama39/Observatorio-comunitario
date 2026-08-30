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
        Schema::create('rol_proyecto_centro', function (Blueprint $table) {
            $table->integer('centro_id');
            $table->integer('proyecto_id')->index('proyecto_id');
            $table->enum('rol', ['lider', 'participante']);
            $table->timestamps();

            $table->primary(['centro_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_proyecto_centro');
    }
};
