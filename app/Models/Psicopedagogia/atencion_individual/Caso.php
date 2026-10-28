<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'init' => 'datetime',
        'canalizado' => 'boolean',
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
}