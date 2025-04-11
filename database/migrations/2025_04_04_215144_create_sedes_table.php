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
    Schema::create('sedes', function (Blueprint $table) {
        $table->id('Id_Sede');
        $table->foreignId('FK_Persona')->nullable()->constrained('personas', 'Id_Peronsa');
        $table->string('NombreSede');
        $table->string('Direccion');
        $table->string('SedeMapAddressSearch')->nullable();
        $table->string('SedeMapAddressResult')->nullable();
        $table->decimal('SedeMapLat', 10, 7)->nullable(); // formato común para latitud
        $table->decimal('SedeMapLong', 10, 7)->nullable(); // formato común para longitud
        $table->string('SedeMapLocalidad')->nullable();
        $table->string('SedeSlug')->nullable();
        $table->timestamps();
        $table->tinyInteger('DeleteSedes')->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sedes');
    }
};
