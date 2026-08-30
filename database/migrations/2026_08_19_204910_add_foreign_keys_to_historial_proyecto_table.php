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
        Schema::table('historial_proyecto', function (Blueprint $table) {
            $table->foreign(['proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id', 'proyecto_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('proyecto')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['proyecto_id', 'proyecto_id'], '1')->references(['id', 'id'])->on('proyecto')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['proyecto_id', 'proyecto_id', 'proyecto_id'], '1')->references(['id', 'id', 'id'])->on('proyecto')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_proyecto', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
