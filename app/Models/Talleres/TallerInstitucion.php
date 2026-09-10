<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institucion;

class TallerInstitucion extends Model
{
    public $timestamps = false;

    protected $table = 'taller_institucion';

    protected $fillable = [
        'taller_id',
        'institucion_id',
        'rol',
        'otros',
    ];
}