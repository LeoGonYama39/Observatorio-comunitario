<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Models\Educacion\InscripcionesEducativa;
use App\Models\Talleres\RolTallerComunidad;
use App\Models\Talleres\Taller;
use App\Models\Talleres\TallerGen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PComunidad
 *
 * @property int $id
 * @property int $colonia_id
 * @property string $nombre
 * @property string $ap_pat
 * @property string|null $ap_mat
 * @property Carbon|null $birth_date
 * @property string|null $genero
 * @property string|null $nv_escolar
 * @property string|null $telefono
 * @property bool $lider
 * @property string|null $saberes
 *
 * @property Colonium $colonium
 * @property Collection|AJuridica[] $a_juridicas
 * @property Collection|Caso[] $casos
 * @property Collection|CasoTutor[] $caso_tutors
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
		'colonia_id' => 'int',
		'lider' => 'bool'
	];

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

	public function inscripciones_educativas()
	{
		return $this->hasOne(InscripcionesEducativa::class, 'comunidad_id');
	}

	/*public function rol_evento_comunidads()
	{
		return $this->hasMany(RolEventoComunidad::class, 'comunidad_id');
	}*/

	/*public function rol_taller_comunidad()
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
