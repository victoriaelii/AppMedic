<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citas extends Model
{
    use HasFactory;

    // atributos
    protected $fillable = [
        'fecha',       // Fecha de la cita
        'hora',        // Hora de la cita
        'activo',      // Estado de la cita (activa o no)
        'pacienteid',  // ID del paciente asociado a la cita
        'medicoid'     // ID del médico asociado a la cita
    ];

    //  relación entre Citas y Paciente
    public function paciente()
    {
        // Una cita pertenece a un paciente
        return $this->belongsTo(Paciente::class, 'pacienteid');
    }

    // relación entre Citas y Medico (Usuario)
    public function medico()
    {
        // Una cita pertenece a un médico (usuario)
        return $this->belongsTo(User::class, 'medicoid');
    }

    // relación entre Citas y Consultas
    public function consulta()
    {
        // Una cita tiene una consulta asociada
        return $this->hasOne(Consultas::class, 'cita_id');
    }
}
