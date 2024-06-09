<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Productos que representa un producto en nuestro sistema.
 */
class Productos extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden llenar al crear o actualizar un producto.
     */
    protected $fillable = [
        'nombre',   // Nombre del producto
        'precio',   // Precio del producto
        'activo',   // Estado del producto (activo o inactivo)
    ];
}
