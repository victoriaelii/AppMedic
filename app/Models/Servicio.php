<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    // atributos
    protected $fillable = [
        'nombre', // Nombre del servicio
        'precio', // Precio del servicio
        'activo'  // Estado del servicio (activo o no)
    ];

    // Relación con la tabla de consultas
    public function consultas()
    {
        // Un servicio puede estar en muchas consultas
        return $this->belongsToMany(Consultas::class, 'consulta_servicio');
    }
}
