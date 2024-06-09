<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Servicio que representa un servicio en nuestro sistema.
 */
class Servicio extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden llenar al crear o actualizar un servicio.
     */
    protected $fillable = [
        'nombre',   // Nombre del servicio
        'precio',   // Precio del servicio
        'activo',   // Estado del servicio (activo o inactivo)
    ];
}
