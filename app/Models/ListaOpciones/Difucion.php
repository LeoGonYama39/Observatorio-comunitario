<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\ListaOpciones;

use App\Models\Personas\PComunidad;
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
