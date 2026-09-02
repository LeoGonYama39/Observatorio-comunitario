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
        Schema::table('seguimiento_caso', function (Blueprint $table) {
            $table->foreign(['caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('caso')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['caso_id', 'caso_id'], '1')->references(['id', 'id'])->on('caso')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['caso_id', 'caso_id', 'caso_id', 'caso_id'], '1')->references(['id', 'id', 'id', 'id'])->on('caso')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['caso_id'], '1')->references(['id'])->on('caso')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seguimiento_caso', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
