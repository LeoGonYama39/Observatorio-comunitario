<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PExterno extends Authenticatable
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'p_externo';

    protected $fillable = [
        'nombre', 'ap_pat', 'ap_mat', 'universidad', 'usuario', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}