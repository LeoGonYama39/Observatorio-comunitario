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
        'ultima_participacion'
    ];


    public function getUltimaParticipacionAttribute()
    {
        return $this->participaciones()
            ->orderByDesc('anio')
            ->orderByDesc('temporada')
            ->first();
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
