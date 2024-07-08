<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaServicioTable extends Migration
{
    // se ejecuta cuando se aplica la migración
    public function up()
    {
        Schema::create('consulta_servicio', function (Blueprint $table) {
            $table->id(); // Columna de ID, llave primaria
            $table->foreignId('consulta_id')->constrained('consultas')->onDelete('cascade'); // Llave foránea que referencia a la tabla 'consultas', elimina en cascada
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade'); // Llave foránea que referencia a la tabla 'servicios', elimina en cascada
            $table->timestamps(); // Columna para timestamps, crea 'created_at' y 'updated_at'
        });
    }

    // se ejecuta cuando se revierte la migración
    public function down()
    {
        Schema::dropIfExists('consulta_servicio'); // Elimina la tabla 'consulta_servicio' si existe
    }
}
