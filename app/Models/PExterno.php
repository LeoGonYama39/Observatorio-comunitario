<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class PExterno extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'p_externo';

    protected $fillable = [
        'nombre',
        'ap_pat',
        'ap_mat',
        'universidad',
        'correo',
        'matricula',
        'carrera',
        'usuario',
        'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['tipo_formateado'];

    public function getTipoFormateadoAttribute()
    {
        //Filtro para los que no tienen participaciones
        if (!$this->tipo) return 'Sin participaciones';

        //Filtro para los de las participaciones pasadas
        $ahora = Carbon::now();
        $anioActual = $ahora->year;
        $mesActual = $ahora->month;

        //Filtro anual
        if($this->anio < $anioActual) return 'No activo';
        
        //Filtro de temporada
        if ($this->temporada === 'primavera' && $mesActual > 5) return 'No activo mes';

        //Reescribir para los que tienen una participación activa
        return ucfirst(str_replace('_', ' ', $this->tipo));
    }
}