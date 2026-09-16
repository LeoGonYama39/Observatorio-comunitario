<?php

namespace App\Http\Controllers\Nav\educacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Educacion\InscripcionEducativa;
use Illuminate\Http\Request;
//use App\Models\;

class EducSupController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $inscripciones = $this->getDatosIndex();

        $view = view("system.modules.educacion.educ_sup.index", compact(
            'persona',
            'otros',
            'inscripciones'));

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
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDatosShow($id);

        $view = view(
            'system.modules.educacion.educ_sup.show',
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['inscripcion' => null]
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

    //----------------
    //      Funciones
    //----------------

    private function getDatosIndex()
    {
        $inscripciones = InscripcionEducativa::with([
            'comunidad:id,nombre,ap_pat,ap_mat',
            'inscripcionesCurso' => function ($query) {
                $query->whereHas('curso', function ($query) {
                    $query->where('tipo', 'media_superior');                            //A pesar de haber a las personas con cursos de básica, estos pueden tener
                })                                                              //cursos de media-sup, entonces me quedo con los cursos solo de básica
                ->with([
                    'curso',
                    'curso.materias',
                    'materias',
                ])
                    ->orderBy('fecha_ingreso', 'desc');
            },
        ])
            ->whereHas('inscripcionesCurso.curso', function ($query) {
                $query->where('tipo', 'media_superior');                //Filtro a las personas de InscripcionEducativa, para que solo me de los que
            })                                                                 //tienen al menos un curso de básica en su .curso
            ->get();

        return $inscripciones
            ->sortBy(function ($inscripcion) {
                return $inscripcion->comunidad->nombre;
            })
            ->map(function ($inscripcion) {

                $curso = $inscripcion->inscripcionesCurso->first();

                $acreditadas = $curso->materias
                    ->filter(fn ($materia) => $materia->pivot->cursado)
                    ->count();

                $total = $curso->curso->materias->count();

                return [
                    'id' => $inscripcion->id,
                    'nombre' => $inscripcion->comunidad->nombre,
                    'ap_pat' => $inscripcion->comunidad->ap_pat,
                    'ap_mat' => $inscripcion->comunidad->ap_mat,
                    'estado' => $curso->estado,
                    'curso' => $curso->curso->nombre,
                    'avance' => "$acreditadas de $total",
                ];
            })
            ->values();
    }

    private function getDatosShow($id)
    {
        $inscripcion = InscripcionEducativa::with([
            'comunidad:id,nombre,ap_pat,ap_mat,birth_date,genero,colonia_id',
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
                        $query->where('tipo', 'media_superior');
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
                'matricula',
                'curp')
            ->find($id);

        if (!$inscripcion) return null;

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
