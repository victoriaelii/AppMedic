<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Se ejecuta cuando se aplica la migración
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id(); // Columna de ID, llave primaria
            $table->foreignId('cita_id')->constrained('citas')->cascadeOnDelete(); // Llave foránea que referencia a la tabla 'citas', elimina en cascada
            $table->text('diagnostico'); // Columna para el diagnóstico
            $table->text('recete'); // Columna para la receta
            $table->decimal('totalPagar', 10, 2)->default(0); // Columna para el total a pagar, valor por defecto 0
            $table->foreignId('usuariomedicoid')->constrained('users')->cascadeOnDelete(); // Llave foránea que referencia a la tabla 'users', elimina en cascada
            $table->json('signos_vitales')->nullable(); // Columna para los signos vitales, permite valores nulos
            $table->text('motivo_consulta')->nullable(); // Columna para el motivo de la consulta, permite valores nulos
            $table->text('notas_padecimiento')->nullable(); // Columna para notas del padecimiento, permite valores nulos
            $table->text('examen_fisico')->nullable(); // Columna para el examen físico, permite valores nulos
            $table->text('pronostico')->nullable(); // Columna para el pronóstico, permite valores nulos
            $table->text('plan')->nullable(); // Columna para el plan de tratamiento, permite valores nulos
            $table->text('alergias')->nullable(); // Columna para las alergias, permite valores nulos
            $table->string('estado')->default('en curso'); // Columna para el estado, valor por defecto en curso
            $table->timestamps(); // Columna para timestamps, crea 'created_at' y 'updated_at'
        });
    }

    // Se ejecuta cuando se revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('consultas'); // Elimina la tabla 'consultas' si existe
    }
};
