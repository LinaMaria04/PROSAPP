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
        Schema::create('recibos_material', function (Blueprint $table) {
            $table->id('ID_Firmas');
            $table->integer('FK_Solser');
            $table->integer('FK_Gener');
            $table->integer('FK_SGener');
            $table->string('FirmaCliente')->nullable();
            $table->string('Nombrefuncionario')->nullable();
            $table->string('SlugFirmas')->nullable();
            $table->integer('Cedula')->nullable();
            $table->string('Observaciones');
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibos_material');
    }
};
