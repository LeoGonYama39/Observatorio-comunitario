<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\ListaOpciones;

use App\Models\Personas\PComunidad;
use Illuminate\Database\Eloquent\Model;

class Sustento extends Model
{
	protected $table = 'sustento';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    public function comunidades()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'comunidad_sustento',
            'sustento_id',
            'comunidad_id'
        );
    }
}
