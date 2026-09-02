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
        Schema::create('p_centro', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->string('ap_pat');
            $table->string('ap_mat')->nullable();
            $table->enum('cargo', ['coordinador', 'seguridad', 'administrativo'])->nullable();
            $table->string('usuario')->unique('usuario');
            $table->string('password');
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_centro');
    }
};
