<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * modelo del paciente
 */
class Paciente extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombres',
        'apepat',
        'apemat',
        'fechanac',
        'correo',
        'telefono',
        'activo',
        'historial_medico',
        'codigo', // Nuevo campo para el código
    ];

    public function citas()
    {
        return $this->hasMany(Citas::class, 'pacienteid');
    }
}
