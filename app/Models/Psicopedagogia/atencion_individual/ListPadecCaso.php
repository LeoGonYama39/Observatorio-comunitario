<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ListPadecCaso extends Model
{
    protected $table = 'list_padec_caso';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
    ];

    public function casos(): BelongsToMany
    {
        return $this->belongsToMany(
            Caso::class,
            'caso_motivo',
            'padec_caso_id',
            'caso_id'
        );
    }
}