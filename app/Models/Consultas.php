<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_id',             
        'diagnostico',         
        'recete',              
        'totalPagar',          
        'usuariomedicoid',     
        'signos_vitales',      
        'motivo_consulta',     
        'notas_padecimiento',  
        'examen_fisico',       
        'pronostico',          
        'plan',                
        'alergias',            
        'estado',              
        'enfermera_id', 
    ];

    protected $casts = [
        'signos_vitales' => 'array',
    ];

    // Relación con la tabla 'Citas'
    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id');
    }

    // Relación con la tabla 'Servicio'
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'consulta_servicio', 'consulta_id', 'servicio_id');
    }

    // Relación con la tabla 'Productos'
    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto', 'consulta_id', 'producto_id')->withPivot('cantidad');
    }

    // Relación con la tabla 'User' para el médico
    public function medico()
    {
        return $this->belongsTo(User::class, 'usuariomedicoid');
    }

    // Relación con la tabla 'User' para la enfermera
    public function enfermera()
    {
        return $this->belongsTo(User::class, 'enfermera_id');
    }
}
