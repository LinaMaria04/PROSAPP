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
        Schema::create('programacion_servicios', function (Blueprint $table) {
            $table->id('ID_ProgServicio');
            $table->date('ProVehFecha')->nullable();
            $table->date('ProgHoraAprox')->nullable();
            $table->foreignId('FK_Vehiculo')->nullable()->constrained('vehiculos', 'ID_Vehiculo');
            $table->foreignId('FK_Conductor')->nullable()->constrained('personas', 'Id_Peronsa');
            $table->foreignId('FK_Servicio')->nullable()->constrained('solicitudes_servicio', 'ID_SolSer');
            $table->foreignId('FK_SedeServicio')->nullable()->constrained('sedes', 'Id_Sede');
            $table->decimal('SedeMapLat', 10, 7)->nullable();
            $table->decimal('SedeMapLong', 10, 7)->nullable();
            $table->string('ProgServSlug')->nullable();
            $table->string('Observacion')->nullable();
            $table->timestamps();
            $table->tinyInteger('DeletProgServ')->default(0);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programacion_servicios');
    }
};
