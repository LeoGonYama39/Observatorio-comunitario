<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Participaciones extends Model
{
    public $timestamps = false;
    protected $table = 'participaciones';

    protected $fillable = [
        'externo_id',
        'temporada',
        'anio',
        'aport',
        'tipo',
    ];

    protected $appends = [
        'activo',];

    //Calcula si la participación es activa
    public function getActivoAttribute()
    {
        //Filtro para los de las participaciones pasadas
        $ahora = Carbon::now();
        $anioActual = $ahora->year;
        $mesActual = $ahora->month;

        //Filtro anual
        if($this->anio < $anioActual) return false;
        
        //Filtro de temporada
        if ($this->temporada === 'primavera' && $mesActual > 5) return false;

        //Si la participación es activa
        return true;
    }

}
