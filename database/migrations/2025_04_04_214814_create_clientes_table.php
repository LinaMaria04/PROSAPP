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
    Schema::create('clientes', function (Blueprint $table) {
        $table->id('Id_Cliente');
        $table->string('ClientDocType');
        $table->string('ClientDocumento');
        $table->string('ClientSlug')->nullable();
        $table->string('ClientRut')->nullable();
        $table->string('CorreoFE')->nullable();
        $table->tinyInteger('FK_PersCliente')->nullable(); // FK opcional a personas
        $table->string('ClientStatus')->nullable();
        $table->string('TipoFacturacion')->nullable();
        $table->timestamps();
        $table->integer('DeleteClientes')->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
