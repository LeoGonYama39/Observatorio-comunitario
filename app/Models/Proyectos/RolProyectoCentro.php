<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;
use App\Models\PCentro;

class RolProyectoCentro extends Model
{
    public $timestamps = false;
    protected $table = 'rol_proyecto_centro';

    protected $fillable = [
        'centro_id',      //[NN]
        'proyecto_id',   //[NN]
        'rol',              //[NN]
        'otros',
    ];

    public function centros()
    {
        return $this->belongsToMany(
            PCentro::class,
            'rol_taller_centro',
            'taller_id',
            'centro_id'
        )->withPivot('rol', 'otros');
    }
}