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
        Schema::create('p_externo', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('nombre');
            $table->string('ap_pat');
            $table->string('ap_mat')->nullable();
            $table->string('universidad')->nullable();
            $table->string('usuario')->unique('usuario');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_externo');
    }
};
