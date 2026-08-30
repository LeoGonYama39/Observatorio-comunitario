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
        Schema::table('caso_motivo', function (Blueprint $table) {
            $table->foreign(['caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id', 'caso_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('caso')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['caso_id', 'caso_id'], '1')->references(['id', 'id'])->on('caso')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['caso_id', 'caso_id', 'caso_id'], '1')->references(['id', 'id', 'id'])->on('caso')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id'], '2')->references(['id', 'id', 'id', 'id', 'id'])->on('list_padec_caso')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id', 'padec_caso_id'], '2')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('list_padec_caso')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('caso_motivo', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('2');
            $table->dropForeign('2');
        });
    }
};
