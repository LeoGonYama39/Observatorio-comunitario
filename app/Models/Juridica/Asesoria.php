<?php

namespace App\Models\Juridica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asesoria extends Model
{
    protected $table = 'asesoria';

    public $timestamps = false;

    protected $fillable = [
        'temporada',
        'init',
        'estado',
    ];

    protected $casts = [
        'init' => 'date',
    ];

    // Modalidad individual
    public function juridica(): HasOne
    {
        return $this->hasOne(AJuridica::class, 'asesoria_id');
    }

    // Modalidad familiar
    public function familiar(): HasOne
    {
        return $this->hasOne(AFamiliar::class, 'asesoria_id');
    }

    // Personas involucradas
    public function involucrados(): HasMany
    {
        return $this->hasMany(InvolucradoAsesoria::class, 'asesoria_id');
    }

    // Conflictos asociados
    public function conflictos(): BelongsToMany
    {
        return $this->belongsToMany(
            Conflicto::class,
            'asesoria_conflicto',
            'asesoria_id',
            'conflicto_id'
        );
    }

    // Ramas del derecho asociadas
    public function ramas(): BelongsToMany
    {
        return $this->belongsToMany(
            Rama::class,
            'asesoria_rama',
            'asesoria_id',
            'rama_id'
        );
    }
}
