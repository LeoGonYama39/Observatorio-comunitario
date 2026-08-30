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
            $table->integer('problem_colonia_id')->index('problem_colonia_id');
            $table->integer('colonia_id');
            $table->timestamps();

            $table->primary(['colonia_id', 'problem_colonia_id']);
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
