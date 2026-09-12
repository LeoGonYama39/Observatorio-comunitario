<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Talleres\RolTallerExterno;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Participacion
 *
 * @property int $id
 * @property int $externo_id
 * @property string $temporada
 * @property Carbon $anio
 * @property string|null $aport
 * @property string $tipo
 *
 * @property PExterno $p_externo
 * @property Collection|RolEventoExterno[] $rol_evento_externos
 * @property Collection|RolProyectoExterno[] $rol_proyecto_externos
 * @property Collection|RolTallerExterno[] $rol_taller_externos
 * @property Collection|SeguimientoExterno[] $seguimiento_externos
 * @property Collection|TalleristaExterno[] $tallerista_externos
 * @property Collection|TalleristaProcGrupExterno[] $tallerista_proc_grup_externos
 *
 * @package App\Models
 */
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
        'activo',];

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


    public function p_externo()
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
