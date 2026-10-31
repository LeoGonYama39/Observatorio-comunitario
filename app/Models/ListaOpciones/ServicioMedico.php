<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\ListaOpciones;

use App\Models\Personas\PComunidad;
use Illuminate\Database\Eloquent\Model;

class ServicioMedico extends Model
{
	protected $table = 'servicio_medico';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    public function comunidades()
    {
        return $this->belongsToMany(
            PComunidad::class,
            'comunidad_servicio_medico',
            'servicio_medico_id',
            'comunidad_id'
        );
    }
}
