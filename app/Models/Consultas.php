<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    // atributos
    protected $fillable = [
        'cita_id',             // ID de la cita relacionada
        'diagnostico',         // Diagnóstico de la consulta
        'recete',              // Receta dada en la consulta
        'totalPagar',          // Total a pagar por la consulta
        'usuariomedicoid',     // ID del médico que hizo la consulta
        'signos_vitales',      // Signos vitales del paciente
        'motivo_consulta',     // Motivo de la consulta
        'notas_padecimiento',  // Notas sobre el padecimiento del paciente
        'examen_fisico',       // Resultado del examen físico
        'pronostico',          // Pronóstico del paciente
        'plan',                // Plan de tratamiento
        'alergias'             // Alergias del paciente
    ];

    // Convertir signos vitales a un array  --- lo de la frec cardiaca, tempertura, etc por agrgar ahi
    protected $casts = [
        'signos_vitales' => 'array',
    ];

    // Relación con la tabla de citas
    public function cita()
    {
        // Una consulta pertenece a una cita
        return $this->belongsTo(Citas::class, 'cita_id');
    }

    // Relación con la tabla de servicios
    public function servicios()
    {
        // Una consulta puede tener muchos servicios
        return $this->belongsToMany(Servicio::class, 'consulta_servicio', 'consulta_id', 'servicio_id');
    }

    // Relación con la tabla de productos
    public function productos()
    {
        // Una consulta puede tener muchos productos
        return $this->belongsToMany(Productos::class, 'consulta_producto', 'consulta_id', 'producto_id');
    }
}
