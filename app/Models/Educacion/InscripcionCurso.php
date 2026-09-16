<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Educacion;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Educacion\InscripcionEducativa;
use App\Models\Educacion\Curso;
use App\Models\Educacion\InscripcionMateria;

/**
 * Class InscripcionCurso
 *
 * @property int $id
 * @property int $insc_edu_id
 * @property int $cursos_id
 * @property Carbon $fecha_ingreso
 * @property string $estado
 *
 * @property InscripcionEducativa $inscripciones_educativa
 * @property Curso $curso
 * @property Collection|InscripcionMaterium[] $inscripcion_materia
 *
 * @package App\Models\Educacion
 */
class InscripcionCurso extends Model
{
	protected $table = 'inscripcion_curso';
	public $timestamps = false;

	protected $casts = [
		'insc_edu_id' => 'int',
		'cursos_id' => 'int',
		'fecha_ingreso' => 'datetime'
	];

	protected $fillable = [
		'insc_edu_id',
		'cursos_id',
		'fecha_ingreso',
		'estado',
        'anio',
        'temporada',
	];

    protected $appends = [
        'fecha_formateada',
    ];

    public function getFechaFormateadaAttribute()
    {
        if(!$this->fecha_ingreso) return null;
        return $this->fecha_ingreso
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

	public function inscripciones_educativa()
	{
		return $this->belongsTo(InscripcionEducativa::class, 'insc_edu_id');
	}

	public function curso()
	{
		return $this->belongsTo(Curso::class, 'cursos_id');
	}

    public function materias()
    {
        return $this->belongsToMany(
            Materia::class,
            'inscripcion_materia',
            'insc_curso_id',
            'materia_id'
        )->withPivot('cursado');
    }
}
