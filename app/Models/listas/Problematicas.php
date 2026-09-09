<?php

namespace App\Models\listas;

use Illuminate\Database\Eloquent\Model;

class Problematicas extends Model
{
    public $timestamps = false;
    protected $table = 'problematicas';

    protected $fillable = [
        'nombre',
    ];
}