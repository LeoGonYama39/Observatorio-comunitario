<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Proyectos\Proyecto;
use App\Models\listas\Problematicas;

class Colonia extends Model
{
    public $timestamps = false;
    protected $table = 'colonia';

    protected $fillable = [
        'nombre',
        'viviendas',
        'adultos',
        'ninos',
    ];

    //Crear una nueva columna fake
    protected $appends = ['pob_total'];

    //Función para obtener la edad, con la fecha de nacimiento guardada
    public function getPobTotalAttribute() { return $this->adultos + $this->ninos; }


    //Para tablas intermedias 
    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,    //Modelo a relacionar
            'proyecto_colonia', //Tabla a usar para la relación
            'colonia_id',       //FK del modelo actual
            'proyecto_id'       //FK del otro modelo
        );
    }

    public function problematicas()
    {
        return $this->belongsToMany(
            Problematicas::class,   //Modelo a relacionar
            'problem_colonia',      //Tabla a usar para la relación
            'colonia_id',          //FK del modelo actual
            'problematica_id'       //FK del otro modelo
        );
    }
}
