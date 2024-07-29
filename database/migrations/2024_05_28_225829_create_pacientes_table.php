<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apepat', 100);
            $table->string('apemat', 100);
            $table->date('fechanac');
            $table->string('correo', 100)->unique();
            $table->string('telefono', 20);
            $table->enum('activo', ['si', 'no'])->default('si');
            $table->longText('historial_medico')->nullable();
            $table->string('codigo', 8)->nullable(); // Nuevo campo para el código
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
