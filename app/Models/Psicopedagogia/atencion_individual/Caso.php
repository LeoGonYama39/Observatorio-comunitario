<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Caso extends Model
{
    protected $table = 'caso';

    public $timestamps = false;

    protected $fillable = [
        'expediente_id',
        'init',
        'temporada',
        'tipo',
        'estado',
        'peticion',
        'canalizado',
        'canalizado_site',
    ];

    protected $casts = [
        'init' => 'date',
        'canalizado' => 'boolean',
    ];

    protected $appends = [
        'fecha_formateada',
    ];

    public function expediente(): BelongsTo
    {
        return $this->belongsTo(Expediente::class, 'expediente_id');
    }

    public function seguimientos(): HasMany
    {
        return $this->hasMany(SeguimientoCaso::class, 'caso_id');
    }

    public function motivos(): BelongsToMany
    {
        return $this->belongsToMany(
            ListPadecCaso::class,
            'caso_motivo',
            'caso_id',
            'padec_caso_id'
        );
    }

    //----------------------------------
    //          Getters
    //----------------------------------

    public function seguimientoMasReciente(): HasOne
    {
        return $this->hasOne(SeguimientoCaso::class, 'caso_id')
            ->latestOfMany('fecha');
    }

    public function getFechaFormateadaAttribute(): ?string {
        if(!$this->init) return null;
        return $this->init
            ->locale('es')
            ->translatedFormat('j \d\e F \d\e Y');
    }
}