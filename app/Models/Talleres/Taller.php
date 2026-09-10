<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eje;

class Taller extends Model
{
    public $timestamps = false;

    protected $table = 'taller';

    protected $fillable = [
        'nombre',
        'init',
        'estado',
        'alcance',
        'evaluacion',
        'objetivos',
        'auditable',
        'repo',
        'pobl_obj',
    ];

    protected $casts = [
        'init' => 'date',
    ];

    public function ejes()
    {
        return $this->belongsToMany(
            Eje::class,
            'taller_eje',
            'taller_id',
            'eje_id'
        );
    }

    public function generaciones()
    {
        return $this->hasMany(
            TallerGen::class,
            'taller_id'
        );
    }
}