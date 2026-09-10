<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;

class RolTallerComunidad extends Model
{
    public $timestamps = false;

    protected $table = 'rol_taller_comunidad';

    protected $fillable = [
        'taller_id',
        'comunidad_id',
        'rol',
        'otros',
    ];
}