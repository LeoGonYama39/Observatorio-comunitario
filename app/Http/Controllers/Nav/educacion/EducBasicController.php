<?php

namespace App\Http\Controllers\Nav\educacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Educacion\InscripcionCurso;
use App\Models\Educacion\InscripcionEducativa;
use Illuminate\Http\Request;
//use App\Models\;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

}
