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
        Schema::table('cursos_materias', function (Blueprint $table) {
            $table->foreign(['cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('cursos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['cursos_id', 'cursos_id'], '1')->references(['id', 'id'])->on('cursos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['cursos_id', 'cursos_id', 'cursos_id', 'cursos_id'], '1')->references(['id', 'id', 'id', 'id'])->on('cursos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['cursos_id'], '1')->references(['id'])->on('cursos')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('materias')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id', 'materias_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('materias')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['materias_id'], '2')->references(['id'])->on('materias')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos_materias', function (Blueprint $table) {
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
