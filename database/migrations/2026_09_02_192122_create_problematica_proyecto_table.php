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
        Schema::create('problematica_proyecto', function (Blueprint $table) {
            $table->integer('problematica_id');
            $table->integer('proyecto_id')->index('proyecto_id');

            $table->primary(['problematica_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problematica_proyecto');
    }
};
