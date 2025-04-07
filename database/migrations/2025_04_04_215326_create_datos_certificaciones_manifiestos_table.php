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
    Schema::create('datos_certificaciones_manifiestos', function (Blueprint $table) {
        $table->id('ID_CertDato');
        $table->foreignId('FK_DatoCert')->nullable()->constrained('certificados', 'ID_Cert');
        $table->foreignId('FK_DatoCertSolRes')->nullable()->constrained('solicitud_residuos', 'ID_SolRes');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_certificaciones_manifiestos');
    }
};
