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
    Schema::create('solicitud_residuos', function (Blueprint $table) {
        $table->id('ID_SolRes');
        $table->foreignId('FK_SolSer')->constrained('solicitudes_servicio', 'ID_SolSer');
        $table->decimal('SolResKgEnviado', 10, 2)->nullable();
        $table->decimal('SolResKgRecibido', 10, 2)->nullable();
        $table->string('SolResEmbalaje')->nullable();
        $table->string('SolResSlug')->nullable();
        $table->foreignId('FK_Residuo')->nullable()->constrained('residuos', 'ID_Respel');
        $table->foreignId('FK_Sede')->nullable()->constrained('sedes', 'Id_Sede');
        $table->timestamps();
        $table->tinyInteger('DeleteSolRes')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitud_residuos');
    }
};
