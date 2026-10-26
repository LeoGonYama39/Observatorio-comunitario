<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Areas\Area;
use App\Models\Areas\Responsabilidad;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PCentro extends Authenticatable
{
	protected $table = 'p_centro';
	public $timestamps = false;

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'nombre',
		'ap_pat',
		'ap_mat',
		'cargo',
		'usuario',
		'password',
		'remember_token'
	];

    protected $appends = [
        'a_cargo_de',
        'areas_ids',];

    //----------------------------
    //      Getters de appends
    //----------------------------

    public function getACargoDeAttribute()
    {
        //Con isEmpty y no !, porque siempre resgresa una Collection, puede estar vacía, pero no es null
        if ($this->areas->isEmpty() && $this->responsabilidades->isEmpty()) {
            return null;
        }

        $areas = $this->areas
            ->pluck('nombre')
            ->join(' · ');

        $responsabilidades = $this->responsabilidades
            ->pluck('nombre')
            ->join(' · ');

        return collect([
            $areas,
            $responsabilidades,
        ])->filter()->join(' · ');
    }

    public function getAreasIdsAttribute()
    {
        $areas = $this->areas->map(fn($a) => 'a_' . $a->id);
        $responsabilidades = $this->responsabilidades->map(fn($r) => 'r_' . $r->id);

        $todos = $areas->toBase()->concat($responsabilidades);

        return $todos->isEmpty() ? '-' : $todos->join(',');
    }

    //----------------------------
    //      Relaciones
    //----------------------------
	public function areas()
	{
		return $this->hasMany(Area::class, 'centro_id');
	}

	public function responsabilidades()
	{
		return $this->hasMany(Responsabilidad::class, 'centro_id');
	}

}
