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
    Schema::create('personas', function (Blueprint $table) {
        $table->id('Id_Peronsa'); // Clave primaria
        $table->string('PersDocType');
        $table->string('PersDocNumber');
        $table->string('PrimerNombre');
        $table->string('SegundoNombre')->nullable();
        $table->string('Apellidos');
        $table->string('Telefono')->nullable();
        $table->tinyInteger('FK_PersCliente')->nullable(); // FK a clientes si es necesario
        $table->string('PersSlug')->nullable();
        $table->timestamps(); // created_at y updated_at
        $table->integer('DeletePersona')->default(0);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
