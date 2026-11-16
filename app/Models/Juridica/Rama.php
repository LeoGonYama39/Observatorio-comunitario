<?php

namespace App\Models\Juridica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rama extends Model
{
    protected $table = 'rama';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function asesorias(): BelongsToMany
    {
        return $this->belongsToMany(
            Asesoria::class,
            'asesoria_rama',
            'rama_id',
            'asesoria_id'
        );
    }
}
