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
    Schema::create('liquidacion_servicios', function (Blueprint $table) {
        $table->id('ID_LiquiServ');
        $table->foreignId('FK_SolSer')->constrained('solicitudes_servicio', 'ID_SolSer');
        $table->decimal('TotalKg', 10, 2)->nullable();
        $table->foreignId('FK_Tarifas')->nullable()->constrained('tarifas', 'ID_Tarifa');
        $table->decimal('TotalKgAdicional', 10, 2)->nullable();
        $table->decimal('TotalPagar', 12, 2)->nullable();
        $table->string('LiquiServSlug')->nullable();
        $table->timestamps();
        $table->tinyInteger('DeleteLiquiServ')->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidacion_servicios');
    }
};
