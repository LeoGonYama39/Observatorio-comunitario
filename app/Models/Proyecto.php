<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
