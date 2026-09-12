<?php

namespace App\Models\Proyectos;

use App\Models\Areas\Eje;
use App\Models\listas\Problematica;
use Illuminate\Database\Eloquent\Model;
use App\Models\Colonia;
use Carbon\Carbon;

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
        'pobl_obj_low',
        'pobl_obj_high',
    ];

    protected $casts = [
        'prioritario' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    protected $appends = [
    'fecha_form_inicio',
    'fecha_form_fin',
    ];

    public function getFechaFormInicioAttribute()
    {
        if(!$this->fecha_inicio) return null;
        return $this->fecha_inicio
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

    public function getFechaFormFinAttribute()
    {
        if(!$this->fecha_fin) return null;
        return $this->fecha_fin
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

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
            Problematica::class,   //Modelo a relacionar
            'problematica_proyecto',//Tabla a usar para la relación
            'proyecto_id',          //FK del modelo actual
            'problematica_id'       //FK del otro modelo
        );
    }
}
