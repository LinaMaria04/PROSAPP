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
            $table->string('FirmaCliente')->nullable();
            $table->string('Nombrefuncionario')->nullable();
            $table->string('SlugFirmas')->nullable();
            $table->tinyInteger('visible')->default(1);
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
