<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\listas;

use App\Models\Colonia;
use App\Models\ProblemColonium;
use App\Models\Proyectos\Proyecto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Problematica
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Collection|ProblemColonia[] $problem_colonia
 * @property Collection|Proyecto[] $proyectos
 *
 * @package App\Models
 */
class Problematica extends Model
{
	protected $table = 'problematicas';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    public function proyectos()
    {
        return $this->belongsToMany(
            Proyecto::class,        //Modelo a relacionar
            'problematica_proyecto',//Tabla a usar para la relación
            'problematica_id',      //FK del modelo actual
            'proyecto_id'           //FK del otro modelo
        );
    }

    public function colonias()
    {
        return $this->belongsToMany(
            Colonia::class,         //Modelo a relacionar
            'problem_colonia',      //Tabla a usar para la relación
            'problematica_id',      //FK del modelo actual
            'colonia_id'           //FK del otro modelo
        );
    }
}
