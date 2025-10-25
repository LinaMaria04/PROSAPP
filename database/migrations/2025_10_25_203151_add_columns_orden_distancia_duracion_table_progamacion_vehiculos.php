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
        Schema::table('programacion_servicios', function (Blueprint $table) {
            $table->integer('Orden')->nullable();
            $table->decimal('Distancia')->nullable();
            $table->integer('Duracion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('programacion_servicios', function (Blueprint $table) {
            //
        });
    }
};
