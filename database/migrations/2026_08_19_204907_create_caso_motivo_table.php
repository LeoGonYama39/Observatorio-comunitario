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
        Schema::create('caso_motivo', function (Blueprint $table) {
            $table->integer('caso_id');
            $table->integer('padec_caso_id')->index('padec_caso_id');
            $table->timestamps();

            $table->primary(['caso_id', 'padec_caso_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caso_motivo');
    }
};
