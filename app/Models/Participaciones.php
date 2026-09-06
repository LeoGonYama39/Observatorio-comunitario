<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participaciones extends Model
{
    public $timestamps = false;
    protected $table = 'participaciones';

    protected $fillable = [
        'externo_id',
        'periodo',
        'aport',
        'tipo',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
