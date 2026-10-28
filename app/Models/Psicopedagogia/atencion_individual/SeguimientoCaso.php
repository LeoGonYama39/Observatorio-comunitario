<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\PCentro;
use App\Models\Participacion;

class SeguimientoCaso extends Model
{
    protected $table = 'seguimiento_caso';

    public $timestamps = false;

    protected $fillable = [
        'caso_id',
        'fecha',
        'nota',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function caso(): BelongsTo
    {
        return $this->belongsTo(Caso::class, 'caso_id');
    }

    public function centros(): BelongsToMany
    {
        return $this->belongsToMany(
            PCentro::class,
            'seguimiento_centro',
            'seguimiento_caso_id',
            'centro_id'
        );
    }

    public function participaciones(): BelongsToMany
    {
        return $this->belongsToMany(
            Participacion::class,
            'seguimiento_externo',
            'seguimiento_caso_id',
            'participacion_id'
        );
    }
}