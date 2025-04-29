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
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('UserSlug')->nullable()->unique();
            $table->string('UsRol');
            $table->boolean('is_active')->default(true);
            $table->string('verification_token')->nullable();
            $table->boolean('DeleteUser')->default(false);
            $table->unsignedBigInteger('FK_UserPersona')->nullable();
            $table->rememberToken(); // crea campo varchar(100) para token
            $table->timestamps(); // created_at y updated_at
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
