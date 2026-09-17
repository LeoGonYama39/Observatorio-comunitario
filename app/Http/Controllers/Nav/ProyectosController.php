<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use App\Models\Proyectos\Proyecto;
use Illuminate\Support\Facades\DB;

class ProyectosController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $proyectos = $this->getDatosIndex();

        $view = view("system.modules.proyectos.index",compact('persona', 'otros', 'proyectos'));

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

        $view = view(
            "system.modules.proyectos.create",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['proyecto' => null]
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
            "system.modules.proyectos.show",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['proyecto' => null]
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

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return Proyecto::with([
            'ejes.responsabilidades.area'
        ])
            ->select(
                'id',
                'nombre',
                'estado',
                'prioritario'
            )
            ->orderBy('nombre')
            ->get();
    }

    private function getDatosShow($id){
        $proyecto = Proyecto::find($id);
        if(!$proyecto) return null;
        $colonias = $proyecto->colonias()
            ->select('colonia.id', 'colonia.nombre')
            ->get();
        $problematicas = $proyecto->problematicas()
            ->select('problematicas.id', 'problematicas.nombre')
            ->get();
        $ejes = $proyecto->ejes;

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

        $involucrados = $proyecto->involucrados;

        $historial = $proyecto->historial()
            ->orderBy('fecha', 'desc')
            ->get();

        return compact(
            'proyecto',
            'colonias',
            'problematicas',
            'areas',
            'responsabilidades',
            'ejes',
            'involucrados',
            'historial'
        );
    }
}
