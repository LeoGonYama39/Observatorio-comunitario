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
        Schema::table('espacio_hist', function (Blueprint $table) {
            $table->foreign(['colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id', 'colonia_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('colonia')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['colonia_id', 'colonia_id'], '1')->references(['id', 'id'])->on('colonia')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['colonia_id', 'colonia_id', 'colonia_id', 'colonia_id'], '1')->references(['id', 'id', 'id', 'id'])->on('colonia')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['colonia_id'], '1')->references(['id'])->on('colonia')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('espacio_hist', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
