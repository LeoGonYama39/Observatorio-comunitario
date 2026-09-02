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
        Schema::create('rol_evento_centro', function (Blueprint $table) {
            $table->integer('centro_id');
            $table->integer('evento_id')->index('evento_id');
            $table->string('rol', 30);
            $table->boolean('responsable')->nullable();

            $table->primary(['centro_id', 'evento_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rol_evento_centro');
    }
};
