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
        Schema::create('prefacturas', function (Blueprint $table) {
            $table->bigIncrements('ID_Prefactura');
            $table->foreignId('FK_Comercial')->nullable()->constrained('users', 'Id_User');
            $table->foreignId('FK_Cliente')->nullable()->constrained('clientes', 'Id_Cliente');
            $table->foreignId('FK_Servicio')->nullable()->constrained('solicitudes_servicio', 'ID_SolSer');
            $table->decimal('Costo_transporte', 12, 2)->default(0);
            $table->decimal('Subtotal_procesos', 12, 2)->default(0);
            $table->decimal('Total_prefactura', 12, 2)->default(0);
            $table->string('status_prefactura')->nullable();
            $table->string('orden_compra')->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefacturas');
    }
};
