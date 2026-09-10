<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;

class RolTallerCentro extends Model
{
    public $timestamps = false;

    protected $table = 'rol_taller_centro';

    protected $fillable = [
        'taller_id',
        'centro_id',
        'rol',
        'otros',
    ];
}