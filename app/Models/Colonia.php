<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\listas\Problematica;
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
}
