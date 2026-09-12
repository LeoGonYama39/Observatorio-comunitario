<?php

namespace App\Models\Talleres;

use App\Models\Areas\Eje;
use App\Models\listas\Instituciones;
use App\Models\Participacion;
use App\Models\PCentro;
use App\Models\PComunidad;
use Illuminate\Database\Eloquent\Model;

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
        'pobl_obj_low',
        'pobl_obj_high',
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

    public function instituciones()
    {
        return $this->belongsToMany(
            Instituciones::class,
            'taller_institucion',
            'taller_id',
            'institucion_id'
        )->withPivot('rol', 'otros');
    }

    public function rolesExternos()
    {
        return $this->belongsToMany(
            Participacion::class,
            'rol_taller_externo',
            'taller_id',
            'participacion_id'
        )->withPivot('rol', 'otros');
    }

    public function rolesComunidad()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'rol_taller_comunidad',
            'taller_id',
            'comunidad_id'
        )->withPivot('rol', 'otros');
    }

    public function rolesCentro()
    {
        return $this->belongsToMany(
            PCentro::class,
            'rol_taller_centro',
            'taller_id',
            'centro_id'
        )->withPivot('rol', 'otros');
    }
}
