<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Area;
use App\Models\Areas\Responsabilidad;
use App\Models\PCentro;
use Illuminate\Http\JsonResponse;

class AreasController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDatosIndex();

        $view = view(
            "system.modules.areas.index",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['areas' => null]
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

    public function updateResponsableArea(Request $request, Area $area): JsonResponse
    {
        $validated = $request->validate([
            'responsable_id' => ['required', 'exists:p_centro,id'],
        ]);
 
        $area->update(['centro_id' => $validated['responsable_id']]);
 
        return response()->json(['ok' => true]);
    }
 
    public function updateResponsableResponsabilidad(Request $request, Responsabilidad $responsabilidad): JsonResponse
    {
        $validated = $request->validate([
            'responsable_id' => ['required', 'exists:p_centro,id'],
        ]);
 
        $responsabilidad->update(['centro_id' => $validated['responsable_id']]);
 
        return response()->json(['ok' => true]);
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    //--------------------------------
    //          Función
    //--------------------------------

    private function getDatosIndex(){
        $areas = Area::with('responsabilidades')
        ->select(
            'id',
            'nombre',
            'centro_id'
        )
        ->get();

        if(!$areas) return null;

        $centros = PCentro::with([
            'areas:id,nombre,centro_id',
            'responsabilidades:id,nombre,area_id,centro_id'
        ])
            ->select(
                'id',
                'nombre',
                'ap_pat',
                'ap_mat',
            )
            ->orderBy('nombre')
            ->get();

        return compact(
            'areas',
            'centros',
        );
    }

}
