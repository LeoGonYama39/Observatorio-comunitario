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
        Schema::create('historial_evento', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('evento_id')->index('evento_id');
            $table->timestamp('fecha');
            $table->text('comentario')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_evento');
    }
};
