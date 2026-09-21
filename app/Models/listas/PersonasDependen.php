<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\listas;

use App\Models\PComunidad;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PersonasDependen extends Model
{
	protected $table = 'personas_dependen';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    public function comunidades()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'comunidad_personas_dependen',
            'personas_dependen_id',
            'comunidad_id'
        );
    }
}
