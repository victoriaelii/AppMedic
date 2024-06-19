<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Clase Citas que representa el modelo de una cita médica en el sistema.
 */
class Citas extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables.
     */
    protected $fillable = [
        'fecha',    // Fecha de la cita
        'hora',     // Hora de la cita
        'activo',   // Estado de la cita (activo o inactivo)
        'pacienteid', // ID del paciente relacionado con la cita
        'medicoid'  // ID del médico relacionado con la cita
    ];

    /**
     * Define la relación entre el modelo Citas y el modelo Paciente.
     * Una cita pertenece a un paciente.
     */
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }

    /**
     * Define la relación entre el modelo Citas y el modelo Usuario (Médico).
     * Una cita pertenece a un médico.
     */
    public function medico()
    {
        return $this->belongsTo(User::class, 'medicoid');
    }
}
