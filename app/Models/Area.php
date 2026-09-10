<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eje;

class Area extends Model
{
    public $timestamps = false;
    protected $table = 'area';

    protected $fillable = [
        'nombre',
        'centro_id',
    ];

    public function ejes()
    { return $this->belongsToMany(Eje::class, 'area_eje');}
}
