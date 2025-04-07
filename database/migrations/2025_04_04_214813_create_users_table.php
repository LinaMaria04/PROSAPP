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
    Schema::create('users', function (Blueprint $table) {
        $table->id('Id_User'); // Clave primaria
        $table->string('Nombre');
        $table->string('Email')->unique();
        $table->timestamp('Verificación Email')->nullable();
        $table->string('Contraseña');
        $table->rememberToken(); // crea campo varchar(100) para token
        $table->string('UserSlug')->nullable();
        $table->string('UsRol')->nullable(); // Puedes hacer FK con tabla roles si deseas
        $table->foreignId('FK_UserPersona')->nullable()->constrained('personas', 'Id_Peronsa');
        $table->timestamps(); // created_at y updated_at
        $table->integer('DeleteUser')->default(0);
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
