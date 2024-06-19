<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase se usa para crear y eliminar la tabla 'citas' en la base de datos.
return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        // Crear la tabla 'citas' para almacenar las citas de los pacientes.
        Schema::create('citas', function (Blueprint $table) {
            $table->id(); // Columna para el ID único de la cita.
            $table->date('fecha'); // Columna para la fecha de la cita.
            $table->time('hora'); // Columna para la hora de la cita.
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna para el estado (activo o inactivo) de la cita, por defecto es 'si'.
            $table->foreignId('pacienteid')->constrained('pacientes')->onDelete('cascade'); // Columna para el ID del paciente, con restricción de eliminación en cascada.
            $table->foreignId('medicoid')->constrained('users')->onDelete('cascade'); // Columna para el ID del médico, con restricción de eliminación en cascada.
            $table->timestamps(); // Columnas para las marcas de tiempo (creación y actualización).
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        // Elimina la tabla 'citas' si existe.
        Schema::dropIfExists('citas');
    }
};
