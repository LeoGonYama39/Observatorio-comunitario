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
        Schema::table('participaciones', function (Blueprint $table) {
            $table->foreign(['externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id', 'externo_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('p_externo')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['externo_id', 'externo_id'], '1')->references(['id', 'id'])->on('p_externo')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['externo_id', 'externo_id', 'externo_id', 'externo_id'], '1')->references(['id', 'id', 'id', 'id'])->on('p_externo')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['externo_id'], '1')->references(['id'])->on('p_externo')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participaciones', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
