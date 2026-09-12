<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;
use App\Models\PCentro;
use App\Models\PExterno;
use App\Models\PComunidad;

class TallerGen extends Model
{
    public $timestamps = false;

    protected $table = 'taller_gen';

    protected $fillable = [
        'taller_id',
        'anio',
        'temporada',
        'evaluacion',
    ];

    public function taller()
    {
        return $this->belongsTo(
            Taller::class,
            'taller_id'
        );
    }

    public function talleristasCentro()
    {
        return $this->belongsToMany(
            PCentro::class,
            'tallerista_centro',
            'taller_gen_id',
            'centro_id'
        );
    }

    public function talleristasExternos()
    {
        return $this->belongsToMany(
            PExterno::class,
            'tallerista_externo',
            'taller_gen_id',
            'participacion_id'
        );
    }

    public function talleristasComunidad()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'tallerista_comunidad',
            'taller_gen_id',
            'comunidad_id'
        );
    }

    public function grupos()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'taller_grupos',
            'taller_gen_id',
            'comunidad_id'
        )->withPivot('baja');
    }
}
