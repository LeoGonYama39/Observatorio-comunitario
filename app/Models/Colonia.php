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
    ];

    //Crear una nueva columna fake
    protected $appends = ['pob_total'];

    //Función para obtener la edad, con la fecha de nacimiento guardada
    public function getPobTotalAttribute() { return $this->adultos + $this->ninos; }
}
