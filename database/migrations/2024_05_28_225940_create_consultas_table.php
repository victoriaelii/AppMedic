<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Esta clase se usa para crear y eliminar la tabla 'consultas' en la base de datos.
return new class extends Migration
{
    // Método que se ejecuta al aplicar la migración (crear la tabla 'consultas').
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id(); // Columna para el ID único de la consulta.
            $table->date('fecha'); // Columna para la fecha de la consulta.
            $table->time('hora'); // Columna para la hora de la consulta.
            $table->text('diagnostico'); // Columna para el diagnóstico del paciente.
            $table->text('receta'); // Columna para la receta médica.
            $table->foreignId('pacienteid')->constrained('pacientes')->onDelete('cascade'); // Columna para el ID del paciente, con restricción de eliminación en cascada.
            $table->foreignId('usuariomedicoid')->constrained('users')->onDelete('cascade'); // Columna para el ID del médico, con restricción de eliminación en cascada.
            $table->timestamps(); // Columnas para las marcas de tiempo (creación y actualización).
        });
    }

    // Método que se ejecuta al revertir la migración (eliminar la tabla 'consultas').
    public function down(): void
    {
        Schema::dropIfExists('consultas'); // Elimina la tabla 'consultas'.
    }
};
