<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Este método se ejecuta cuando aplicamos la migración
    public function up(): void
    {
        Schema::create('consulta_producto', function (Blueprint $table) {
            $table->id(); // Columna de ID, llave primaria
            $table->foreignId('consulta_id')->constrained('consultas')->onDelete('cascade'); // Llave foránea que referencia a la tabla 'consultas', elimina en cascada
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // Llave foránea que referencia a la tabla 'productos', elimina en cascada
            $table->timestamps(); // Columnas para timestamps, crea 'created_at' y 'updated_at'
        });
    }

    // Este método se ejecuta cuando revertimos la migración
    public function down(): void
    {
        Schema::dropIfExists('consulta_producto'); // Elimina la tabla 'consulta_producto' si existe
    }
};
