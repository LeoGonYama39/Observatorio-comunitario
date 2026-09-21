<?php

namespace App\Models\Talleres;

use Illuminate\Database\Eloquent\Model;
use App\Models\PCentro;
use App\Models\PExterno;
use App\Models\PComunidad;
use App\Models\Participacion;

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

    protected $appends = [
        'talleristas',
        'metricas',
        'activo',
    ];

    //----------------------
    //      Accesors
    //----------------------

    public function getActivoAttribute()
    {
        $ahora = \Carbon\Carbon::now();
        $anioActual = $ahora->year;
        $mesActual = $ahora->month;

        if ($this->anio < $anioActual) return false;
        if ($this->anio > $anioActual) return true;
        if ($this->temporada === 'primavera' && $mesActual > 6) return false;

        return true;
    }

    public function getTalleristasAttribute()
    {
        $talleristas = collect();

        foreach ($this->talleristasCentro as $centro) {
            $talleristas->push([
                'nombre'          => $centro->nombre,
                'ap_pat'          => $centro->ap_pat,
                'ap_mat'          => $centro->ap_mat,
                'nombre_completo' => trim("{$centro->nombre} {$centro->ap_pat} {$centro->ap_mat}"),
                'tipo'            => 'centro',
            ]);
        }

        foreach ($this->talleristasComunidad as $comunidad) {
            $talleristas->push([
                'nombre'          => $comunidad->nombre,
                'ap_pat'          => $comunidad->ap_pat,
                'ap_mat'          => $comunidad->ap_mat,
                'nombre_completo' => trim("{$comunidad->nombre} {$comunidad->ap_pat} {$comunidad->ap_mat}"),
                'tipo'            => 'comunidad',
            ]);
        }

        foreach ($this->talleristasExternos as $participacion) {
            $externo = ($participacion instanceof Participacion) ? $participacion->externo : $participacion;
            if ($externo) {
                $talleristas->push([
                    'nombre'          => $externo->nombre,
                    'ap_pat'          => $externo->ap_pat,
                    'ap_mat'          => $externo->ap_mat,
                    'nombre_completo' => trim("{$externo->nombre} {$externo->ap_pat} {$externo->ap_mat}"),
                    'tipo'            => 'externo',
                ]);
            }
        }

        return $talleristas;
    }

    public function getMetricasAttribute()
    {
        $participantes = $this->grupos;
        $total = $participantes->count();

        $genero = [
            'masculino'  => 0,
            'femenino'   => 0,
            'no_binario' => 0,
        ];

        $colonias = [];

        $rangosEdad = [
            '0-12'  => 0,
            '13-17' => 0,
            '18-29' => 0,
            '30-59' => 0,
            '+60'   => 0,
        ];

        $bajas = 0;

        foreach ($participantes as $p) {
            // Conteo por género
            if (isset($genero[$p->genero])) {
                $genero[$p->genero]++;
            }

            // Conteo por colonia (agrupando 'otros', null o 'otro')
            $nombreColonia = $p->colonia?->nombre;
            if (!$nombreColonia || in_array(strtolower($nombreColonia), ['otro', 'otros'])) {
                $nombreColonia = 'Otros';
            }
            $colonias[$nombreColonia] = ($colonias[$nombreColonia] ?? 0) + 1;

            // Conteo por rango de edad
            $edad = $p->edad;
            if ($edad !== null) {
                if ($edad <= 12) {
                    $rangosEdad['0-12']++;
                } elseif ($edad <= 17) {
                    $rangosEdad['13-17']++;
                } elseif ($edad <= 29) {
                    $rangosEdad['18-29']++;
                } elseif ($edad <= 59) {
                    $rangosEdad['30-59']++;
                } else {
                    $rangosEdad['+60']++;
                }
            }

            // Conteo de bajas
            if ((bool) $p->pivot->baja) {
                $bajas++;
            }
        }

        return [
            'total'       => $total,
            'genero'      => $genero,
            'colonias'    => $colonias,
            'rangos_edad' => $rangosEdad,
            'bajas'       => $bajas,
        ];
    }

    //----------------------
    //      Relaciones
    //----------------------

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
            Participacion::class,
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
