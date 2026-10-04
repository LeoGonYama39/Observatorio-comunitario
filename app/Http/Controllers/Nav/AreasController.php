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
    public function index(Request $request) {
        $datos = $this->getDatosIndex();

        $view = view("system.modules.areas.index",
            array_merge($datos ?? ['areas' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function updateResponsableArea(Request $request, Area $area): JsonResponse {
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
