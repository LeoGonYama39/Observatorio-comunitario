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
        Schema::table('seguimiento_externo', function (Blueprint $table) {
            $table->foreign(['seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('seguimiento_caso')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['seguimiento_caso_id', 'seguimiento_caso_id'], '1')->references(['id', 'id'])->on('seguimiento_caso')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id'], '1')->references(['id', 'id', 'id', 'id'])->on('seguimiento_caso')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['seguimiento_caso_id'], '1')->references(['id'])->on('seguimiento_caso')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('participaciones')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id', 'participacion_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('participaciones')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['participacion_id'], '2')->references(['id'])->on('participaciones')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seguimiento_externo', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('2');
            $table->dropForeign('2');
            $table->dropForeign('2');
        });
    }
};
