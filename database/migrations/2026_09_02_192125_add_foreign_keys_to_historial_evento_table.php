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
        Schema::table('historial_evento', function (Blueprint $table) {
            $table->foreign(['evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id', 'evento_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('evento')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['evento_id', 'evento_id'], '1')->references(['id', 'id'])->on('evento')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['evento_id', 'evento_id', 'evento_id', 'evento_id'], '1')->references(['id', 'id', 'id', 'id'])->on('evento')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['evento_id'], '1')->references(['id'])->on('evento')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('historial_evento', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
