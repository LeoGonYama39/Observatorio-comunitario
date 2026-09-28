<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Colonia;
use App\Models\listas\Difucion;
use App\Models\listas\NoTrabaja;
use App\Models\listas\PersonasDependen;
use App\Models\listas\ServicioMedico;
use App\Models\listas\Sustento;
use Illuminate\Http\Request;
use App\Models\PComunidad;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PComunidadController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $usuarias = $this->getDatosIndex();

        $view = view("system.modules.personas.p_comunidad.index", compact('persona', 'otros', 'usuarias'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function create(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDropDownOptions($datosUsuario);

        $view = view(
            "system.modules.personas.p_comunidad.create",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['datos' => null]
            )
        );

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store(Request $request)
    {
        $datosUsuario = new DatosUsuario();

        // "Otro" en colonia/alcaldía: el campo de texto solo cuenta (y es obligatorio) en ese caso
        $esColoniaOtro   = $request->input('colonia_id') === 'otro';
        $esAlcaldiaOtros = $request->input('alcaldia') === 'otros';

        // Texto opcional: recortado, o null si viene vacío
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $request->validate([
                'nombre'  => ['required', 'string', 'max:40'],
                'ap_pat'  => ['required', 'string', 'max:40'],
                'ap_mat'  => ['nullable', 'string', 'max:40'],
                'birth_date'   => ['nullable', 'date', 'before_or_equal:today'],
                'genero'       => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'genero'))],
                'estado_civil' => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'estado_civil'))],
                'num_hijos'    => ['nullable', 'integer', 'min:0', 'max:255'],
                'nv_escolar'   => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'nv_escolar'))],
                'ocupacion'    => ['nullable', 'string', 'max:50'],

                'direccion'    => ['nullable', 'string', 'max:200'],
                // colonia_id es INT en la BD, así que "otro" nunca se guarda ahí: se valida aparte
                'colonia_id'   => ['nullable', $esColoniaOtro ? Rule::in(['otro']) : Rule::exists(Colonia::class, 'id')],
                'colonia_otro' => [Rule::requiredIf($esColoniaOtro), 'nullable', 'string', 'max:50'],
                'alcaldia'     => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'alcaldia'))],
                'alcaldia_otro' => [Rule::requiredIf($esAlcaldiaOtros), 'nullable', 'string', 'max:50'],
                'telefono_casa'    => ['nullable', 'string', 'max:20'],
                'telefono_celular' => ['nullable', 'string', 'max:20'],
                'correo'           => ['nullable', 'email', 'max:100'],

                'ingreso_mensual' => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'ingreso_mensual'))],
                'tipo_hogar'      => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'tipo_hogar'))],
                'tipo_vivienda'   => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'tipo_vivienda'))],
                'habitantes_menos_18' => ['nullable', 'integer', 'min:0', 'max:255'],
                'habitantes_mas_18'   => ['nullable', 'integer', 'min:0', 'max:255'],
                'habitantes_mas_60'   => ['nullable', 'integer', 'min:0', 'max:255'],

                'saberes' => ['nullable', 'string', 'max:255'],
                'lider'   => ['nullable', 'boolean'],

                // Redes de apoyo: cada campo llega como array de ids (difusion[], sustento[], ...)
                'difusion'            => ['nullable', 'array'],
                'difusion.*'          => ['integer', 'distinct', 'exists:difucion,id'],
                'sustento'            => ['nullable', 'array'],
                'sustento.*'          => ['integer', 'distinct', 'exists:sustento,id'],
                'no_trabaja'          => ['nullable', 'array'],
                'no_trabaja.*'        => ['integer', 'distinct', 'exists:no_trabaja,id'],
                'servicio_medico'     => ['nullable', 'array'],
                'servicio_medico.*'   => ['integer', 'distinct', 'exists:servicio_medico,id'],
                'personas_dependen'   => ['nullable', 'array'],
                'personas_dependen.*' => ['integer', 'distinct', 'exists:personas_dependen,id'],
            ], $this->getMessages());

            $comunidad = DB::transaction(function () use ($validated, $request, $esColoniaOtro, $esAlcaldiaOtros, $limpiar) {
                $comunidad = PComunidad::create([
                    'nombre'       => trim($validated['nombre']),
                    'ap_pat'       => trim($validated['ap_pat']),
                    'ap_mat'       => $limpiar($validated['ap_mat'] ?? null),
                    'birth_date'   => $validated['birth_date'] ?? null,
                    'genero'       => $validated['genero'] ?? null,
                    'estado_civil' => $validated['estado_civil'] ?? null,
                    'num_hijos'    => $validated['num_hijos'] ?? null,
                    'nv_escolar'   => $validated['nv_escolar'] ?? null,
                    'ocupacion'    => $limpiar($validated['ocupacion'] ?? null),

                    'direccion'     => $limpiar($validated['direccion'] ?? null),
                    'colonia_id'    => $esColoniaOtro ? null : ($validated['colonia_id'] ?? null),
                    'colonia_otro'  => $esColoniaOtro ? trim($validated['colonia_otro']) : null,
                    'alcaldia'      => $validated['alcaldia'] ?? null,
                    'alcaldia_otro' => $esAlcaldiaOtros ? trim($validated['alcaldia_otro']) : null,
                    'telefono_casa'    => $limpiar($validated['telefono_casa'] ?? null),
                    'telefono_celular' => $limpiar($validated['telefono_celular'] ?? null),
                    'correo'           => $limpiar($validated['correo'] ?? null),

                    'ingreso_mensual'     => $validated['ingreso_mensual'] ?? null,
                    'tipo_hogar'          => $validated['tipo_hogar'] ?? null,
                    'tipo_vivienda'       => $validated['tipo_vivienda'] ?? null,
                    'habitantes_menos_18' => $validated['habitantes_menos_18'] ?? null,
                    'habitantes_mas_18'   => $validated['habitantes_mas_18'] ?? null,
                    'habitantes_mas_60'   => $validated['habitantes_mas_60'] ?? null,

                    'lider'   => $request->boolean('lider'),
                    'saberes' => $limpiar($validated['saberes'] ?? null),
                ]);

                // Tablas intermedias: sync() recibe directamente la lista de ids ya validada
                $comunidad->difuciones()->sync($validated['difusion'] ?? []);
                $comunidad->sustentos()->sync($validated['sustento'] ?? []);
                $comunidad->noTrabajos()->sync($validated['no_trabaja'] ?? []);
                $comunidad->serviciosMedicos()->sync($validated['servicio_medico'] ?? []);
                $comunidad->personasDependen()->sync($validated['personas_dependen'] ?? []);

                return $comunidad;
            });

            return redirect()
                ->route('personas-usuarias.show', $comunidad->id)
                ->with('success', 'Persona usuaria registrada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDatosShow($id);

        $view = view(
            "system.modules.personas.p_comunidad.show",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['usuaria' => null]
            )
        );

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $usuaria = $this->getUsuariaByID($id);
        $datos = null;
        if($usuaria) $datos = $this->getDropDownOptions($datosUsuario);

        $view = view(
            "system.modules.personas.p_comunidad.edit",
            array_merge(
                compact('persona', 'otros', 'usuaria'),
                $datos ?? ['datos' => null]
            )
        );

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update(Request $request, PComunidad $personas_usuaria)
    {
        $datosUsuario = new DatosUsuario();

        $esColoniaOtro   = $request->input('colonia_id') === 'otro';
        $esAlcaldiaOtros = $request->input('alcaldia') === 'otros';

        // Texto opcional: recortado, o null si viene vacío
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $request->validate([
                'nombre'  => ['required', 'string', 'max:40'],
                'ap_pat'  => ['required', 'string', 'max:40'],
                'ap_mat'  => ['nullable', 'string', 'max:40'],
                'birth_date'   => ['nullable', 'date', 'before_or_equal:today'],
                'genero'       => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'genero'))],
                'estado_civil' => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'estado_civil'))],
                'num_hijos'    => ['nullable', 'integer', 'min:0', 'max:255'],
                'nv_escolar'   => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'nv_escolar'))],
                'ocupacion'    => ['nullable', 'string', 'max:50'],

                'direccion'    => ['nullable', 'string', 'max:200'],
                'colonia_id'   => ['nullable', $esColoniaOtro ? Rule::in(['otro']) : Rule::exists(Colonia::class, 'id')],
                'colonia_otro' => [Rule::requiredIf($esColoniaOtro), 'nullable', 'string', 'max:50'],
                'alcaldia'     => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'alcaldia'))],
                'alcaldia_otro' => [Rule::requiredIf($esAlcaldiaOtros), 'nullable', 'string', 'max:50'],
                'telefono_casa'    => ['nullable', 'string', 'max:20'],
                'telefono_celular' => ['nullable', 'string', 'max:20'],
                'correo'           => ['nullable', 'email', 'max:100'],

                'ingreso_mensual' => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'ingreso_mensual'))],
                'tipo_hogar'      => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'tipo_hogar'))],
                'tipo_vivienda'   => ['nullable', 'string', Rule::in($datosUsuario->getEnumValues('p_comunidad', 'tipo_vivienda'))],
                'habitantes_menos_18' => ['nullable', 'integer', 'min:0', 'max:255'],
                'habitantes_mas_18'   => ['nullable', 'integer', 'min:0', 'max:255'],
                'habitantes_mas_60'   => ['nullable', 'integer', 'min:0', 'max:255'],

                'saberes' => ['nullable', 'string', 'max:255'],
                'lider'   => ['nullable', 'boolean'],
            ], $this->getMessages());

            $personas_usuaria->nombre = trim($validated['nombre']);
            $personas_usuaria->ap_pat = trim($validated['ap_pat']);
            $personas_usuaria->ap_mat = $limpiar($validated['ap_mat'] ?? null);
            $personas_usuaria->birth_date = $validated['birth_date'] ?? null;
            $personas_usuaria->genero = $validated['genero'] ?? null;
            $personas_usuaria->estado_civil = $validated['estado_civil'] ?? null;
            $personas_usuaria->num_hijos = $validated['num_hijos'] ?? null;
            $personas_usuaria->nv_escolar = $validated['nv_escolar'] ?? null;
            $personas_usuaria->ocupacion = $limpiar($validated['ocupacion'] ?? null);

            $personas_usuaria->direccion = $limpiar($validated['direccion'] ?? null);
            $personas_usuaria->colonia_id = $esColoniaOtro ? null : ($validated['colonia_id'] ?? null);
            $personas_usuaria->colonia_otro = $esColoniaOtro ? trim($validated['colonia_otro']) : null;
            $personas_usuaria->alcaldia = $validated['alcaldia'] ?? null;
            $personas_usuaria->alcaldia_otro = $esAlcaldiaOtros ? trim($validated['alcaldia_otro']) : null;
            $personas_usuaria->telefono_casa = $limpiar($validated['telefono_casa'] ?? null);
            $personas_usuaria->telefono_celular = $limpiar($validated['telefono_celular'] ?? null);
            $personas_usuaria->correo = $limpiar($validated['correo'] ?? null);

            $personas_usuaria->ingreso_mensual = $validated['ingreso_mensual'] ?? null;
            $personas_usuaria->tipo_hogar = $validated['tipo_hogar'] ?? null;
            $personas_usuaria->tipo_vivienda = $validated['tipo_vivienda'] ?? null;
            $personas_usuaria->habitantes_menos_18 = $validated['habitantes_menos_18'] ?? null;
            $personas_usuaria->habitantes_mas_18 = $validated['habitantes_mas_18'] ?? null;
            $personas_usuaria->habitantes_mas_60 = $validated['habitantes_mas_60'] ?? null;

            $personas_usuaria->lider = $request->boolean('lider');
            $personas_usuaria->saberes = $limpiar($validated['saberes'] ?? null);

            $personas_usuaria->save();

            return redirect()
                ->route("personas-usuarias.show", $personas_usuaria->id)
                ->with("success", "Registro actualizado con éxito.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Ocurrió un error al guardar en la base de datos: " .
                    $e->getMessage()
                );
        }
    }

    public function destroy(string $id)
    {
        {
            try {
                $usuaria = PComunidad::findOrFail($id);
                $nombreCompleto = trim($usuaria->nombre . ' ' . $usuaria->ap_pat . ' ' . ($usuaria->ap_mat ?? ''));
                $usuaria->delete();

                return redirect()
                    ->route('personas-usuarias.index')
                    ->with('success', "Persona del usuaria ({$nombreCompleto}) eliminada con éxito.");
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return redirect()
                    ->route('personas-usuarias.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
            } catch (\Throwable $e) {
                return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
        }
    }


    ///// Funciones de apoyo/////////////////

    //Obtiene los datos para la tabla index.
    private function getDatosIndex() {
        return PComunidad::leftJoin(
            'colonia',                  // tabla que quiero unir
            'p_comunidad.colonia_id',   // FK
            '=',                        // operador
            'colonia.id'                // PK
        )
        ->select('p_comunidad.id',
                 'p_comunidad.nombre',
                 'p_comunidad.ap_pat',
                 'p_comunidad.ap_mat',
                 'p_comunidad.birth_date',
                 'p_comunidad.genero',
                 'p_comunidad.lider',
                 'p_comunidad.saberes',
                 'p_comunidad.colonia_otro',
                 'colonia.nombre AS colonia')
        ->orderBy('nombre')
        ->get();
    }

    private function getDatosShow($id)
    {
        $usuaria = $this->getUsuariaByID($id);

        if(!$usuaria) return null;

        $actividades = collect();

        // Educación
        if ($usuaria->inscripcionEducativa) {
            foreach ($usuaria->inscripcionEducativa->inscripcionesCurso as $inscripcion) {
                $actividades->push([
                    'anio' => $inscripcion->anio,
                    'temporada' => $inscripcion->temporada,
                    'tipo' => 'educacion',
                    'nombre' => $inscripcion->curso->nombre,
                ]);
            }
        }

        // Talleres como participante
        foreach ($usuaria->talleresComoParticipante as $tallerGen) {
            $actividades->push([
                'anio' => $tallerGen->anio,
                'temporada' => $tallerGen->temporada,
                'tipo' => 'taller',
                'nombre' => $tallerGen->taller->nombre,
                'rol' => 'participante',
            ]);
        }

        // Talleres como tallerista
        foreach ($usuaria->talleresComoTallerista as $tallerGen) {
            $actividades->push([
                'anio' => $tallerGen->anio,
                'temporada' => $tallerGen->temporada,
                'tipo' => 'taller',
                'nombre' => $tallerGen->taller->nombre,
                'rol' => 'tallerista',
            ]);
        }


        $ordenTemporada = [
            'otoño' => 2,
            'primavera' => 1,
        ];

        $actividades = $actividades
            ->groupBy(function ($actividad) {
                return $actividad['anio'] . ' ' . $actividad['temporada'];
            })
            ->sortByDesc(function ($grupo, $periodo) use ($ordenTemporada) {
                [$anio, $temporada] = explode(' ', $periodo);

                return ((int) $anio * 10) + $ordenTemporada[$temporada];
            })
            ->mapWithKeys(function ($grupo, $periodo) {

                [$anio, $temporada] = explode(' ', $periodo);

                return [
                    ucfirst($temporada) . ' ' . $anio => [
                        'educacion' => $grupo
                            ->where('tipo', 'educacion')
                            ->values(),

                        'talleres' => $grupo
                            ->where('tipo', 'taller')
                            ->values(),
                    ]
                ];
            });

        return compact('usuaria', 'actividades');
    }

    private function getUsuariaByID($id)
    {
        return PComunidad::with([
            'difuciones',
            'sustentos',
            'noTrabajos',
            'serviciosMedicos',
            'personasDependen',
            'inscripcionEducativa.inscripcionesCurso.curso',
            'talleresComoParticipante.taller',
            'talleresComoTallerista.taller',
        ])
            ->leftJoin(
                'colonia',
                'p_comunidad.colonia_id',
                '=',
                'colonia.id'
            )
            ->select(
                'p_comunidad.id',
                'p_comunidad.nombre',
                'p_comunidad.ap_pat',
                'p_comunidad.ap_mat',
                'p_comunidad.nv_escolar',
                'p_comunidad.estado_civil',
                'p_comunidad.num_hijos',
                'p_comunidad.ocupacion',
                'p_comunidad.direccion',
                'p_comunidad.colonia_otro',
                'p_comunidad.alcaldia',
                'p_comunidad.alcaldia_otro',
                'p_comunidad.correo',
                'p_comunidad.ingreso_mensual',
                'p_comunidad.tipo_hogar',
                'p_comunidad.tipo_vivienda',
                'p_comunidad.habitantes_menos_18',
                'p_comunidad.habitantes_mas_18',
                'p_comunidad.habitantes_mas_60',
                'p_comunidad.birth_date',
                'p_comunidad.genero',
                'p_comunidad.telefono_celular',
                'p_comunidad.telefono_casa',
                'p_comunidad.lider',
                'p_comunidad.saberes',
                'colonia.nombre AS colonia',
                'colonia.id AS colonia_id',
            )
            ->where('p_comunidad.id', $id)
            ->first();
    }

    private function getDropDownOptions($datosUsuario) {
        $generos = $datosUsuario->getEnumValues('p_comunidad', 'genero');
        $estadoCivil = $datosUsuario->getEnumValues('p_comunidad', 'estado_civil');
        $nvEscolar = $datosUsuario->getEnumValues('p_comunidad', 'nv_escolar');
        $alcaldia = $datosUsuario->getEnumValues('p_comunidad', 'alcaldia');
        $ingresoMensual = $datosUsuario->getEnumValues('p_comunidad', 'ingreso_mensual');
        $tipoHogar = $datosUsuario->getEnumValues('p_comunidad', 'tipo_hogar');
        $tipoVivienda = $datosUsuario->getEnumValues('p_comunidad', 'tipo_vivienda');
        $difuciones = Difucion::select('id', 'nombre')->get();
        $sustentos = Sustento::select('id', 'nombre')->get();
        $noTrabaja = NoTrabaja::select('id', 'nombre')->get();
        $serviciosMedicos = ServicioMedico::select('id', 'nombre')->get();
        $personasDependen = PersonasDependen::select('id', 'nombre')->get();
        $colonias = Colonia::select('id', 'nombre')->get();

        return compact(
            'generos',
            'estadoCivil',
            'nvEscolar',
            'alcaldia',
            'ingresoMensual',
            'tipoHogar',
            'tipoVivienda',
            'difuciones',
            'sustentos',
            'noTrabaja',
            'serviciosMedicos',
            'personasDependen',
            'colonias'
        );
    }

    private function getMessages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max'      => 'El nombre no puede tener más de 40 caracteres.',
            'ap_pat.required' => 'El apellido paterno es obligatorio.',
            'ap_pat.max'      => 'El apellido paterno no puede tener más de 40 caracteres.',
            'ap_mat.max'      => 'El apellido materno no puede tener más de 40 caracteres.',
            'birth_date.date' => 'La fecha de nacimiento no es válida.',
            'birth_date.before_or_equal' => 'La fecha de nacimiento no puede ser futura.',
            'genero.in'       => 'El género seleccionado no es válido.',
            'estado_civil.in' => 'El estado civil seleccionado no es válido.',
            'num_hijos.integer' => 'El número de hijos debe ser un número entero.',
            'num_hijos.min'     => 'El número de hijos no puede ser negativo.',
            'num_hijos.max'     => 'El número de hijos no puede ser mayor a 255.',
            'nv_escolar.in'   => 'El nivel escolar seleccionado no es válido.',
            'ocupacion.max'   => 'La ocupación no puede tener más de 50 caracteres.',

            'direccion.max'   => 'La dirección no puede tener más de 200 caracteres.',
            'colonia_id.exists' => 'La colonia seleccionada no es válida.',
            'colonia_id.in'     => 'La colonia seleccionada no es válida.',
            'colonia_otro.required' => 'Especifica el nombre de la colonia.',
            'colonia_otro.max'      => 'La colonia no puede tener más de 50 caracteres.',
            'alcaldia.in'           => 'La alcaldía seleccionada no es válida.',
            'alcaldia_otro.required' => 'Especifica el nombre de la alcaldía.',
            'alcaldia_otro.max'      => 'La alcaldía no puede tener más de 50 caracteres.',
            'telefono_casa.max'      => 'El teléfono de casa no puede tener más de 20 caracteres.',
            'telefono_celular.max'   => 'El teléfono celular no puede tener más de 20 caracteres.',
            'correo.email' => 'Ingresa un correo válido.',
            'correo.max'   => 'El correo no puede tener más de 100 caracteres.',

            'ingreso_mensual.in' => 'El ingreso mensual seleccionado no es válido.',
            'tipo_hogar.in'      => 'El tipo de hogar seleccionado no es válido.',
            'tipo_vivienda.in'   => 'El tipo de vivienda seleccionado no es válido.',
            'habitantes_menos_18.integer' => 'Los habitantes menores de 18 deben ser un número entero.',
            'habitantes_menos_18.min'     => 'Los habitantes menores de 18 no pueden ser negativos.',
            'habitantes_menos_18.max'     => 'Los habitantes menores de 18 no pueden ser más de 255.',
            'habitantes_mas_18.integer'   => 'Los habitantes mayores de 18 deben ser un número entero.',
            'habitantes_mas_18.min'       => 'Los habitantes mayores de 18 no pueden ser negativos.',
            'habitantes_mas_18.max'       => 'Los habitantes mayores de 18 no pueden ser más de 255.',
            'habitantes_mas_60.integer'   => 'Los habitantes mayores de 60 deben ser un número entero.',
            'habitantes_mas_60.min'       => 'Los habitantes mayores de 60 no pueden ser negativos.',
            'habitantes_mas_60.max'       => 'Los habitantes mayores de 60 no pueden ser más de 255.',

            'saberes.max' => 'El directorio de saberes no puede tener más de 255 caracteres.',

            'difusion.array'      => 'La difusión enviada no es válida.',
            'difusion.*.exists'   => 'Una de las opciones de difusión no es válida.',
            'difusion.*.distinct' => 'Hay opciones de difusión repetidas.',
            'sustento.array'      => 'El sustento enviado no es válido.',
            'sustento.*.exists'   => 'Una de las opciones de sustento no es válida.',
            'sustento.*.distinct' => 'Hay opciones de sustento repetidas.',
            'no_trabaja.array'      => 'Los ingresos enviados no son válidos.',
            'no_trabaja.*.exists'   => 'Una de las opciones de ingresos no es válida.',
            'no_trabaja.*.distinct' => 'Hay opciones de ingresos repetidas.',
            'servicio_medico.array'      => 'El servicio médico enviado no es válido.',
            'servicio_medico.*.exists'   => 'Una de las opciones de servicio médico no es válida.',
            'servicio_medico.*.distinct' => 'Hay opciones de servicio médico repetidas.',
            'personas_dependen.array'      => 'Las personas dependientes enviadas no son válidas.',
            'personas_dependen.*.exists'   => 'Una de las opciones de personas dependientes no es válida.',
            'personas_dependen.*.distinct' => 'Hay opciones de personas dependientes repetidas.',
        ];
    }
}
