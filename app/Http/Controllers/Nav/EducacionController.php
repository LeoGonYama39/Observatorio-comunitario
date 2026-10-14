<?php

//Controlador para ambos tipos de educación: básica y media-superior

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Models\Educacion\InscripcionEducativa;
use Illuminate\Http\Request;
use App\Models\PComunidad;
use Illuminate\Support\Facades\DB;

class EducacionController extends Controller
{
    public function index_basica(Request $request)
    {
        $inscripciones = $this->getDatosIndex('básica', 'media_superior');
        $etiqueta = 'educación básica';
        $rutaCreate = route('educ_basica.create');

        $view = view("system.modules.educacion.index", compact('inscripciones', 'etiqueta', 'rutaCreate'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function index_sup(Request $request)
    {
        $inscripciones = $this->getDatosIndex('media_superior', 'básica');
        $etiqueta = 'educación media superior';
        $rutaCreate = route('educ_sup.create');

        $view = view("system.modules.educacion.index", compact('inscripciones', 'etiqueta', 'rutaCreate'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function show_basica(Request $request, string $id)
    {
        $datos = $this->getDatosShow((int)$id, 'básica');
        $etiqueta = 'educación básica';
        $rutaIndex = route('educ_basica.index');

        $view = view(
            'system.modules.educacion.show',
                        array_merge(
                            compact('etiqueta', 'rutaIndex'),
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

    public function show_sup(Request $request, string $id)
    {
        $datos = $this->getDatosShow((int)$id, 'media_superior');
        $etiqueta = 'educación media superior';
        $rutaIndex = route('educ_sup.index');

        $view = view(
            'system.modules.educacion.show',
                        array_merge(
                            compact('etiqueta', 'rutaIndex'),
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

    public function create_basica(Request $request)
    {
        [$personasComunidad, $yaRegistrados] = $this->getUsuarias();
        $rutaIndex = route('educ_basica.index');
        $etiqueta = 'Educación básica';

        $view = view("system.modules.educacion.create", compact(
            'personasComunidad',
            'yaRegistrados',
            'rutaIndex',
            'etiqueta'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function create_sup(Request $request)
    {
        [$personasComunidad, $yaRegistrados] = $this->getUsuarias();
        $rutaIndex = route('educ_sup.index');
        $etiqueta = 'Educación media superior';

        $view = view("system.modules.educacion.create", compact(
            'personasComunidad',
            'yaRegistrados',
            'rutaIndex',
            'etiqueta'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store(Request $request) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
    
        try {
            $validated = $this->getValidate($request);
    
            $inscripcion = DB::transaction(function () use ($validated, $limpiar) {
                return InscripcionEducativa::create([
                    'comunidad_id' => $validated['comunidad_id'],
                    'rfe'          => $limpiar($validated['rfe'] ?? null),
                    'curp'         => $limpiar($validated['curp'] ?? null),
                    'matricula'    => $limpiar($validated['matricula'] ?? null),
                ]);
            });
    
            return redirect()
                ->route('educ_basica.show', $inscripcion->id)
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

    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //-------------------
    //  Funciones
    //------------------
    private function getDatosIndex(string $tipo, string $otro)
    {
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
                    $avance = "$acreditadas de $total acreditadas";
                } else {
                    // ¿Tiene algún curso de educación media-superior?
                    $tieneOtroNivel = $inscripcion->inscripcionesCurso()
                        ->whereHas('curso', function ($query) use ($otro) {
                            $query->where('tipo', $otro);
                        })
                        ->exists();

                    $estado = $tieneOtroNivel
                        ? 'Registrado en educación ' . $otro
                        : 'Sin curso registrado';

                    $nombreCurso = null;
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
                    'anio',
                    'temporada',
                    'estado'
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
                'curp')
            ->find($id);

        if (!$inscripcion) {
            return null;
        }

        $comunidad = $inscripcion->comunidad;

        $cursos = $inscripcion->inscripcionesCurso->map(function ($inscripcionCurso) use ($tipo) {

            $materias = $inscripcionCurso->materias->map(function ($materia) {
                return [
                    'nombre' => $materia->nombre,
                    'acreditada' => (bool)$materia->pivot->cursado,
                ];
            });

            $acreditadas = $inscripcionCurso->materias
                ->filter(fn ($materia) => $materia->pivot->cursado)
                ->count();

            $total = $inscripcionCurso->curso->materias->count();

            return [
                'id' => $inscripcionCurso->id,
                'nombre' => $inscripcionCurso->curso->nombre,
                'estado' => $inscripcionCurso->estado,
                'anio' => $inscripcionCurso->anio,
                'temporada' => $inscripcionCurso->temporada,
                'fecha_ingreso' => $inscripcionCurso->fecha_formateada,
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

    private function getValidate(Request $request) {
        return $request->validate([
            'comunidad_id' => ['required', 'integer', 'exists:p_comunidad,id', 'unique:inscripciones_educativas,comunidad_id'],
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

}
