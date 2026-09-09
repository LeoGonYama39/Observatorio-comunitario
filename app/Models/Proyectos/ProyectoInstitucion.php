<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;

class ProyectoInstitucion extends Model
{
    public $timestamps = false;
    protected $table = 'proyecto_institucion';

    protected $fillable = [
        'proyecto_id',      //[NN]
        'institucion_id',   //[NN]
        'rol',              //[NN]
        'otros',
    ];
}