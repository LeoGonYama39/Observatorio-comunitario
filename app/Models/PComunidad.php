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
use App\Models\Talleres\Taller;
use App\Models\Talleres\TallerGen;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Psicopedagogia\atencion_individual\Expediente;


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
		'nombre',       //[NN]
		'ap_pat',       //[NN]
		'ap_mat',
		'genero',       //[NN]
		'birth_date',   //[NN]
		'estado_civil',
		'num_hijos',
		'nv_escolar',
		'ocupacion',
		'direccion',
		'colonia_id',   //[NN]
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
		'saberes',
        'temporada',    //[NN]
        'anio'          //[NN]
	];

    protected $appends = [
        'edad',
        'categoria',
        'categ_categ',
        'colonia_mostrar',
        'alcaldia_mostrar',
        'activo',
    ];

    //Función para obtener la edad, con la fecha de nacimiento guardada
    public function getEdadAttribute() {
        if(!$this->birth_date) return null;
        return \Carbon\Carbon::parse($this->birth_date)->age;
    }

    public function getActivoAttribute()
    {
        //Filtro para los de las participaciones pasadas
        $ahora = Carbon::now();
        $anioActual = $ahora->year;
        $mesActual = $ahora->month;

        //Filtro anual
        if($this->anio < $anioActual) return false;

        //Filtro de temporada
        if ($this->temporada === 'primavera' && $mesActual > 5) return false;

        //Si la participación es activa
        return true;
    }

    public function getColoniaMostrarAttribute()
    {
        return match (true) {     
            (bool)$this->colonia_id => $this->colonia->nombre ?? 'No encontró la colonia',
            (bool)$this->colonia_otro => $this->colonia_otro ?? 'No encontró el otro colonia',
            default => '',
        };
    }

    public function getAlcaldiaMostrarAttribute()
    {
        if ($this->alcaldia === 'otro') {
            return $this->alcaldia_otro;
        }

        return ucfirst(str_replace('_', ' ', $this->alcaldia));
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
            case "lider":
                return "Líder comunitario";
            case "saberes":
                return "Directorio de saberes";
            default:
                return $this->genero === 'masculino' ? 'Usuario' : 'Usuaria';
        }
    }

    //--------------------------------
    //          Relaciones
    //--------------------------------

    public function colonia()
	{
		return $this->belongsTo(Colonia::class, 'colonia_id');
	}

    //Relaciones para el formulario

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

    //Relaciones con educación

    public function inscripcionEducativa()
    {
        return $this->hasOne(
            InscripcionEducativa::class,
            'comunidad_id'
        );
    }

    //Relaciones con talleres

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

    //Relaciones con atención personal
    public function expediente(): HasOne
    {
        return $this->hasOne(Expediente::class, 'comunidad_id');
    }

    public function expedientesComoTutor(): BelongsToMany
    {
        return $this->belongsToMany(
            Expediente::class,
            'expediente_tutor',
            'comunidad_id',
            'expediente_id'
        )->withPivot('parentesco');
    }
}
