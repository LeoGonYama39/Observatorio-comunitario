<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Areas;

use App\Models\PCentro;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 *
 * @property int $id
 * @property string $nombre
 * @property int $centro_id
 *
 * @property PCentro $p_centro
 * @property Collection|Responsabilidad[] $responsabilidads
 *
 * @package App\Models\Areas
 */
class Area extends Model
{
	protected $table = 'area';
	public $timestamps = false;

	protected $casts = [
		'centro_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'centro_id'
	];

	public function p_centro()
	{
		return $this->belongsTo(PCentro::class, 'centro_id');
	}

	public function responsabilidades()
	{
		return $this->hasMany(Responsabilidad::class);
	}
}
