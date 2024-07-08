<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id(); // Columna de ID, llave primaria
            $table->date('fecha'); // Columna para la fecha de la cita
            $table->time('hora'); // Columna para la hora de la cita
            $table->enum('activo', ['si', 'no'])->default('si'); // Columna para estado activo, con valores 'si' o 'no' y por defecto 'si'
            $table->foreignId('pacienteid')->constrained('pacientes')->cascadeOnDelete(); // Llave foránea que referencia a la tabla 'pacientes', elimina en cascada
            $table->foreignId('medicoid')->constrained('users')->cascadeOnDelete(); // Llave foránea que referencia a la tabla 'users', elimina en cascada
            $table->timestamps(); // Columna para timestamps, crea 'created_at' y 'updated_at'
        });
    }

    //se ejecuta cuando revertimos la migración
    public function down(): void
    {
        Schema::dropIfExists('citas'); // Elimina la tabla 'citas' si existe
    }
};
