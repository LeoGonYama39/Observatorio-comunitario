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
        Schema::table('rol_proyecto_centro', function (Blueprint $table) {
            $table->foreign(['proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('proyecto')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['proyecto_id', 'proyecto_id'], '1')->references(['id', 'id'])->on('proyecto')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id'], '1')->references(['id', 'id', 'id', 'id'])->on('proyecto')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['proyecto_id'], '1')->references(['id'])->on('proyecto')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id', 'centro_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('p_centro')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['centro_id'], '2')->references(['id'])->on('p_centro')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rol_proyecto_centro', function (Blueprint $table) {
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
