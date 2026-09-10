<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Participaciones;

class RolProyectoExterno extends Model
{
    public $timestamps = false;
    protected $table = 'rol_proyecto_externo';

    protected $fillable = [
        'participacion_id',      //[NN]
        'proyecto_id',   //[NN]
        'rol',              //[NN]
        'otros',
    ];

    public function externos()
    {
        return $this->belongsToMany(
            Participaciones::class,
            'rol_taller_externo',
            'taller_id',
            'participacion_id'
        )->withPivot('rol', 'otros');
    }
}