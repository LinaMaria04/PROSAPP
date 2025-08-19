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
        Schema::table('sedes', function (Blueprint $table) {
            $table->unsignedBigInteger('SedeMapLocalidad')->change();
            $table->foreign('SedeMapLocalidad')->references('id')->on('localidades')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->dropForeign(['SedeMapLocalidad']);
            $table->string('SedeMapLocalidad')->change();
        });
    }
};
