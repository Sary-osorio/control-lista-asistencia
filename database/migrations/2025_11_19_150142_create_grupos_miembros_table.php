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
        Schema::create('grupos_miembros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grupo_id')->constrained('grupos');
            $table->foreignId('miembro_id')->constrained('miembros');
            $table->boolean('estado')->default(true)->comment('1: activo, 0: inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos_miembros');
    }
};
