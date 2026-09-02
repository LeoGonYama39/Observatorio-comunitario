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
            $table->integer('comunidad_id')->index('comunidad_id');
            $table->date('init');
            $table->enum('tipo', ['psicoedu', 'acad', 'eval_psico']);
            $table->enum('estado', ['activo', 'baja', 'cerrado'])->nullable();
            $table->text('peticion')->nullable();
            $table->boolean('canalizado')->nullable();
            $table->string('canalizado_site')->nullable();
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
