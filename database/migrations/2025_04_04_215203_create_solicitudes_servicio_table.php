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
        Schema::create('solicitudes_servicio', function (Blueprint $table) {
            $table->id('ID_SolSer');
            $table->string('NumFactura')->unique()->nullable();
            $table->date('FechaSolicitud');
            $table->string('SolSerSlug')->nullable();
            $table->string('Estado');
            $table->text('Observaciones')->nullable();
            $table->tinyInteger('SolSerDelete')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_servicio');
    }
};
