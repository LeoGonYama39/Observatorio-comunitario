<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;

class RolProyectoCentro extends Model
{
    public $timestamps = false;
    protected $table = 'rol_proyecto_centro';

    protected $fillable = [
        'centro_id',      //[NN]
        'proyecto_id',   //[NN]
        'rol',              //[NN]
        'otros',
    ];
}