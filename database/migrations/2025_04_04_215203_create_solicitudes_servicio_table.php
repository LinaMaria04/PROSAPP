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
        Schema::create('solicitudes_servicio', function (Blueprint $table) {
            $table->id('ID_SolSer');
            $table->string('SolSerStatus');
            $table->foreignId('FK_Conductor')->nullable()->constrained('personas', 'Id_Peronsa');
            $table->foreignId('FK_Vehículo')->nullable()->constrained('vehiculos', 'ID_Vehiculo');
            $table->date('SolSerFecha')->nullable();
            $table->string('SolSerSlug')->nullable();
            $table->tinyInteger('SolSerFactura')->default(0);
            $table->integer('NumFactura')->nullable();
            $table->integer('CalificacionServ')->nullable();
            $table->foreignId('FK_Sede')->nullable()->constrained('sedes', 'Id_Sede');
            $table->foreignId('FK_Cliente')->nullable()->constrained('clientes', 'Id_Cliente');
            $table->decimal('Total_KG')->nullable();
            $table->foreignId('FK_LiquiServ')->nullable()->constrained('liquidacion_servicios', 'ID_LiquiServ');
            $table->integer('NumFactura')->nullable();
            $table->integer('CalificacionServ')->nullable();

            $table->timestamps();
            $table->tinyInteger('DeleteSolSer')->default(0);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_servicio');
    }
};
