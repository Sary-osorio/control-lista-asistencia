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
        Schema::create('asistencias_fecha', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->enum('estado', ['0', '1', '2'])->default('0')->comment('0: pendiente, 1: completado, 2: cancelado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias_fecha');
    }
};
