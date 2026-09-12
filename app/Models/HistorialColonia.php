<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class HistorialColonium
 *
 * @property int $id
 * @property int $colonia_id
 * @property Carbon $fecha
 * @property string $comentario
 *
 * @property Colonium $colonium
 *
 * @package App\Models
 */
class HistorialColonia extends Model
{
    protected $table = 'historial_colonia';
    public $timestamps = false;

    protected $casts = [
        'colonia_id' => 'int',
        'fecha' => 'datetime'
    ];

    protected $fillable = [
        'colonia_id',
        'fecha',
        'comentario'
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

    public function Colonia()
    {
        return $this->belongsTo(Colonia::class, 'colonia_id');
    }
}
