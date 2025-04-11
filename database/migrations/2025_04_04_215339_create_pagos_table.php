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
    Schema::create('pagos', function (Blueprint $table) {
        $table->id('ID_Pago');
        $table->date('Fechadepago')->nullable();
        $table->string('Status pago')->nullable();
        $table->foreignId('FK_LiquiServ')->constrained('liquidacion_servicios', 'ID_LiquiServ');
        $table->string('mediodepago')->nullable();
        $table->text('observacion')->nullable();
        $table->string('url_comprobante')->nullable();
        $table->string('url_recibo')->nullable();
        $table->string('PagoSlug')->nullable();
        $table->foreignId('FK_Cliente')->constrained('clientes', 'Id_Cliente');
        $table->timestamps();
        $table->tinyInteger('DeletePago')->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
