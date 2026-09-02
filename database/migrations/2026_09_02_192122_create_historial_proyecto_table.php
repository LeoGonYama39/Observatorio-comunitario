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
        Schema::create('historial_proyecto', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('proyecto_id')->index('proyecto_id');
            $table->timestamp('fecha');
            $table->text('comentario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_proyecto');
    }
};
