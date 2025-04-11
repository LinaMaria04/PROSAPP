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
    Schema::create('novedades', function (Blueprint $table) {
        $table->id('ID_Obs');
        $table->string('ObsStatus')->nullable();
        $table->string('ObsMensaje')->nullable();
        $table->string('ObsTipo')->nullable();
        $table->timestamp('ObsDate')->nullable();
        $table->string('ObsUser')->nullable();
        $table->string('ObsRol')->nullable();
        $table->tinyInteger('ObsRepeat')->default(0);
        $table->foreignId('FK_ObsSolSer')->nullable()->constrained('solicitudes_servicio', 'ID_SolSer');
        $table->timestamps();
        $table->timestamp('deleted_at')->nullable(); // soft delete
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('novedades');
    }
};
