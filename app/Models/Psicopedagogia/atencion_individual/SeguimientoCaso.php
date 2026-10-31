<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use App\Models\Personas\Participacion;
use App\Models\Personas\PCentro;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'fecha' => 'date',
    ];

    protected $appends = [
        'fecha_formateada',
        'atendieron',
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

    //------------------------------
    //              Getters
    //------------------------------
    public function getFechaFormateadaAttribute(): ?string {
        if(!$this->fecha) return null;
        return $this->fecha
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }

    public function getAtendieronAttribute(): array {
        $centros = $this->centros()
            ->get()
            ->map(fn ($centro) => [
                'id' => $centro->id,
                'nombre' => $centro->nombre,
                'ap_pat' => $centro->ap_pat,
                'ap_mat' => $centro->ap_mat,
                'tipo' => 'centro',
            ]);

        $externos = $this->participaciones()
            ->with('externo')
            ->get()
            ->map(fn ($participacion) => [
                'id' => $participacion->id,
                'nombre' => $participacion->externo->nombre ?? null,
                'ap_pat' => $participacion->externo->ap_pat ?? null,
                'ap_mat' => $participacion->externo->ap_mat ?? null,
                'tipo' => 'externo',
            ]);

        return $centros->concat($externos)->values()->all();
    }
}
