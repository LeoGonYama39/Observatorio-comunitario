<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\PComunidad;

class Expediente extends Model
{
    protected $table = 'expediente';

    public $timestamps = false;

    protected $fillable = [
        'comunidad_id',
        'contacto_emergencia',
    ];

    public function comunidad(): BelongsTo
    {
        return $this->belongsTo(PComunidad::class, 'comunidad_id');
    }

    public function casos(): HasMany
    {
        return $this->hasMany(Caso::class, 'expediente_id');
    }

    public function tutores(): BelongsToMany
    {
        return $this->belongsToMany(
            PComunidad::class,
            'expediente_tutor',
            'expediente_id',
            'comunidad_id'
        )->withPivot('parentesco');
    }

    public function casoMasReciente(): HasOne
    {
        return $this->hasOne(Caso::class, 'expediente_id')
            ->latestOfMany('init');
    }

    //--------------------------------
    //          Getters
    //--------------------------------

    public function getParentescoNormalizadoAttribute(): ?string {
        $parentesco = $this->pivot?->parentesco;

        if (!$parentesco) return null;

        if ($this->genero === 'femenino') {
            return match ($parentesco) {
                'tio' => 'tía',
                'abuelo' => 'abuela',
                'hermano' => 'hermana',
                'madre' => 'madre',
                'padre' => 'padre',
                default => $parentesco,
            };
        }

        return $parentesco;
    }
}