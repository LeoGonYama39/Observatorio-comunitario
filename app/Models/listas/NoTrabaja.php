<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\listas;

use App\Models\PComunidad;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class NoTrabaja extends Model
{
	protected $table = 'no_trabaja';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    public function comunidades()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'comunidad_no_trabaja',
            'no_trabaja_id',
            'comunidad_id'
        );
    }
}
