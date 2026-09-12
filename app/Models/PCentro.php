<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Areas\Area;
use App\Models\Areas\Responsabilidad;
use App\Models\Proyectos\RolProyectoCentro;
use App\Models\Talleres\RolTallerCentro;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class PCentro
 *
 * @property int $id
 * @property string $nombre
 * @property string $ap_pat
 * @property string|null $ap_mat
 * @property string|null $cargo
 * @property string|null $usuario
 * @property string|null $password
 * @property string|null $remember_token
 *
 * @property Collection|Area[] $areas
 * @property Collection|Responsabilidad[] $responsabilidads
 * @property Collection|RolEventoCentro[] $rol_evento_centros
 * @property Collection|RolProyectoCentro[] $rol_proyecto_centros
 * @property Collection|RolTallerCentro[] $rol_taller_centros
 * @property Collection|SeguimientoCentro[] $seguimiento_centros
 * @property Collection|TalleristaCentro[] $tallerista_centros
 * @property Collection|TalleristaProcGrupCentro[] $tallerista_proc_grup_centros
 *
 * @package App\Models
 */
class PCentro extends Authenticatable
{
	protected $table = 'p_centro';
	public $timestamps = false;

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nombre',
		'ap_pat',
		'ap_mat',
		'cargo',
		'usuario',
		'password',
		'remember_token'
	];

	public function areas()
	{
		return $this->hasMany(Area::class, 'centro_id');
	}

	public function responsabilidads()
	{
		return $this->hasMany(Responsabilidad::class, 'centro_id');
	}

	/*public function rol_evento_centros()
	{
		return $this->hasMany(RolEventoCentro::class, 'centro_id');
	}*/

	public function rol_proyecto_centros()
	{
		return $this->hasMany(RolProyectoCentro::class, 'centro_id');
	}

	public function rol_taller_centros()
	{
		return $this->hasMany(RolTallerCentro::class, 'centro_id');
	}

	/*public function seguimiento_centros()
	{
		return $this->hasMany(SeguimientoCentro::class, 'centro_id');
	}*/

	/*public function tallerista_centros()
	{
		return $this->hasMany(TalleristaCentro::class, 'centro_id');
	}*/

	/*public function tallerista_proc_grup_centros()
	{
		return $this->hasMany(TalleristaProcGrupCentro::class, 'centro_id');
	}*/
}
