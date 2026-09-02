<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PCentro extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'p_centro';

    protected $fillable = [
        'nombre', 'ap_pat', 'ap_mat', 'cargo', 'usuario', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}