<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\listas;

use App\Models\PComunidad;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Difucion extends Model
{
	protected $table = 'difucion';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    public function comunidades()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'comunidad_difucion',
            'difucion_id',
            'comunidad_id'
        );
    }
}
