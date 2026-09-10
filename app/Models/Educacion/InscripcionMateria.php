<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Model;
use App\Models\Educacion\Materia;
use App\Models\Educacion\InscripcionCurso;

/**
 * Class InscripcionMaterium
 * 
 * @property int $insc_curso_id
 * @property int $materia_id
 * @property bool $cursado
 * 
 * @property Materia $materia
 * @property InscripcionCurso $inscripcion_curso
 *
 * @package App\Models\Educacion
 */
class InscripcionMateria extends Model
{
	protected $table = 'inscripcion_materia';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'insc_curso_id' => 'int',
		'materia_id' => 'int',
		'cursado' => 'bool'
	];

	protected $fillable = [
		'insc_curso_id',
		'materia_id',
		'cursado',
	];

	public function materia()
	{
		return $this->belongsTo(Materia::class);
	}

	public function inscripcion_curso()
	{
		return $this->belongsTo(InscripcionCurso::class, 'insc_curso_id');
	}
}
