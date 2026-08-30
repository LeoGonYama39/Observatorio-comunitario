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
        Schema::create('caso', function (Blueprint $table) {
            $table->integer('id', true);
            $table->date('init');
            $table->enum('tipo', ['medica', 'psicopedagogica', 'acomp_psicosocial', 'juridico', 'nutricion']);
            $table->enum('estado', ['activo', 'cerrado'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caso');
    }
};
