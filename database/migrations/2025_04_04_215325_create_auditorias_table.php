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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('AuditType')->nullable();
            $table->string('AuditTabla')->nullable();
            $table->string('AuditRegistro')->nullable();
            $table->string('AuditUser')->nullable();
            $table->longText('Auditlog')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
