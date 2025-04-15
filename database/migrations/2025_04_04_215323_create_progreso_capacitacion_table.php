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
        Schema::create('progreso_capacitacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('capacitacion_id')->constrained('capacitaciones', 'id');
            $table->foreignId('usuario_id')->constrained('users', 'Id_User');
            $table->tinyInteger('porcentaje')->default(0);
            $table->dateTime('fecha_ultimo_acceso')->nullable();
            $table->tinyInteger('visible')->default(1);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progreso_capacitacion');
    }
};
