<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Areas\Responsabilidad;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class PExterno
 *
 * @property int $id
 * @property string $nombre
 * @property string $ap_pat
 * @property string|null $ap_mat
 * @property int|null $responsabilidad_id
 * @property string|null $universidad
 * @property string|null $correo
 * @property string|null $matricula
 * @property string|null $carrera
 * @property string|null $usuario
 * @property string|null $password
 * @property string|null $remember_token
 *
 * @property Responsabilidad|null $responsabilidad
 * @property Collection|Participacion[] $participaciones
 *
 * @package App\Models
 */
class PExterno extends Authenticatable
{
	protected $table = 'p_externo';
	public $timestamps = false;

	protected $casts = [
		'responsabilidad_id' => 'int'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nombre',
		'ap_pat',
		'ap_mat',
		'responsabilidad_id',
		'universidad',
		'correo',
		'matricula',
		'carrera',
		'usuario',
		'password',
	];

    protected $appends = [
        'tipo_categ',
        'tipo_formateado',
    ];


    //Genera la etiqueta para el dato de la tabla, para filtrar con js
    public function getTipoCategAttribute()
    {
        //Filtro para los que no tienen participaciones
        if (!$this->tipo) return 'sin_participación';

        //Filtro para los de las participaciones pasadas
        $ahora = Carbon::now();
        $anioActual = $ahora->year;
        $mesActual = $ahora->month;

        //Filtro anual
        if($this->anio < $anioActual) return 'no_activo';

        //Filtro de temporada
        if ($this->temporada === 'primavera' && $mesActual > 5) return 'no_activo';

        //Si la participación es activa
        return $this->tipo;
    }

    //Genera para la UI
    public function getTipoFormateadoAttribute()
    {
        //Reescribir para los que tienen una participación activa
        return ucfirst(str_replace('_', ' ', $this->tipo_categ));
    }

	public function responsabilidad()
	{
		return $this->belongsTo(Responsabilidad::class);
	}

	public function participaciones()
	{
		return $this->hasMany(Participacion::class, 'externo_id');
	}
}
