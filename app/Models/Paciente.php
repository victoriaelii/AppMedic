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
        'nombres',        // Nombres del paciente
        'apepat',         // Apellido paterno del paciente
        'apemat',         // Apellido materno del paciente
        'fechanac',       // Fecha de nacimiento del paciente
        'correo',         // Correo electrónico del paciente
        'telefono',       // Teléfono del paciente
        'activo',         // Estado del paciente (activo o inactivo)
        'historial_medico', // Historial médico del paciente
    ];

    /**
     * Define la relación entre el modelo Paciente y el modelo Citas.
     * Un paciente puede tener muchas citas.  
     */
    public function citas()
    {
        // Relación uno a muchos: Un paciente puede tener muchas citas.
        return $this->hasMany(Citas::class, 'pacienteid');
    }
}
