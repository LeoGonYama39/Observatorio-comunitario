<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Educacion\InscripcionEducativa;
use App\Models\listas\Difucion;
use App\Models\listas\NoTrabaja;
use App\Models\listas\PersonasDependen;
use App\Models\listas\ServicioMedico;
use App\Models\listas\Sustento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PComunidad
 *
 * @property int $id
 * @property string $nombre
 * @property string $ap_pat
 * @property string|null $ap_mat
 * @property string|null $genero
 * @property Carbon|null $birth_date
 * @property string|null $estado_civil
 * @property int|null $num_hijos
 * @property string|null $nv_escolar
 * @property string|null $ocupacion
 * @property string|null $direccion
 * @property int|null $colonia_id
 * @property string|null $colonia_otro
 * @property string|null $alcaldia
 * @property string|null $alcaldia_otro
 * @property string|null $telefono_casa
 * @property string|null $telefono_celular
 * @property string|null $correo
 * @property string|null $ingreso_mensual
 * @property string|null $tipo_hogar
 * @property string|null $tipo_vivienda
 * @property int|null $habitantes_menos_18
 * @property int|null $habitantes_mas_18
 * @property int|null $habitantes_mas_60
 * @property bool $lider
 * @property string|null $saberes
 *
 * @property Colonium|null $colonium
 * @property Collection|AJuridica[] $a_juridicas
 * @property Collection|Caso[] $casos
 * @property Collection|CasoTutor[] $caso_tutors
 * @property Collection|ComunidadDifucion[] $comunidad_difucions
 * @property Collection|ComunidadNoTrabaja[] $comunidad_no_trabajas
 * @property Collection|ComunidadPersonasDependen[] $comunidad_personas_dependens
 * @property Collection|ComunidadServicioMedico[] $comunidad_servicio_medicos
 * @property Collection|ComunidadSustento[] $comunidad_sustentos
 * @property InscripcionesEducativa|null $inscripciones_educativa
 * @property Collection|RolEventoComunidad[] $rol_evento_comunidads
 * @property Collection|RolTallerComunidad[] $rol_taller_comunidads
 * @property Collection|TallerGrupo[] $taller_grupos
 * @property Collection|TalleresProcGrupGrupo[] $talleres_proc_grup_grupos
 *
 * @package App\Models
 */
class PComunidad extends Model
{
	protected $table = 'p_comunidad';
	public $timestamps = false;

	protected $casts = [
		'birth_date' => 'datetime',
		'num_hijos' => 'int',
		'colonia_id' => 'int',
		'habitantes_menos_18' => 'int',
		'habitantes_mas_18' => 'int',
		'habitantes_mas_60' => 'int',
		'lider' => 'bool'
	];

	protected $fillable = [
		'nombre',
		'ap_pat',
		'ap_mat',
		'genero',
		'birth_date',
		'estado_civil',
		'num_hijos',
		'nv_escolar',
		'ocupacion',
		'direccion',
		'colonia_id',
		'colonia_otro',
		'alcaldia',
		'alcaldia_otro',
		'telefono_casa',
		'telefono_celular',
		'correo',
		'ingreso_mensual',
		'tipo_hogar',
		'tipo_vivienda',
		'habitantes_menos_18',
		'habitantes_mas_18',
		'habitantes_mas_60',
		'lider',
		'saberes'
	];

    protected $appends = [
        'edad',
        'categoria',
        'categ_categ',
    ];

    //Función para obtener la edad, con la fecha de nacimiento guardada
    public function getEdadAttribute() {
        if(!$this->birth_date) return null;
        return \Carbon\Carbon::parse($this->birth_date)->age;
    }

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


    public function colonia()
	{
		return $this->belongsTo(Colonia::class, 'colonia_id');
	}

	/*public function a_juridicas()
	{
		return $this->hasMany(AJuridica::class, 'comunidad_id');
	}*/

	/*public function casos()
	{
		return $this->hasMany(Caso::class, 'comunidad_id');
	}*/

	/*public function caso_tutors()
	{
		return $this->hasMany(CasoTutor::class, 'comunidad_id');
	}*/

    public function difuciones()
    {
        return $this->belongsToMany(
            Difucion::class,
            'comunidad_difucion',
            'comunidad_id',
            'difucion_id'
        );
    }

    public function sustentos()
    {
        return $this->belongsToMany(
            Sustento::class,
            'comunidad_sustento',
            'comunidad_id',
            'sustento_id'
        );
    }

    public function noTrabajos()
    {
        return $this->belongsToMany(
            NoTrabaja::class,
            'comunidad_no_trabaja',
            'comunidad_id',
            'no_trabaja_id'
        );
    }

    public function serviciosMedicos()
    {
        return $this->belongsToMany(
            ServicioMedico::class,
            'comunidad_servicio_medico',
            'comunidad_id',
            'servicio_medico_id'
        );
    }

    public function personasDependen()
    {
        return $this->belongsToMany(
            PersonasDependen::class,
            'comunidad_personas_dependen',
            'comunidad_id',
            'personas_dependen_id'
        );
    }

	/*public function inscripcion_educativa()
	{
		return $this->hasOne(InscripcionEducativa::class, 'comunidad_id');
	}*/

	/*public function rol_evento_comunidads()
	{
		return $this->hasMany(RolEventoComunidad::class, 'comunidad_id');
	}*/

	/*public function rol_taller_comunidads()
	{
		return $this->hasMany(RolTallerComunidad::class, 'comunidad_id');
	}*/

	/*public function taller_grupos()
	{
		return $this->hasMany(TallerGrupo::class, 'comunidad_id');
	}*/

	/*public function talleres_proc_grup_grupos()
	{
		return $this->hasMany(TalleresProcGrupGrupo::class, 'comunidad_id');
	}*/

    public function talleresComoTallerista()
    {
        return $this->belongsToMany(
            TallerGen::class,
            'tallerista_comunidad',
            'comunidad_id',
            'taller_gen_id'
        );
    }

    public function talleresComoApoyo()
    {
        return $this->belongsToMany(
            Taller::class,
            'rol_taller_comunidad',
            'comunidad_id',
            'taller_id'
        )->withPivot('rol', 'otros');
    }

    public function talleresComoParticipante()
    {
        return $this->belongsToMany(
            TallerGen::class,
            'taller_grupos',
            'comunidad_id',
            'taller_gen_id'
        )->withPivot('baja');
    }
}
