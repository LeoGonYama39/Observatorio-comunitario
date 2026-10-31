<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Colonias;

use App\Models\EventoColonium;
use App\Models\HistorialColonium;
use App\Models\ListaOpciones\Problematica;
use App\Models\Personas\PComunidad;
use App\Models\ProblemColonium;
use App\Models\ProyectoColonium;
use App\Models\Proyectos\Proyecto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Colonia
 *
 * @property int $id
 * @property string $nombre
 * @property int|null $viviendas
 * @property int|null $adultos
 * @property int|null $ninos
 *
 * @property Collection|EventoColonium[] $evento_colonia
 * @property Collection|HistorialColonium[] $historial_colonia
 * @property Collection|PComunidad[] $p_comunidads
 * @property Collection|ProblemColonium[] $problem_colonia
 * @property Collection|ProyectoColonium[] $proyecto_colonia
 *
 * @package App\Models
 */
class Colonia extends Model
{
    protected $table = 'colonia';
    public $timestamps = false;

    protected $casts = [
        'viviendas' => 'int',
        'adultos' => 'int',
        'ninos' => 'int'
    ];

    protected $fillable = [
        'nombre',
        'viviendas',
        'adultos',
        'ninos'
    ];

    protected $appends = ['pob_total'];

    public function getPobTotalAttribute() {
        if((!$this->adultos) && (!$this->ninos)) return null;
        return $this->adultos + $this->ninos;
    }

    /*public function evento_colonia()
    {
        return $this->hasMany(EventoColonia::class, 'colonia_id');
    }*/

    public function historial_colonia()
    {
        return $this->hasMany(HistorialColonia::class, 'colonia_id');
    }

    public function p_comunidad()
    {
        return $this->hasMany(PComunidad::class, 'colonia_id');
    }

    //Para tablas intermedias
    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,    //Modelo a relacionar
            'proyecto_colonia', //Tabla a usar para la relación
            'colonia_id',       //FK del modelo actual
            'proyecto_id'       //FK del otro modelo
        );
    }

    public function problematicas()
    {
        return $this->belongsToMany(
            Problematica::class,   //Modelo a relacionar
            'problem_colonia',      //Tabla a usar para la relación
            'colonia_id',          //FK del modelo actual
            'problematica_id'       //FK del otro modelo
        );
    }

    //Para obtener el historial de la colonia, incluyendo el inicio y fin de proyectos
    //vinculados a esta colonia.
    public function getHistorialCompletoAttribute()
    {
        $eventos = collect();

        foreach ($this->historial_colonia as $h) {
            $eventos->push((object) [
                'historial_id'     => $h->id,
                'fecha_raw'        => $h->fecha,
                'fecha_formateada' => $h->fecha_formateada,
                'comentario'       => $h->comentario,
                'es_automatico'    => false,
            ]);
        }

        foreach ($this->proyectos as $proyecto) {
            if ($proyecto->fecha_inicio) {
                $eventos->push((object) [
                    'historial_id'     => null,
                    'fecha_raw'        => $proyecto->fecha_inicio,
                    'fecha_formateada' => $proyecto->fecha_form_inicio,
                    'comentario'       => "Inicio del proyecto: {$proyecto->nombre}",
                    'es_automatico'    => true,
                ]);
            }

            if ($proyecto->fecha_fin) {
                $eventos->push((object) [
                    'historial_id'     => null,
                    'fecha_raw'        => $proyecto->fecha_fin,
                    'fecha_formateada' => $proyecto->fecha_form_fin,
                    'comentario'       => "Finalización del proyecto: {$proyecto->nombre}",
                    'es_automatico'    => true,
                ]);
            }
        }

        // Ordenar por fecha descendente (de más reciente a más antiguo)
        return $eventos->sortByDesc(fn($item) => $item->fecha_raw?->timestamp ?? 0)->values();
    }
}
