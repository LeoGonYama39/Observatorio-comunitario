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
        Schema::table('seguimiento_centro', function (Blueprint $table) {
            $table->foreign(['centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['centro_id', 'centro_id'], '1')->references(['id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['centro_id', 'centro_id', 'centro_id'], '1')->references(['id', 'id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id'], '2')->references(['id', 'id', 'id', 'id', 'id'])->on('seguimiento_caso')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id', 'seguimiento_caso_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('seguimiento_caso')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seguimiento_centro', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('2');
            $table->dropForeign('2');
        });
    }
};
