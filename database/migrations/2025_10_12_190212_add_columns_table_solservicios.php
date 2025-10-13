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
        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->unsignedBigInteger('FK_Sede');
            $table->unsignedBigInteger('FK_Cliente');
            $table->foreign('FK_Sede')->references('Id_Sede')->on('sedes')->onDelete('cascade');
            $table->foreign('FK_Cliente')->references('Id_Cliente')->on('clientes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('solicitudes_servicio', function (Blueprint $table) {
            $table->dropForeign(['FK_Sede']);
            $table->dropForeign(['FK_Cliente']);
        });
    }
};
