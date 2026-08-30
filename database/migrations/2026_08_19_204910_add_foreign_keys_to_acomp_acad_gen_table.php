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
        Schema::table('acomp_acad_gen', function (Blueprint $table) {
            $table->foreign(['acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id'], '1')->references(['id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id', 'id'])->on('acomp_acad')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['acomp_acad_id', 'acomp_acad_id'], '1')->references(['id', 'id'])->on('acomp_acad')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign(['acomp_acad_id', 'acomp_acad_id', 'acomp_acad_id'], '1')->references(['id', 'id', 'id'])->on('acomp_acad')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('acomp_acad_gen', function (Blueprint $table) {
            $table->dropForeign('1');
            $table->dropForeign('1');
            $table->dropForeign('1');
        });
    }
};
