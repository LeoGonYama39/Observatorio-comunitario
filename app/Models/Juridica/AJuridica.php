<?php

namespace App\Models\Juridica;

use App\Models\Personas\PComunidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AJuridica extends Model
{
    protected $table = 'a_juridica';

    public $timestamps = false;

    protected $fillable = [
        'asesoria_id',
        'comunidad_id',
    ];

    public function asesoria(): BelongsTo
    {
        return $this->belongsTo(Asesoria::class, 'asesoria_id');
    }

    public function comunidad(): BelongsTo
    {
        return $this->belongsTo(PComunidad::class, 'comunidad_id');
    }
}
