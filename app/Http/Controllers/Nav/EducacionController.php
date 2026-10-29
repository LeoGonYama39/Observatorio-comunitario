<?php

//Controlador para ambos tipos de educación: básica y media-superior

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Educacion\InscripcionEducativa;
use App\Models\Educacion\InscripcionCurso;
use App\Models\Educacion\Curso;
use Illuminate\Http\Request;
use App\Models\PComunidad;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EducacionController extends Controller
{
    private const TEMPORADA_PRIMAVERA = 'primavera';
    private const TEMPORADA_OTONO     = 'otoño';

    public function index(Request $request, string $nivel) {
        $support = new DatosUsuario;
        $config = $this->configEducacion($nivel);

        $tipo = $config['tipo'];
        $estados = $support->getEnumValues('inscripcion_curso', 'estado');
        $inscripciones = $this->getDatosIndex($config['tipo'], $config['otro_tipo']);
        $etiqueta = $config['etiqueta'];
        $rutaCreate = route($config['ruta'] . '.create');
        $cursos = $this->getCursosPorNivel($tipo);

        $view = view(
            'system.modules.educacion.index',
            compact(
                'inscripciones',
                'etiqueta',
                'rutaCreate',
                'tipo',
                'estados',
                'cursos')
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

    public function show(Request $request, string $id, string $nivel) {
        $config = $this->configEducacion($nivel);
        
        $datos = $this->getDatosShow((int)$id, $config['tipo']);
        $etiqueta = $config['etiqueta'];
        $rutaIndex = route($config['ruta'] . '.index');
        $rutaEdit = route($config['ruta'] . '.edit', $id);
        $rutaDestroy = route($config['ruta'] . '.destroy', $id);
        $rutaCreateCurso = route($config['ruta'] . '_curso.create', $id);
        $ruta = $config['ruta'];

        $view = view(
            'system.modules.educacion.show',
                        array_merge(
                            compact('etiqueta', 'rutaIndex', 'rutaEdit', 'rutaDestroy', 'rutaCreateCurso', 'ruta'),
                            $datos ?? ['inscripcion' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function create(Request $request, string $nivel) {
        $config = $this->configEducacion($nivel);
        
        [$personasComunidad, $yaRegistrados] = $this->getUsuarias();
        $rutaIndex = route($config['ruta'] . '.index');
        $etiqueta = $config['etiqueta'];
        $rutaStore = route($config['ruta'] . '.store');

        $view = view("system.modules.educacion.create", compact(
            'personasComunidad',
            'yaRegistrados',
            'rutaIndex',
            'etiqueta',
            'rutaStore'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store(Request $request, string $nivel) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        $config = $this->configEducacion($nivel);
    
        try {
            $validated = $this->getValidate($request);
    
            $inscripcion = InscripcionEducativa::create([
                'comunidad_id' => $validated['comunidad_id'],
                'rfe'          => $limpiar($validated['rfe'] ?? null),
                'curp'         => $limpiar($validated['curp'] ?? null),
                'matricula'    => $limpiar($validated['matricula'] ?? null),
            ]);
    
            return redirect()
                ->route($config['ruta'] . '.show', $inscripcion->id)
                ->with('success', 'Persona registrada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            // 1062 = llave única duplicada: dos personas registraron a la misma persona
            // al mismo tiempo y el unique del validate no alcanzó a verlo.
            if (($e->errorInfo[1] ?? null) === 1062) {
                return back()
                    ->withInput()
                    ->with('error', 'Esta persona ya fue registrada en educación.');
            }
    
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }
    
    public function edit(Request $request, string $id, string $nivel) {
        $config = $this->configEducacion($nivel);

        $inscripcion = $this->getDatosEdit((int)$id);
        $etiqueta = $config['etiqueta'];
        $rutaIndex = route($config['ruta'] . '.index');
        $rutaShow = route($config['ruta'] . '.show', $id);
        $rutaUpdate = route($config['ruta'] . '.update', $id);

        $view = view("system.modules.educacion.edit", compact(
            'inscripcion',
            'etiqueta',
            'rutaIndex',
            'rutaShow',
            'rutaUpdate'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update(Request $request, InscripcionEducativa $id, string $nivel) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        $config = $this->configEducacion($nivel);
    
        try {
            $validated = $this->getValidate($request, true);
    
            $id->rfe = $limpiar($validated['rfe'] ?? null);
            $id->curp = $limpiar($validated['curp'] ?? null);
            $id->matricula = $limpiar($validated['matricula'] ?? null);
            $id->save();
    
            return redirect()
                ->route($config['ruta'] . '.show', $id)
                ->with('success', 'Persona registrada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            // 1062 = llave única duplicada: dos personas registraron a la misma persona
            // al mismo tiempo y el unique del validate no alcanzó a verlo.
            if (($e->errorInfo[1] ?? null) === 1062) {
                return back()
                    ->withInput()
                    ->with('error', 'Esta persona ya fue registrada en educación.');
            }
    
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy(string $id, string $nivel) {
        $config = $this->configEducacion($nivel);
        try {
                $inscripcion = InscripcionEducativa::findOrFail($id);
                $nombre = $inscripcion->comunidad->nombre . ' ' . $inscripcion->comunidad->ap_pat . ' ' . $inscripcion->comunidad->ap_mat;
                $inscripcion->delete();

                return redirect()
                ->route($config['ruta'] . '.index')
                ->with('success', "Registro de educación de {$nombre} eliminado con éxito.");
                } 
                catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    return redirect()
                    ->route($config['ruta'] . '.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
                } catch (\Throwable $e) {
                    return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
    }

    public function create_curso(Request $request, string $id, string $nivel) {
        $config = $this->configEducacion($nivel);

        $datos = $this->getDatosCreateCurso((int)$id, $config['tipo']);

        $etiqueta = $config['etiqueta'];
        $rutaIndex = route($config['ruta'] . '.index');
        $rutaShow = route($config['ruta'] . '.show', $id);
        $rutaStore = route($config['ruta'] . '_curso.store', $id);

        $view = view("system.modules.educacion.create_curso", array_merge(
            compact('etiqueta', 'rutaIndex', 'rutaShow', 'rutaStore'),
            $datos ?? ['inscripcion' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store_curso(Request $request, InscripcionEducativa $id, string $nivel) {
        $config = $this->configEducacion($nivel);

        try {
            $validated = $this->getValidateCurso($request);

            DB::transaction(function () use ($validated, $id) {

                $inscripcionCurso = InscripcionCurso::create([
                    'insc_edu_id'   => $id->id,
                    'cursos_id'     => $validated['cursos_id'],
                    'fecha_ingreso' => $validated['fecha_ingreso'],
                    'temporada'     => $this->temporadaDe($validated['fecha_ingreso']),
                    'estado'        => 'activo',
                ]);

                $curso = Curso::with('materias:id')->findOrFail((int)$validated['cursos_id']);

                $materias = $curso->materias->mapWithKeys(function ($materia) {
                    return [$materia->id => ['cursado' => false],];
                })->all();

                $inscripcionCurso->materias()->attach($materias);
            });

            return redirect()
                ->route($config['ruta'] . '.show', $id->id)
                ->with('success', 'Curso y materias registrados con éxito.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function edit_curso(Request $request, string $id, string $nivel) {
        $config = $this->configEducacion($nivel);

        $inscripcion = InscripcionCurso::with('curso')->findOrFail((int)$id);
        $etiqueta = $config['etiqueta'];
        $rutaIndex = route($config['ruta'] . '.index');
        $rutaShow = route($config['ruta'] . '.show', $inscripcion->insc_edu_id);
        $rutaStore = route($config['ruta'] . '_curso.update', $id);
        $ruta = $config['ruta'];

        $view = view("system.modules.educacion.edit_curso", compact(
            'inscripcion',
            'etiqueta',
            'rutaIndex',
            'rutaShow',
            'rutaStore',
            'ruta'
        ));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update_curso(Request $request, InscripcionCurso $id, string $nivel) {
        $config = $this->configEducacion($nivel);
    
        try {
            $validated = $this->getValidateCurso($request, true);
            $id->fecha_ingreso = $validated['fecha_ingreso'];
            if ($id->estado !== 'concluido') {
                $id->estado = $request->boolean('dado_de_baja')
                    ? 'baja'
                    : 'activo';
            }
            $id->temporada = $this->temporadaDe($validated['fecha_ingreso']);
            $id->save();
    
            return redirect()
                ->route($config['ruta'] . '.show', $id->inscripcionEducativa->id)
                ->with('success', 'Cambios registrados con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy_curso(string $id, string $nivel) {
        $config = $this->configEducacion($nivel);
        try {
                $inscripcion = InscripcionCurso::findOrFail($id);
                $nombre = $inscripcion->curso->nombre;
                $idShow = $inscripcion->inscripcionEducativa->id;
                $inscripcion->delete();

                return redirect()
                ->route($config['ruta'] . '.show', $idShow)
                ->with('success', "Curso {$nombre} eliminado con éxito.");
                } 
                catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    return redirect()
                    ->route($config['ruta'] . '.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
                } catch (\Throwable $e) {
                    return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
    }

    public function toggleMateria(Request $request, int $inscripcionCurso,int $materia) {
        $validated = $request->validate([
            'cursado' => ['required', 'boolean'],
        ]);

        $resultado = DB::transaction(function () use ($inscripcionCurso, $materia, $validated) {
            $inscripcion = InscripcionCurso::whereKey($inscripcionCurso)
                ->lockForUpdate()
                ->firstOrFail();

            $materiaInscrita = $inscripcion->materias()
                ->where('materias.id', $materia)
                ->exists();

            if (!$materiaInscrita) {
                abort(404, 'La materia no pertenece a esta inscripción.');
            }

            DB::table('inscripcion_materia')
                ->where('insc_curso_id', $inscripcionCurso)
                ->where('materia_id', $materia)
                ->update([
                    'cursado' => $validated['cursado'],
                ]);

            $materias = $inscripcion->materias()->get();

            $total = $materias->count();

            $acreditadas = $materias
                ->filter(fn ($item) => (bool) $item->pivot->cursado)
                ->count();

            $estadoAnterior = $inscripcion->estado;

            if ($total > 0 && $acreditadas === $total) {
                $inscripcion->estado = 'concluido';
            } elseif ($inscripcion->estado === 'concluido') {
                $inscripcion->estado = 'activo';
            }

            if ($inscripcion->estado !== $estadoAnterior) {
                $inscripcion->save();
            }

            return [
                'cursado' => (bool) $validated['cursado'],
                'acreditadas' => $acreditadas,
                'total' => $total,
                'progreso' => $total > 0
                    ? round(($acreditadas / $total) * 100, 2)
                    : 0,
                'estado' => $inscripcion->estado,
            ];
        });

        return response()->json([
            'success' => true,
            ...$resultado,
        ]);
    }

    //-------------------
    //  Funciones
    //------------------

    private function configEducacion(string $nivel): array {
        return match ($nivel) {
            'basica' => [
                'tipo' => 'básica',
                'otro_tipo' => 'media_superior',
                'etiqueta' => 'educación básica',
                'ruta' => 'educ_basica',
            ],
            'sup' => [
                'tipo' => 'media_superior',
                'otro_tipo' => 'básica',
                'etiqueta' => 'educación media superior',
                'ruta' => 'educ_sup',
            ],
            default => abort(404),
        };
    }

    private function getDatosIndex(string $tipo, string $otro) {
        $inscripciones = InscripcionEducativa::with([
            'comunidad:id,nombre,ap_pat,ap_mat',

            'inscripcionesCurso' => function ($query) use ($tipo) {
                $query->whereHas('curso', function ($query) use ($tipo) {
                    $query->where('tipo', $tipo);
                })
                ->with([
                    'curso.materias',
                    'materias',
                ])
                ->orderBy('fecha_ingreso', 'desc');
            },
        ])->get();

        return $inscripciones
            ->sortBy(function ($inscripcion) {
                return $inscripcion->comunidad->nombre;
            })
            ->map(function ($inscripcion) use ($otro, $tipo) {
                $persona = $inscripcion->comunidad;

                // Curso más reciente de educación básica
                $curso = $inscripcion->inscripcionesCurso->first();

                if ($curso) {
                    $acreditadas = $curso->materias
                        ->filter(fn ($materia) => $materia->pivot->cursado)
                        ->count();

                    $total = $curso->curso->materias->count();

                    $estado = $curso->estado;
                    $nombreCurso = $curso->curso->nombre;
                    $idCurso = $curso->curso->id;
                    $avance = "$acreditadas de $total acreditadas";
                } else {
                    // ¿Tiene algún curso de educación media-superior?
                    $tieneOtroNivel = $inscripcion->inscripcionesCurso()
                        ->whereHas('curso', function ($query) use ($otro) {
                            $query->where('tipo', $otro);
                        })
                        ->exists();

                    $estado = $tieneOtroNivel
                        ? 'Registrado en educación ' . str_replace('_', ' ', $otro)
                        : 'Sin curso registrado';

                    $nombreCurso = null;
                    $idCurso = null;
                    $avance = null;
                }

                switch($tipo) {
                    case 'básica':
                        $urlShow = route('educ_basica.show', $inscripcion->id);
                        break;
                    case 'media_superior':
                        $urlShow = route('educ_sup.show', $inscripcion->id);
                        break;
                    default:
                        $urlShow = 'hola';
                }

                return [
                    'id' => $inscripcion->id,
                    'nombre' => $persona->nombre,
                    'ap_pat' => $persona->ap_pat,
                    'ap_mat' => $persona->ap_mat,
                    'estado' => $estado,
                    'curso_id' => $idCurso,
                    'curso' => $nombreCurso,
                    'avance' => $avance,
                    'url' => $urlShow,
                ];
            })
            ->values();
    }

    private function getDatosShow(int $id, string $tipo) {
        $inscripcion = InscripcionEducativa::with([
            'comunidad:id,nombre,ap_pat,ap_mat,birth_date,genero,colonia_id,colonia_otro',
            'comunidad.colonia:id,nombre',
            'inscripcionesCurso' => function ($query) use ($tipo) {
                $query->select(
                    'id',
                    'insc_edu_id',
                    'cursos_id',
                    'temporada',
                    'estado',
                    'fecha_ingreso'
                )
                    ->whereHas('curso', function ($query) use ($tipo) {
                        $query->where('tipo', $tipo);
                    })
                    ->with([
                        'curso:id,nombre',
                        'materias:id,nombre',
                    ])
                    ->orderBy('fecha_ingreso', 'desc');
            },
        ])
            ->select(
                'id',
                'comunidad_id',
                'rfe',
                'curp',
                'matricula',)
            ->find($id);

        if (!$inscripcion) {
            return null;
        }

        $comunidad = $inscripcion->comunidad;

        $cursos = $inscripcion->inscripcionesCurso->map(function ($inscripcionCurso) use ($tipo) {

            $materias = $inscripcionCurso->materias->map(function ($materia) {
                return [
                    'id' => $materia->id,
                    'nombre' => $materia->nombre,
                    'acreditada' => (bool)$materia->pivot->cursado,
                ];
            });

            $acreditadas = $inscripcionCurso->materias
                ->filter(fn ($materia) => $materia->pivot->cursado)
                ->count();

            $total = $inscripcionCurso->materias->count();

            return [
                'id' => $inscripcionCurso->id,
                'nombre' => $inscripcionCurso->curso->nombre,
                'estado' => $inscripcionCurso->estado,
                'temporada' => $inscripcionCurso->temporada,
                'fecha_ingreso' => $inscripcionCurso->fecha_formateada,
                'anio' => $inscripcionCurso->anio,
                'materias' => $materias,
                'acreditadas' => $acreditadas,
                'total' => $total,
            ];
        });

        return compact(
            'inscripcion',
            'comunidad',
            'cursos',
        );
    }

    private function getDatosCreateCurso(int $id, string $tipo) {
        $inscripcion = InscripcionEducativa::find($id);
        if (!$inscripcion) return null;
        
        $cursos = Curso::where('tipo', $tipo)->get();

        return compact('inscripcion', 'cursos');
    }
    
    private function getValidate(Request $request, bool $actualizar = false) {
        return $request->validate([
            'comunidad_id' => $actualizar
                ? ['sometimes', 'required', 'integer', 'exists:p_comunidad,id']
                : ['required', 'integer', 'exists:p_comunidad,id', 'unique:inscripciones_educativas,comunidad_id'],

            'rfe'       => ['nullable', 'string', 'max:20'],
            'curp'      => ['nullable', 'string', 'max:20'],
            'matricula' => ['nullable', 'string', 'max:20'],
        ], [
            'comunidad_id.required' => 'Selecciona a una persona de la comunidad.',
            'comunidad_id.integer'  => 'La persona seleccionada no es válida.',
            'comunidad_id.exists'   => 'La persona seleccionada ya no existe.',
            'comunidad_id.unique'   => 'Esta persona ya está registrada en educación.',

            'rfe.max'       => 'El RFE no puede tener más de 20 caracteres.',
            'curp.max'      => 'La CURP no puede tener más de 20 caracteres.',
            'matricula.max' => 'La matrícula no puede tener más de 20 caracteres.',
        ]);
    }

    private function getUsuarias(){
        $personasComunidad = PComunidad::with('colonia')->orderBy('nombre')->get()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->colonia_otro ?? ($p->colonia->nombre ?? null),
            'detalles' => [
                'Edad' => $p->edad ? $p->edad . ' años' : null,
                'Nivel escolar' => $p->nv_escolar ? ucfirst(str_replace('_', ' ', $p->nv_escolar)) : null,
            ],
        ]);

        $yaRegistrados = InscripcionEducativa::pluck('comunidad_id')->all();

        return [$personasComunidad, $yaRegistrados];
    }

    private function getDatosEdit(int $id){
        return InscripcionEducativa::find($id);
    }

    private function getValidateCurso(Request $request, bool $actualizar = false) {
        return $request->validate([
            'fecha_ingreso' => ['required', 'date'],
            'cursos_id'     => $actualizar
                ? ['sometimes', 'required', 'integer', 'exists:cursos,id']
                : ['required', 'integer', 'exists:cursos,id'],
            'dado_de_baja' => $actualizar
                ? ['sometimes', 'nullable', 'boolean']
                : ['prohibited'],
        ], [
            'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
            'fecha_ingreso.date'     => 'La fecha de ingreso no es válida.',
            'cursos_id.required'     => 'Selecciona un curso.',
            'cursos_id.integer'      => 'El curso seleccionado no es válido.',
            'cursos_id.exists'       => 'El curso seleccionado ya no existe.',
            'dado_de_baja.boolean' => 'El valor de "Dado de baja" no es válido.',
            'dado_de_baja.prohibited' => 'Este campo no está permitido en este formulario.',
        ]);
    }

    private function temporadaDe(string $fecha): string {
        return Carbon::parse($fecha)->month <= 6
            ? self::TEMPORADA_PRIMAVERA
            : self::TEMPORADA_OTONO;
    }
    
    private function getCursosPorNivel(string $nivel){
        return Curso::where('tipo', $nivel)->get();
    }

}
