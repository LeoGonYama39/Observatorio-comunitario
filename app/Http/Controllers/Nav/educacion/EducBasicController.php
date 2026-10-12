<?php

namespace App\Http\Controllers\Nav\educacion;

use App\Http\Controllers\Controller;
use App\Models\Educacion\InscripcionEducativa;
use Illuminate\Http\Request;
use App\Models\PComunidad;
use Illuminate\Support\Facades\DB;

class EducBasicController extends Controller
{
    public function index(Request $request)
    {
        $inscripciones = $this->getDatosIndex();

        $view = view("system.modules.educacion.educ_basica.index", compact('inscripciones'));

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
        $personasComunidad = PComunidad::with('colonia')->get()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->colonia_otro ?? ($p->colonia->nombre ?? null),
            'detalles' => [
                'Edad' => $p->edad ? $p->edad . ' años' : null,
                'Nivel escolar' => $p->nv_escolar ? ucfirst(str_replace('_', ' ', $p->nv_escolar)) : null,
            ],
        ]);

        $yaRegistrados = InscripcionEducativa::pluck('comunidad_id')->all();

        $view = view("system.modules.educacion.educ_basica.create", compact('personasComunidad', 'yaRegistrados'));

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

    public function show(Request $request, $id)
    {
        $datos = $this->getDatosShow($id);

        $view = view('system.modules.educacion.educ_basica.show', array_merge($datos ?? ['inscripcion' => null]));

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
    private function getDatosIndex()
    {
        $inscripciones = InscripcionEducativa::with([
            'comunidad:id,nombre,ap_pat,ap_mat',

            'inscripcionesCurso' => function ($query) {
                $query->whereHas('curso', function ($query) {
                    $query->where('tipo', 'básica');
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
            ->map(function ($inscripcion) {
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
                        ->whereHas('curso', function ($query) {
                            $query->where('tipo', 'media_superior');
                        })
                        ->exists();

                    $estado = $tieneOtroNivel
                        ? 'Registrado en educación media-superior'
                        : 'Sin curso registrado';

                    $nombreCurso = null;
                    $avance = null;
                }

                return [
                    'id' => $inscripcion->id,
                    'nombre' => $persona->nombre,
                    'ap_pat' => $persona->ap_pat,
                    'ap_mat' => $persona->ap_mat,
                    'estado' => $estado,
                    'curso' => $nombreCurso,
                    'avance' => $avance,
                ];
            })
            ->values();
    }

    private function getDatosShow($id) {
        $inscripcion = InscripcionEducativa::with([
            'comunidad:id,nombre,ap_pat,ap_mat,birth_date,genero,colonia_id,colonia_otro',
            'comunidad.colonia:id,nombre',
            'inscripcionesCurso' => function ($query) {
                $query->select(
                    'id',
                    'insc_edu_id',
                    'cursos_id',
                    'fecha_ingreso',
                    'anio',
                    'temporada',
                    'estado'
                )
                    ->whereHas('curso', function ($query) {
                        $query->where('tipo', 'básica');
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

        $cursos = $inscripcion->inscripcionesCurso->map(function ($inscripcionCurso) {

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

}
