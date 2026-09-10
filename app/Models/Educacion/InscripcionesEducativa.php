<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Educacion\PComunidad;
use App\Models\Educacion\InscripcionCurso;

/**
 * Class InscripcionesEducativa
 * 
 * @property int $id
 * @property int $comunidad_id
 * @property string|null $rfe
 * @property string|null $curp
 * @property string|null $matricula
 * 
 * @property PComunidad $p_comunidad
 * @property Collection|InscripcionCurso[] $inscripcion_cursos
 *
 * @package App\Models\Educacion
 */
class InscripcionesEducativa extends Model
{
	protected $table = 'inscripciones_educativas';
	public $timestamps = false;

	protected $casts = [
		'comunidad_id' => 'int'
	];

	protected $fillable = [
		'comunidad_id',
		'rfe',
		'curp',
		'matricula'
	];

	public function p_comunidad()
	{
		return $this->belongsTo(PComunidad::class, 'comunidad_id');
	}

	public function inscripcion_cursos()
	{
		return $this->hasMany(InscripcionCurso::class, 'insc_edu_id');
	}
}
