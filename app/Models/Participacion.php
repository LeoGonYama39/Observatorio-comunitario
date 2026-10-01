<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Participacion extends Model
{
	protected $table = 'participaciones';
	public $timestamps = false;

	protected $casts = [
		'externo_id' => 'int',
	];

	protected $fillable = [
		'externo_id',
		'temporada',
		'anio',
		'aport',
		'tipo'
	];

    protected $appends = [
        'activo',
        'tipo_categ',
        'tipo_formateado',];

    //Calcula si la participación es activa
    public function getActivoAttribute()
    {
        //Filtro para los de las participaciones pasadas
        $ahora = Carbon::now();
        $anioActual = $ahora->year;
        $mesActual = $ahora->month;

        //Filtro anual
        if($this->anio < $anioActual) return false;

        //Filtro de temporada
        if ($this->temporada === 'primavera' && $mesActual > 5) return false;

        //Si la participación es activa
        return true;
    }

    public function getTipoCategAttribute()
    {
        //Filtro para los que no tienen participaciones
        if (!$this->tipo) return 'sin_participación';
        return $this->activo ? $this->tipo : 'no_activo';
    }

    public function getTipoFormateadoAttribute()
    {
        //Reescribir para los que tienen una participación activa
        return ucfirst(str_replace('_', ' ', $this->tipo_categ));
    }

    public function externo()
	{
		return $this->belongsTo(PExterno::class, 'externo_id');
	}

	/*public function rol_evento_externos()
	{
		return $this->hasMany(RolEventoExterno::class, 'participacion_id');
	}*/

	/*public function rol_proyecto_externos()
	{
		return $this->hasMany(RolProyectoExterno::class, 'participacion_id');
	}*/

	public function rol_taller_externos()
	{
		return $this->hasMany(RolTallerExterno::class, 'participacion_id');
	}

	/*public function seguimiento_externos()
	{
		return $this->hasMany(SeguimientoExterno::class, 'participacion_id');
	}*/

	/*public function tallerista_externos()
	{
		return $this->hasMany(TalleristaExterno::class, 'participacion_id');
	}*/

	/*public function tallerista_proc_grup_externos()
	{
		return $this->hasMany(TalleristaProcGrupExterno::class, 'participacion_id');
	}*/
}
