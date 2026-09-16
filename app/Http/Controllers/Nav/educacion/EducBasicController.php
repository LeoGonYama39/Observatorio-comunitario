<?php

namespace App\Http\Controllers\Nav\educacion;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Educacion\InscripcionCurso;
use App\Models\Educacion\InscripcionesEducativa;
use Illuminate\Http\Request;
//use App\Models\;

class EducBasicController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $inscripciones = $this->getDatosIndex();

        $view = view("system.modules.educacion.educ_basica.index", compact(
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

        $view = view("system.modules.educacion.educ_basica.show", compact('persona', 'otros'));

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
        $inscripciones = InscripcionesEducativa::with([
            'comunidad',
            'inscripcionCurso' => function ($query) {
                $query->whereHas('curso', function ($query) {
                    $query->where('tipo', 'básica');                            //A pesar de haber a las personas con cursos de básica, estos pueden tener
                })                                                              //cursos de media-sup, entonces me quedo con los cursos solo de básica
                    ->with([
                        'curso',
                        'curso.materias',
                        'materias',
                    ])
                    ->orderBy('fecha_ingreso', 'desc');
            },
        ])
            ->whereHas('inscripcionCurso.curso', function ($query) {
                $query->where('tipo', 'básica');                //Filtro a las personas de InscripcionesEducativa, para que solo me de los que
            })                                                                 //tienen al menos un curso de básica en su .curso
            ->get();

        return $inscripciones
            ->sortBy(function ($inscripcion) {
                return $inscripcion->comunidad->nombre;
            })
            ->map(function ($inscripcion) {

                $curso = $inscripcion->inscripcionCurso->first();

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
}
