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
        'estado',
        'alcance',
        'evaluacion',
        'objetivos',
        'auditable',
        'repo',
        'pobl_obj_low',
        'pobl_obj_high',
    ];

    protected $appends = [
        'areas',
        'pobl_obj',
    ];

    public function getPoblObjAttribute()
    {
        if ($this->pobl_obj_low !== null && $this->pobl_obj_high !== null) {
            $high = $this->pobl_obj_high >= 60 ? '60+' : $this->pobl_obj_high;
            return "{$this->pobl_obj_low} – {$high} años";
        }
        return null;
    }

    public function getInvolucradosAttribute()
    {
        $ordenRoles = [
            'responsable_en_meneses' => 1,
            'docente'                => 2,
            'líder_comunitario'      => 3,
            'estudiante'             => 4,
            'voluntario'             => 5,
            'vecino'                 => 6,
            'institución'            => 7,
            'otro'                   => 8,
        ];

        $involucrados = collect();

        foreach ($this->rolesCentro as $centro) {
            $involucrados->push([
                'nombre' => $centro->nombre,
                'ap_pat' => $centro->ap_pat,
                'ap_mat' => $centro->ap_mat,
                'rol'    => $centro->pivot->rol,
                'otros'  => $centro->pivot->otros,
                'num'    => $ordenRoles[$centro->pivot->rol] ?? 99,
            ]);
        }

        foreach ($this->rolesComunidad as $comunidad) {
            $involucrados->push([
                'nombre' => $comunidad->nombre,
                'ap_pat' => $comunidad->ap_pat,
                'ap_mat' => $comunidad->ap_mat,
                'rol'    => $comunidad->pivot->rol,
                'otros'  => $comunidad->pivot->otros,
                'num'    => $ordenRoles[$comunidad->pivot->rol] ?? 99,
            ]);
        }

        foreach ($this->rolesExternos as $participacion) {
            $externo = $participacion->externo;

            $involucrados->push([
                'nombre' => $externo?->nombre,
                'ap_pat' => $externo?->ap_pat,
                'ap_mat' => $externo?->ap_mat,
                'rol'    => $participacion->pivot->rol,
                'otros'  => $participacion->pivot->otros,
                'num'    => $ordenRoles[$participacion->pivot->rol] ?? 99,
            ]);
        }

        foreach ($this->instituciones as $institucion) {
            $involucrados->push([
                'nombre' => $institucion->nombre,
                'ap_pat' => null,
                'ap_mat' => null,
                'rol'    => $institucion->pivot->rol,
                'otros'  => $institucion->pivot->otros,
                'num'    => $ordenRoles[$institucion->pivot->rol] ?? 99,
            ]);
        }

        return $involucrados->sortBy(function ($involucrado) use ($ordenRoles) {
            return $ordenRoles[$involucrado['rol']] ?? 99;
        })->values();
    }

    public function getAreasAttribute()
    {
        if(!$this->ejes()) return null;
        return $this->ejes
            ->flatMap->responsabilidades
            ->map->area
            ->filter()
            ->unique('id')
            ->sortBy('nombre')
            ->values();
    }

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
