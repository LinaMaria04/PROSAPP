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
    Schema::create('contratos', function (Blueprint $table) {
        $table->bigIncrements('ID_Contra');
        $table->string('ContraPdf')->nullable();
        $table->date('ContraVigencia')->nullable();
        $table->date('ContraNotifiVigencia')->nullable();
        $table->string('ContratoNumVigencia')->nullable();
        $table->string('ContratoTypeVigencia')->nullable();
        $table->tinyInteger('ContraDelete')->default(0);
        $table->string('ContraSlug')->nullable();
        $table->foreignId('Fk_ContraCli')->nullable()->constrained('clientes', 'Id_Cliente');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};
