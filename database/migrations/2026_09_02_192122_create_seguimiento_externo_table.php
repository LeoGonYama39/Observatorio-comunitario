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
        Schema::create('seguimiento_externo', function (Blueprint $table) {
            $table->integer('participacion_id');
            $table->integer('seguimiento_caso_id')->index('seguimiento_caso_id');

            $table->primary(['participacion_id', 'seguimiento_caso_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_externo');
    }
};
