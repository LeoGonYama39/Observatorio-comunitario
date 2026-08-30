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
        Schema::table('tallerista_centro', function (Blueprint $table) {
            $table->foreign(['taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('taller_gen')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['taller_gen_id', 'taller_gen_id'], '1')->references(['id', 'id'])->on('taller_gen')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['taller_gen_id', 'taller_gen_id', 'taller_gen_id'], '1')->references(['id', 'id', 'id'])->on('taller_gen')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id'], '2')->references(['id', 'id', 'id', 'id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tallerista_centro', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('2');
            $table->dropForeign('2');
        });
    }
};
