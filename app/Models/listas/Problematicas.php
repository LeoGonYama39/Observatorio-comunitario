<?php

namespace App\Models\listas;

use Illuminate\Database\Eloquent\Model;
use App\Models\Proyectos\Proyecto;
use App\Models\Colonia;

class Problematicas extends Model
{
    public $timestamps = false;
    protected $table = 'problematicas';

    protected $fillable = [
        'nombre',
    ];


    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,        //Modelo a relacionar
            'problematica_proyecto',//Tabla a usar para la relación
            'problematica_id',      //FK del modelo actual
            'proyecto_id'           //FK del otro modelo
        );
    }

    public function colonias()
    {
        return $this->belongsToMany(
            Colonia::class,         //Modelo a relacionar
            'problem_colonia',      //Tabla a usar para la relación
            'problematica_id',      //FK del modelo actual
            'colonia_id'           //FK del otro modelo
        );
    }
}