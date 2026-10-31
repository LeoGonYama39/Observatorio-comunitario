<?php

namespace App\Models\Psicopedagogia\atencion_individual;

use App\Models\Personas\PComunidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        )->withPivot('parentesco', 'otro');
    }

    public function casoMasReciente(): HasOne
    {
        return $this->hasOne(Caso::class, 'expediente_id')
            ->latestOfMany('init');
    }

    //--------------------------------
    //          Getters
    //--------------------------------


}
