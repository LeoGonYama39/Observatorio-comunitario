<?php

namespace App\Models\ListaOpciones;

use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
    public $timestamps = false;
    protected $table = 'instituciones';

    protected $fillable = [
        'nombre',
        'universidad',
        'nombre_contacto',
        'area',
        'correo',
        'telefono',
    ];

    protected $casts = [
		'universidad' => 'bool'
	];
}
