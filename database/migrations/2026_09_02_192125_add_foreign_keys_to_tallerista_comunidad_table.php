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
        Schema::table('tallerista_comunidad', function (Blueprint $table) {
            $table->foreign(['taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('taller_gen')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['taller_gen_id', 'taller_gen_id'], '1')->references(['id', 'id'])->on('taller_gen')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['taller_gen_id', 'taller_gen_id', 'taller_gen_id', 'taller_gen_id'], '1')->references(['id', 'id', 'id', 'id'])->on('taller_gen')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['taller_gen_id'], '1')->references(['id'])->on('taller_gen')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tallerista_comunidad', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
