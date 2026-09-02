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
        Schema::create('caso_tutor', function (Blueprint $table) {
            $table->integer('caso_id');
            $table->integer('comunidad_id')->index('comunidad_id');
            $table->enum('parentesco', ['mad', 'pat', 'herm', 'tio', 'abu', 'otro'])->nullable();

            $table->primary(['caso_id', 'comunidad_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caso_tutor');
    }
};
