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
    protected $appends = [
        'edad',
        'categoria',
        'categ_categ',
        ];

    //Lider lo lee como 0 o 1, usar como booleano
    protected $casts = [
        'lider' => 'boolean',
    ];

    //Función para obtener la edad, con la fecha de nacimiento guardada
    public function getEdadAttribute() { return \Carbon\Carbon::parse($this->birth_date)->age; }

    public function getCategCategAttribute() {
        return match (true) {       //match es como muchos ifs juntos
            $this->lider && (bool)$this->saberes => 'lider_saberes',
            $this->lider => 'lider',
            (bool)$this->saberes => 'saberes',
            default => 'usuario',
        };
    }

    public function getCategoriaAttribute() {
        switch ($this->categ_categ) {
            case "lider_saberes":
                return 'Líder y dir. de saberes';
                break; 
            case "lider":
                return "Líder comunitario";
                break;
            case "saberes":
                return "Directorio de saberes";
                break;
            default:
                return $this->genero === 'masculino' ? 'Usuario' : 'Usuaria';
                break;
        }
    }
}
