<?php

namespace App\Http\Controllers\Nav\psicopedag;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Psicopedagogia\atencion_individual\Expediente;
use Illuminate\Http\Request;

class AtenPersController extends Controller
{
    public function index(Request $request)
    {
        $support = new DatosUsuario;
        $expedientes = $this->getDatosIndex();
        $tipos = $support->getEnumValues('caso', 'tipo');
        $estados = $support->getEnumValues('caso', 'estado');
        $view = view("system.modules.psicopedag.aten_pers.index",
            compact('expedientes',
                    'estados',
                    'tipos'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, $id)
    {
        $view = view("system.modules.psicopedag.aten_pers.show");

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }

    //---------------------------------
    //          Funciones
    //---------------------------------

    private function getDatosIndex(){
        return Expediente::with([
        'casoMasReciente.seguimientoMasReciente',
        'comunidad:id,nombre,ap_pat,ap_mat'
        ])
        ->join('p_comunidad', 'expediente.comunidad_id', '=', 'p_comunidad.id')
        ->orderBy('p_comunidad.nombre')
        ->select('expediente.*')
        ->get();
    }
}
