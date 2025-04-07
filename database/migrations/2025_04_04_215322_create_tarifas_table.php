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
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id('ID_Tarifa');
            $table->string('Categoria');
            $table->decimal('Costo', 12, 2)->default(0);
            $table->string('TarifaSlug')->nullable();
            $table->timestamps();
            $table->tinyInteger('DeleteTarifa')->default(0);
        });
    }
     /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarifas');
    }
};
