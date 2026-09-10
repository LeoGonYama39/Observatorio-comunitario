<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Talleres\TallerGen;
use App\Models\Talleres\Taller;

class PCentro extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'p_centro';

    protected $fillable = [
        'nombre',
        'ap_pat',
        'ap_mat',
        'cargo',
        'usuario',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function talleresComoTallerista()
    {
        return $this->belongsToMany(
            TallerGen::class,
            'tallerista_centro',
            'centro_id',
            'taller_gen_id'
        );
    }

    public function talleres()
    {
        return $this->belongsToMany(
            Taller::class,
            'rol_taller_centro',
            'centro_id',
            'taller_id'
        )->withPivot('rol', 'otros');
    }
}