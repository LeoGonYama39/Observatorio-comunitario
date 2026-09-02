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
        Schema::create('seguimiento_caso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('caso_id')->index('caso_id');
            $table->timestamp('fecha');
            $table->text('nota')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seguimiento_caso');
    }
};
