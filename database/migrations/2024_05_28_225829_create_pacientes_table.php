<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase se usa para crear y eliminar la tabla 'pacientes' en la base de datos.
return new class extends Migration
{
    // Método que se ejecuta al aplicar la migración (crear la tabla 'pacientes').
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id(); // Columna para el ID único del paciente.
            $table->string('nombres', 100); // Columna para los nombres del paciente.
            $table->string('apepat', 100); // Columna para el apellido paterno.
            $table->string('apemat', 100); // Columna para el apellido materno.
            $table->date('fechanac'); // Columna para la fecha de nacimiento.
            $table->string('correo', 100)->unique(); // Columna para el correo electrónico, que debe ser único.
            $table->string('telefono', 20); // Columna para el teléfono.
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna para el estado (activo o inactivo) del paciente, por defecto es 'si'.
            $table->longText('historial_medico')->nullable(); // Columna para el historial médico del paciente.
            $table->timestamps(); // Columnas para las marcas de tiempo (creación y actualización).
        });
    }

    // Método que se ejecuta al revertir la migración (eliminar la tabla 'pacientes').
    public function down(): void
    {
        Schema::dropIfExists('pacientes'); // Elimina la tabla 'pacientes'.
    }
};
