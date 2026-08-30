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
        Schema::create('p_comunidad', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('colonia_id')->nullable()->index('colonia_id');
            $table->string('nombre');
            $table->string('ap_pat');
            $table->string('ap_mat')->nullable();
            $table->string('rango_edad')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->enum('nv_escolar', ['primaria', 'secundaria', 'preparatoria', 'universidad', 'tecnica', 'otro'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_comunidad');
    }
};
