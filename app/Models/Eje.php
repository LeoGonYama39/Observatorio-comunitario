<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Eje extends Model
{
    public $timestamps = false;
    protected $table = 'eje';

    protected $fillable = [
        'nombre',
    ];
}
