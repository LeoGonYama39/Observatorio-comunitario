<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    public $timestamps = false;
    protected $table = 'colonia';

    protected $fillable = [
        'nombre',
        'viviendas',
        'adultos',
        'ninos',
        'poblacion_total',
    ];
}
