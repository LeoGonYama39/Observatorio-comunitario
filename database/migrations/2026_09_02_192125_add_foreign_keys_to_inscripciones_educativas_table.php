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
        Schema::table('inscripciones_educativas', function (Blueprint $table) {
            $table->foreign(['comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('p_comunidad')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['comunidad_id', 'comunidad_id'], '1')->references(['id', 'id'])->on('p_comunidad')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['comunidad_id', 'comunidad_id', 'comunidad_id', 'comunidad_id'], '1')->references(['id', 'id', 'id', 'id'])->on('p_comunidad')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['comunidad_id'], '1')->references(['id'])->on('p_comunidad')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripciones_educativas', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
