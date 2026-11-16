<?php

namespace App\Models\Juridica;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AFamiliar extends Model
{
    protected $table = 'a_familiar';

    public $timestamps = false;

    protected $fillable = [
        'asesoria_id',
        'nombre_familia',
    ];

    public function asesoria(): BelongsTo
    {
        return $this->belongsTo(Asesoria::class, 'asesoria_id');
    }
}
