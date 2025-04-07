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
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id('ID_Tratamiento');
            $table->string('TratName');
            $table->tinyInteger('TratTipo')->nullable();
            $table->string('TratGestor')->nullable();
            $table->timestamps();
            $table->tinyInteger('DeleteTrat')->default(0);
        });
    }
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
