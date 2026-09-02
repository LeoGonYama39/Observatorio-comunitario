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
        Schema::table('inscripcion_curso', function (Blueprint $table) {
            $table->foreign(['insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('inscripciones_educativas')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['insc_edu_id', 'insc_edu_id'], '1')->references(['id', 'id'])->on('inscripciones_educativas')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['insc_edu_id', 'insc_edu_id', 'insc_edu_id', 'insc_edu_id'], '1')->references(['id', 'id', 'id', 'id'])->on('inscripciones_educativas')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['insc_edu_id'], '1')->references(['id'])->on('inscripciones_educativas')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('cursos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id', 'cursos_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('cursos')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['cursos_id'], '2')->references(['id'])->on('cursos')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripcion_curso', function (Blueprint $table) {
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
