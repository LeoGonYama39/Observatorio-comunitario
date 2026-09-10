<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Educacion\Materia;
use App\Models\Educacion\InscripcionCurso;

/**
 * Class Curso
 * 
 * @property int $id
 * @property string $nombre
 * @property string $tipo
 * 
 * @property Collection|Materia[] $materias
 * @property Collection|InscripcionCurso[] $inscripcion_cursos
 *
 * @package App\Models\Educacion
 */
class Curso extends Model
{
	protected $table = 'cursos';
	public $timestamps = false;

	protected $fillable = [
		'nombre',
		'tipo'
	];

	public function materias()
	{
		return $this->belongsToMany(Materia::class, 'cursos_materias', 'cursos_id', 'materias_id');
	}

	public function inscripcion_cursos()
	{
		return $this->hasMany(InscripcionCurso::class, 'cursos_id');
	}
}
