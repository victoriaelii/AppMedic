<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    // atributos
    protected $fillable = [
        'nombre', // Nombre del producto
        'precio', // Precio del producto
        'activo'  // Estado del producto (activo o no)
    ];

    // Relación con la tabla de consultas
    public function consultas()
    {
        // Un producto puede estar en muchas consultas
        return $this->belongsToMany(Consultas::class, 'consulta_producto');
    }
}
