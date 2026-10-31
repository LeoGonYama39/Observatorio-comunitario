<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\ListaOpciones;

use App\Models\Personas\PComunidad;
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
