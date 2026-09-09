<?php

namespace App\Models\listas;

use Illuminate\Database\Eloquent\Model;
use App\Models\Proyectos\Proyecto;

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
}