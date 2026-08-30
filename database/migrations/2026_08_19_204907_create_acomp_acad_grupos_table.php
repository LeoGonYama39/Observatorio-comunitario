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
        Schema::create('acomp_acad_grupos', function (Blueprint $table) {
            $table->integer('acomp_acad_gen_id')->index('acomp_acad_gen_id');
            $table->integer('comunidad_id');
            $table->float('calificacion')->nullable();
            $table->timestamps();

            $table->primary(['comunidad_id', 'acomp_acad_gen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acomp_acad_grupos');
    }
};
