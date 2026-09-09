<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;

class RolProyectoComunidad extends Model
{
    public $timestamps = false;
    protected $table = 'rol_proyecto_comunidad';

    protected $fillable = [
        'comunidad_id',      //[NN]
        'proyecto_id',   //[NN]
        'rol',              //[NN]
        'otros',
    ];
}