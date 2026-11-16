<?php

namespace App\Models\Juridica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvolucradoAsesoria extends Model
{
    protected $table = 'involucrados_asesoria';

    public $timestamps = false;

    protected $fillable = [
        'asesoria_id',
        'nombre',
        'familiar_directo',
    ];

    protected $casts = [
        'familiar_directo' => 'boolean',
    ];

    public function asesoria(): BelongsTo
    {
        return $this->belongsTo(Asesoria::class, 'asesoria_id');
    }
}
