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
        Schema::create('rol_proyecto_comunidad', function (Blueprint $table) {
            $table->integer('comunidad_id');
            $table->integer('proyecto_id')->index('proyecto_id');
            $table->string('rol', 30);

            $table->primary(['comunidad_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_proyecto_comunidad');
    }
};
