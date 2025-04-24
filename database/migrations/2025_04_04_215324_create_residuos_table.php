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
        Schema::create('residuos', function (Blueprint $table) {
            $table->id('ID_Respel');
            $table->string('RespelName');
            $table->text('RespelDescrip')->nullable();
            $table->string('YRespelClasf4741')->nullable();
            $table->string('ARespelClasf4741')->nullable();
            $table->string('RespelIgrosidad')->nullable();
            $table->string('RespelEstado')->nullable();
            $table->integer('Cedula')->nullable();
            $table->string('RespelHojaSeguridad')->nullable();
            $table->string('RespelTarj')->nullable();
            $table->string('RespelSlug')->nullable();
            $table->string('RespelStatus');
            $table->foreignId('FK_RespelCoti')->nullable(); // puedes enlazarla después si tienes tabla de cotizaciones
            $table->string('RespelFoto');
            $table->tinyInteger('SustanciaControlada')->default(0);
            $table->tinyInteger('SustanciaControladaTipo')->nullable();
            $table->string('SustanciaControladaNombre')->nullable();
            $table->string('SustanciaControladaDocumento')->nullable();
            $table->tinyInteger('RespelDeclaracion')->default(0);
            $table->string('RespelStatusDescription');
            $table->tinyInteger('AceiteUsado');
            $table->timestamps();
            $table->tinyInteger('RespelDelete')->default(0);
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residuos');
    }
};
