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
        Schema::create('progamacion_vehiculos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('FK_Servicio');
            $table->unsignedBigInteger('FK_Vehiculo');
            $table->string('ProgVehDia', 20);
            $table->date('ProgVehFecha');
            $table->decimal('ProgVehKgAsignados', 10, 2)->default(0);
            $table->enum('ProgVehEstado', ['Pendiente', 'En Ruta', 'Completado', 'Cancelado'])->default('Pendiente');
            $table->boolean('ProgVehDelete')->default(false);
            $table->timestamps();

            $table->foreign('FK_Servicio')->references('ID_SolSer')->on('solicitudes_servicio')->onDelete('cascade');
            $table->foreign('FK_Vehiculo')->references('ID_Vehiculo')->on('vehiculos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progamacion_vehiculos');
    }
};
