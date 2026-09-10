<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Educacion\Curso;
use App\Models\Educacion\InscripcionMateria;

/**
 * Class Materia
 * 
 * @property int $id
 * @property string $nombre
 * 
 * @property Collection|Curso[] $cursos
 * @property Collection|InscripcionMateria[] $inscripcion_materia
 *
 * @package App\Models\Educacion
 */
class Materia extends Model
{
	protected $table = 'materias';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function cursos()
	{
		return $this->belongsToMany(Curso::class, 'cursos_materias', 'materias_id', 'cursos_id');
	}

	public function inscripcion_materia()
	{
		return $this->hasMany(InscripcionMateria::class);
	}
}
