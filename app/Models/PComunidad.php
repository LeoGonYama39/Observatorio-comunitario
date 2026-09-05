<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PComunidad extends Model
{
    public $timestamps = false;
    protected $table = 'p_comunidad';
    
    protected $fillable = [
        'colonia_id',
        'nombre',
        'ap_pat',
        'ap_mat',
        'birth_date',
        'genero',
        'nv_escolar',
        'telefono',
        'lider',
        'saberes',
    ];

    //Crear una nueva columna fake
    protected $appends = ['edad'];

    //Función para obtener la edad, con la fecha de nacimiento guardada
    public function getEdadAttribute() { return \Carbon\Carbon::parse($this->birth_date)->age; }
}
