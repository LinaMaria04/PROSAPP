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
    Schema::create('roles', function (Blueprint $table) {
        $table->id('Id_Rol'); // Clave primaria autoincremental
        $table->string('Rol'); // Varchar
        $table->string('Descripción'); // Varchar
        $table->timestamps(); // created_at y updated_at
        $table->tinyInteger('DeleteRol')->default(0); // Tinyint
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
