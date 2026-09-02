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
        Schema::create('eventos_institucion', function (Blueprint $table) {
            $table->integer('institucion_id');
            $table->integer('evento_id')->index('evento_id');

            $table->primary(['institucion_id', 'evento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_institucion');
    }
};
