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
        'estado'               
    ];

    protected $casts = [
        'signos_vitales' => 'array',
    ];

    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'consulta_servicio', 'consulta_id', 'servicio_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto', 'consulta_id', 'producto_id')->withPivot('cantidad');
    }
}
