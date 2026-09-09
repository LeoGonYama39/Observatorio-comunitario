<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;

class HistorialProyecto extends Model
{
    public $timestamps = false;
    protected $table = 'historial_proyecto';

    protected $fillable = [
        'proyecto_id',      //[NN]
        'fecha',            //[NN]
        'comentario',       //[NN]
    ];
}