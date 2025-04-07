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
        Schema::create('anticipos_tiquetera', function (Blueprint $table) {
            $table->id('ID_Anticipo');
            $table->decimal('Monto', 12, 2)->default(0);
            $table->foreignId('FK_Cliente')->constrained('clientes', 'Id_Cliente');
            $table->timestamps();
            $table->tinyInteger('DeleteAnticipo')->default(0);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anticipos_tiquetera');
    }
};
