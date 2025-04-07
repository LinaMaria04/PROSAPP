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
        Schema::create('observaciones_vehiculo', function (Blueprint $table) {
            $table->id('ID_Obs');
            $table->string('ObsStatus')->nullable();
            $table->text('ObsMensaje')->nullable();
            $table->string('ObsTipo')->nullable();
            $table->date('ObsDate')->nullable();
            $table->string('ObsUser')->nullable();
            $table->string('ObsRol')->nullable();
            $table->string('ObsSlug')->nullable();
            $table->tinyInteger('ObsRepeat')->default(0);
            $table->foreignId('FK_ObsVehiculo')->nullable()->constrained('vehiculos', 'ID_Vehiculo');
            $table->foreignId('FK_ObsSolSer')->nullable()->constrained('solicitudes_servicio', 'ID_SolSer');
            $table->timestamps();
            $table->tinyInteger('DeleteObs')->default(0);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observaciones_vehiculo');
    }
};
