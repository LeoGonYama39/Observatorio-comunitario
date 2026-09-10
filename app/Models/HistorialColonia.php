<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistorialColonia extends Model
{
    public $timestamps = false;
    protected $table = 'historial_colonia';

    protected $fillable = [
        'colonia_id',
        'fecha',
        'comentario',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    protected $appends = [
    'fecha_formateada',
    ];

    public function getFechaFormateadaAttribute()
    {
        return $this->fecha
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }
}
