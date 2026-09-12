<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Areas;

use App\Models\Proyectos\Proyecto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Eje
 *
 * @property int $id
 * @property string|null $nombre
 *
 * @property Collection|Evento[] $eventos
 * @property Collection|Proyecto[] $proyectos
 * @property Collection|Responsabilidad[] $responsabilidads
 * @property Collection|Taller[] $tallers
 *
 * @package App\Models\Areas
 */
class Eje extends Model
{
	protected $table = 'eje';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	/*public function eventos()
	{
		return $this->belongsToMany(Evento::class, 'evento_eje');
	}*/

	public function proyectos()
	{
		return $this->belongsToMany(Proyecto::class, 'proyecto_eje');
	}

    public function responsabilidades()
    {
        return $this->belongsToMany(
            Eje::class,
            'responsabilidad_eje',
            'eje_id',
            'responsabilidad_id');
    }

	public function tallers()
	{
		return $this->belongsToMany(Taller::class, 'taller_eje');
	}
}
