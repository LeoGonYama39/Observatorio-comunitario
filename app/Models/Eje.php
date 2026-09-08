<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Area;

class Eje extends Model
{
    public $timestamps = false;
    protected $table = 'eje';

    protected $fillable = [
        'nombre',
    ];

    public function areas()
    {
        return $this->belongsToMany(Area::class, 'area_eje');
    }
}
