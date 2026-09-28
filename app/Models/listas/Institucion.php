<?php

namespace App\Models\listas;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    public $timestamps = false;
    protected $table = 'instituciones';

    protected $fillable = [
        'nombre',
    ];
}
