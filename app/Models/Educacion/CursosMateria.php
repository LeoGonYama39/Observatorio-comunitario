<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Educacion;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CursosMateria
 * 
 * @property int $cursos_id
 * @property int $materias_id
 * 
 * @property Curso $curso
 * @property Materia $materia
 *
 * @package App\Models\Educacion
 */
class CursosMateria extends Model
{
	protected $table = 'cursos_materias';
	public $incrementing = false;
	public $timestamps = false;

	protected $fillable = [
		'cursos_id',
		'materias_id',
	];

	protected $casts = [
		'cursos_id' => 'int',
		'materias_id' => 'int'
	];

	public function curso()
	{
		return $this->belongsTo(Curso::class, 'cursos_id');
	}

	public function materia()
	{
		return $this->belongsTo(Materia::class, 'materias_id');
	}
}
