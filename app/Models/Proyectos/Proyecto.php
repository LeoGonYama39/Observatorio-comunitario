<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eje;
use App\Models\Colonia;
use App\Models\listas\Problematicas;

class Proyecto extends Model
{
    public $timestamps = false;
    protected $table = 'proyecto';

    protected $fillable = [
        'nombre',           //[NN]
        'fecha_inicio',     //[NN]
        'fecha_fin',
        'antecedentes',
        'objetivos',
        'repo',
        'prioritario',
        'alcance',
        'evaluacion',
        'estado',           //[NN]
        'auditable',
        'pobl_obj',
    ];

    protected $casts = [
        'prioritario' => 'boolean',
    ];

    public function ejes()
    {
        return $this->belongsToMany(
            Eje::class,     //Modelo a relacionar
            'proyecto_eje', //Tabla a usar para la relación
            'proyecto_id',  //FK del modelo actual
            'eje_id'        //FK del otro modelo
        );
    }

    public function colonias()
    {
        return $this->belongsToMany(
            Colonia::class,     //Modelo a relacionar
            'proyecto_colonia', //Tabla a usar para la relación
            'proyecto_id',      //FK del modelo actual
            'colonia_id'        //FK del otro modelo
        );
    }

    public function problematicas()
    {
        return $this->belongsToMany(
            Problematicas::class,   //Modelo a relacionar
            'problematica_proyecto',//Tabla a usar para la relación
            'proyecto_id',          //FK del modelo actual
            'problematica_id'       //FK del otro modelo
        );
    }
}
