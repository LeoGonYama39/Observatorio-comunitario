<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use App\Models\Talleres\Taller;

class TalleresController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $talleres = $this->getDatosIndex();

        $view = view("system.modules.talleres.index", compact(
            'persona',
            'otros',
            'talleres'));

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
    public function create(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $view = view("system.modules.talleres.create", compact('persona', 'otros'));

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
            "system.modules.talleres.show",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['taller' => null]
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


    //---------------------------
    //      Funciones
    //---------------------------

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return Taller::with([
            'ejes.responsabilidades.area'
        ])
            ->select(
                'id',
                'nombre',
                'estado',
            )
            ->orderBy('nombre')
            ->get();
    }

    //Obtiene los datos para la ficha show
    private function getDatosShow($id)
    {
        $taller = Taller::with([
            'ejes.responsabilidades.area',
            'generaciones.talleristasCentro',
            'generaciones.talleristasComunidad',
            'generaciones.talleristasExternos.externo',
            'generaciones.grupos.colonia',
            'instituciones',
            'rolesCentro',
            'rolesComunidad',
            'rolesExternos.externo',
        ])->find($id);

        if (!$taller) {
            return null;
        }

        $ejes = $taller->ejes;

        $areas = collect();
        $responsabilidades = collect();

        foreach ($ejes as $eje) {
            $areas = $areas->merge(
                $eje->responsabilidades->pluck('area')
            );

            $responsabilidades = $responsabilidades->merge(
                $eje->responsabilidades
            );
        }

        $areas = $areas
            ->filter()
            ->unique('id')
            ->sortBy('nombre')
            ->values();

        $responsabilidades = $responsabilidades
            ->unique('id')
            ->sortBy('nombre')
            ->values();

        $involucrados = $taller->involucrados;

        $generaciones = $taller->generaciones()
            ->select(
                'id',
                'taller_id',
                'anio',
                'anio',
                'temporada',
                'evaluacion'
            )
            ->orderByDesc('anio')
            ->orderByDesc('temporada')
            ->get();

        return compact(
            'taller',
            'areas',
            'responsabilidades',
            'ejes',
            'involucrados',
            'generaciones'
        );
    }
}
