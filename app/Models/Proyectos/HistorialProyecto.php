<?php

namespace App\Models\Proyectos;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class HistorialProyecto extends Model
{
    public $timestamps = false;
    protected $table = 'historial_proyecto';

    protected $fillable = [
        'proyecto_id',      //[NN]
        'fecha',            //[NN]
        'comentario',       //[NN]
    ];

    protected $appends = [
        'fecha_formateada',
    ];

    protected $casts = [
        'fecha' => 'datetime'
    ];

    public function getFechaFormateadaAttribute()
    {
        if(!$this->fecha) return null;
        return $this->fecha
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

    public function proyecto()
    {
        return $this->belongsTo(
            Proyecto::class,
            'proyecto_id'
        );
    }
}
