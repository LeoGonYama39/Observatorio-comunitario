<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;

class RolTallerExterno extends Model
{
    public $timestamps = false;

    protected $table = 'rol_taller_externo';

    protected $fillable = [
        'taller_id',
        'participacion_id',
        'rol',
        'otros',
    ];
}