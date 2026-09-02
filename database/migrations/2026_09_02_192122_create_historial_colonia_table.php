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
        Schema::create('historial_colonia', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('colonia_id')->index('colonia_id');
            $table->timestamp('fecha');
            $table->text('comentario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_colonia');
    }
};
