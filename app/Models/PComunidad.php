<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PComunidad extends Model
{
    public $timestamps = false;
    protected $table = 'p_comunidad';
    
    protected $fillable = [
        'colonia_id',
        'nombre',
        'ap_pat',
        'ap_mat',
        'birth_date',
        'genero',
        'nv_escolar',
        'telefono',
        'lider',
        'saberes',
    ];
}
