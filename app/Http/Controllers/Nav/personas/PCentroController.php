<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use App\Models\PCentro;

class PCentroController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $centros = $this->getDatosIndex();

        $view = view("system.modules.personas.p_centro.index", compact('persona', 'otros', 'centros'));

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
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $centros = PCentro::select('id', 'nombre', 'ap_pat', 'ap_mat', 'cargo')->get();

        $view = view("system.modules.personas.p_centro.create", compact('persona', 'otros', 'centros'));

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

        $centro = $this->getDatosShow($id);

        $view = view("system.modules.personas.p_centro.show", compact('persona', 'otros', 'centro'));

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
    private function getDatosIndex() {
        return PCentro::leftJoin(
            'area',             // Tabla a unir
            'area.centro_id',   // FK
            '=',                // Operador
            'p_centro.id'       // PK
        )
        ->select(
            'p_centro.id',
            'p_centro.nombre',
            'p_centro.ap_pat',
            'p_centro.ap_mat',
            'p_centro.cargo',
            'area.nombre AS area'
        )
        ->orderBy('p_centro.nombre')
        ->get();
    }

    //Obtiene los datos para ficha show
    private function getDatosShow($id) {
        return PCentro::leftJoin(
            'area',             // Tabla a unir
            'area.centro_id',   // FK
            '=',                // Operador
            'p_centro.id'       // PK
        )
        ->select(
            'p_centro.id',
            'p_centro.nombre',
            'p_centro.ap_pat',
            'p_centro.ap_mat',
            'p_centro.cargo',
            'area.nombre AS area'
        )
        ->where('p_centro.id', $id)
        ->first();
    }
}
