<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;

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
}