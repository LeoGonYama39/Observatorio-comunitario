<?php

namespace App\Models\Proyectos;

use App\Models\Areas\Eje;
use App\Models\listas\Instituciones;
use App\Models\listas\Problematica;
use App\Models\Participacion;
use App\Models\PCentro;
use App\Models\PComunidad;
use Illuminate\Database\Eloquent\Model;
use App\Models\Colonia;
use Carbon\Carbon;

class Proyecto extends Model
{
    public $timestamps = false;
    protected $table = 'proyecto';

    protected $fillable = [
        'nombre',           //[NN]
        'fecha_inicio',     //[NN]
        'fecha_fin',
        'antecedentes',
        'objetivos',
        'repo',
        'prioritario',
        'alcance',
        'evaluacion',
        'estado',           //[NN]
        'auditable',
        'pobl_obj_low',
        'pobl_obj_high',
    ];

    protected $casts = [
        'prioritario' => 'boolean',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
    ];

    protected $appends = [
        'fecha_form_inicio',
        'fecha_form_fin',
        'areas',
        'pobl_obj'
    ];
    public function getPoblObjAttribute() {
        if ($this->pobl_obj_low !== null && $this->pobl_obj_high !== null) {
            $high = $this->pobl_obj_high >= 60 ? '60+' : $this->pobl_obj_high;
            return "{$this->pobl_obj_low} – {$high} años";
        }
        return null;
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

    public function getFechaFormInicioAttribute()
    {
        if(!$this->fecha_inicio) return null;
        return $this->fecha_inicio
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

    public function getFechaFormFinAttribute()
    {
        if(!$this->fecha_fin) return null;
        return $this->fecha_fin
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

    //Buscar todos los involucrados en un Proyecto, en un solo collect
    public function getInvolucradosAttribute()
    {
        $ordenRoles = [
            'responsable_en_meneses' => 1,
            'docente' => 2,
            'líder_comunitario' => 3,
            'institución' => 4,
            'otro' => 5,
        ];

        $involucrados = collect();

        foreach ($this->rolesCentro as $centro) {
            $involucrados->push([
                'nombre' => $centro->nombre,
                'ap_pat' => $centro->ap_pat,
                'ap_mat' => $centro->ap_mat,
                'rol' => $centro->pivot->rol,
                'otros' => $centro->pivot->otros,
                'num' => $ordenRoles[$centro->pivot->rol] ?? 99,
            ]);
        }

        foreach ($this->rolesComunidad as $comunidad) {
            $involucrados->push([
                'nombre' => $comunidad->nombre,
                'ap_pat' => $comunidad->ap_pat,
                'ap_mat' => $comunidad->ap_mat,
                'rol' => $comunidad->pivot->rol,
                'otros' => $comunidad->pivot->otros,
                'num' => $ordenRoles[$comunidad->pivot->rol] ?? 99,
            ]);
        }

        foreach ($this->rolesExternos as $participacion) {
            $externo = $participacion->externo;

            $involucrados->push([
                'nombre' => $externo->nombre,
                'ap_pat' => $externo->ap_pat,
                'ap_mat' => $externo->ap_mat,
                'rol' => $participacion->pivot->rol,
                'otros' => $participacion->pivot->otros,
                'num' => $ordenRoles[$participacion->pivot->rol] ?? 99,
            ]);
        }

        foreach ($this->instituciones as $institucion) {
            $involucrados->push([
                'nombre' => $institucion->nombre,
                'ap_pat' => null,
                'ap_mat' => null,
                'rol' => $institucion->pivot->rol,
                'otros' => $institucion->pivot->otros,
                'num' => $ordenRoles[$institucion->pivot->rol] ?? 99,
            ]);
        }

        return $involucrados->sortBy(function ($involucrado) use ($ordenRoles) {
            return $ordenRoles[$involucrado['rol']] ?? 99;
        });
    }

    //----------------------
    //      Relaciones
    //----------------------

    public function ejes()
    {
        return $this->belongsToMany(
            Eje::class,     //Modelo a relacionar
            'proyecto_eje', //Tabla a usar para la relación
            'proyecto_id',  //FK del modelo actual
            'eje_id'        //FK del otro modelo
        );
    }

    public function colonias()
    {
        return $this->belongsToMany(
            Colonia::class,     //Modelo a relacionar
            'proyecto_colonia', //Tabla a usar para la relación
            'proyecto_id',      //FK del modelo actual
            'colonia_id'        //FK del otro modelo
        );
    }

    public function historial()
    {
        return $this->hasMany(
            HistorialProyecto::class,
            'proyecto_id'
        );
    }

    public function problematicas()
    {
        return $this->belongsToMany(
            Problematica::class,   //Modelo a relacionar
            'problematica_proyecto',//Tabla a usar para la relación
            'proyecto_id',          //FK del modelo actual
            'problematica_id'       //FK del otro modelo
        );
    }

    public function instituciones()
    {
        return $this->belongsToMany(
            Instituciones::class,
            'proyecto_institucion',
            'proyecto_id',
            'institucion_id'
        )->withPivot('rol', 'otros');
    }

    public function rolesCentro()
    {
        return $this->belongsToMany(
            PCentro::class,
            'rol_proyecto_centro',
            'proyecto_id',
            'centro_id'
        )->withPivot('rol', 'otros');
    }

    public function rolesComunidad()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'rol_proyecto_comunidad',
            'proyecto_id',
            'comunidad_id'
        )->withPivot('rol', 'otros');
    }

    public function rolesExternos()
    {
        return $this->belongsToMany(
            Participacion::class,
            'rol_proyecto_externo',
            'proyecto_id',
            'participacion_id'
        )->withPivot('rol', 'otros');
    }
}
