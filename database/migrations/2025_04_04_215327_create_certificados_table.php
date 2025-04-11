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
    Schema::create('certificados', function (Blueprint $table) {
        $table->id('ID_Cert');
        $table->integer('CertType')->nullable();
        $table->integer('CertNumero')->nullable();
        $table->string('CertiEspName')->nullable();
        $table->string('CertiEspValue')->nullable();
        $table->string('CertObservacion')->nullable();
        $table->string('CertSlug')->nullable();
        $table->string('CertNumRm')->nullable();
        $table->string('CertSrc')->nullable();
        $table->tinyInteger('CertAuthHseq')->nullable();
        $table->tinyInteger('CertAuthJl')->nullable();
        $table->tinyInteger('CertAuthDp')->nullable();
        $table->string('CertAnexo')->nullable();
        $table->integer('CertManifNumero')->nullable();
        $table->string('CertNumeroExt')->nullable();
        $table->string('CertManifPrepend')->nullable();
        $table->string('CertSrcManif')->nullable();
        $table->string('CertSrcExt')->nullable();
        $table->foreignId('FK_CertSolser')->nullable()->constrained('solicitudes_servicio', 'ID_SolSer');
        $table->foreignId('FK_CertCliente')->nullable()->constrained('clientes', 'Id_Cliente');
        $table->foreignId('FK_CertGenerSede')->nullable()->constrained('sedes', 'Id_Sede');
        $table->foreignId('FK_CertGestor')->nullable()->constrained('personas', 'Id_Peronsa');
        $table->foreignId('FK_CertTrat')->nullable()->constrained('tratamientos', 'ID_Tratamiento');
        $table->foreignId('FK_CertTransp')->nullable()->constrained('personas', 'Id_Peronsa');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificados');
    }
};
