<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Area;
use App\Models\Proyectos\Proyecto;

class Eje extends Model
{
    public $timestamps = false;
    protected $table = 'eje';

    protected $fillable = [
        'nombre',
    ];

    
    public function areas()
    {
        return $this->belongsToMany(
            Area::class,    //Modelo a relacionar
            'area_eje',     //Tabla a usar para la relación
            'eje_id',       //FK del modelo actual
            'area_id'       //FK del otro modelo
        );
    }

    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,    //Modelo a relacionar
            'proyecto_eje',     //Tabla a usar para la relación
            'eje_id',           //FK del modelo actual
            'proyecto_id'       //FK del otro modelo
        );
    }
}
