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
        Schema::create('problem_colonia', function (Blueprint $table) {
            $table->integer('problematica_id')->index('problematica_id');
            $table->integer('colonia_id');

            $table->primary(['colonia_id', 'problematica_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_colonia');
    }
};
