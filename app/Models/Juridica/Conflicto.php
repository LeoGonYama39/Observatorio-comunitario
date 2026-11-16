<?php

namespace App\Models\Juridica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Conflicto extends Model
{
    protected $table = 'conflicto';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function asesorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Asesoria::class,
            'asesoria_conflicto',
            'conflicto_id',
            'asesoria_id'
        );
    }
}
