<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Areas;

use App\Models\PCentro;
use App\Models\PExterno;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Responsabilidad
 *
 * @property int $id
 * @property string $nombre
 * @property int $area_id
 * @property int $centro_id
 *
 * @property PCentro $p_centro
 * @property Area $area
 * @property Collection|PExterno[] $p_externos
 * @property Collection|Eje[] $ejes
 *
 * @package App\Models\Areas
 */
class Responsabilidad extends Model
{
	protected $table = 'responsabilidad';
	public $timestamps = false;

	protected $casts = [
		'area_id' => 'int',
		'centro_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'area_id',
		'centro_id'
	];

	public function p_centro()
	{
		return $this->belongsTo(PCentro::class, 'centro_id');
	}

	public function area()
	{
		return $this->belongsTo(Area::class);
	}

	public function p_externos()
	{
		return $this->hasMany(PExterno::class);
	}

	public function ejes()
	{
		return $this->belongsToMany(
            Eje::class,
            'responsabilidad_eje',
            'responsabilidad_id',
        'eje_id');
	}
}
