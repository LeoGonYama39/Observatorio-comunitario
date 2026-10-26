<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Areas;

use App\Models\Proyectos\Proyecto;
use App\Models\Talleres\Taller;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Eje extends Model
{
	protected $table = 'eje';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

    protected $appends = [
      'responsabilidades_formato',
      'responsabilidades_ids',
    ];

	public function proyectos()
	{
		return $this->belongsToMany(Proyecto::class, 'proyecto_eje');
	}

    public function responsabilidades()
    {
        return $this->belongsToMany(
            Responsabilidad::class,
            'responsabilidad_eje',
            'eje_id',
            'responsabilidad_id'
        );
    }

    public function getResponsabilidadesFormatoAttribute()
    {
        if(!$this->responsabilidades()->count()) return null;
        return $this->responsabilidades
            ->pluck('nombre')
            ->implode(' · ');
    }

    public function getResponsabilidadesIdsAttribute()
    {
        $responsabilidades = $this->responsabilidades->pluck('id');
        return $responsabilidades->isEmpty() ? '-' : $responsabilidades->join(',');
    }

	public function talleres()
	{
		return $this->belongsToMany(Taller::class, 'taller_eje');
	}
}
