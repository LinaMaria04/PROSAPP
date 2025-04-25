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
    Schema::create('tipo_comercio', function (Blueprint $table) {
        $table->id('Id_Comercio');
        $table->string('Comercio');
        $table->string('Descripción')->nullable();
        $table->timestamps(); // created_at y updated_at
        $table->tinyInteger('DeleteComercio')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_comercio');
    }
};
