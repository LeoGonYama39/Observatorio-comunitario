<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\ListaOpciones;

use App\Models\Personas\PComunidad;
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
