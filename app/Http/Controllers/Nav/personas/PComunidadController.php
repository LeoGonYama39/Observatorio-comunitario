<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use App\Models\PComunidad;
use Illuminate\Support\Facades\DB;

class PComunidadController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $usuarias = $this->getDatosIndex();

        $view = view("system.modules.personas.p_comunidad.index", compact('persona', 'otros', 'usuarias'));

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

        $view = view("system.modules.personas.p_comunidad.show", compact('persona', 'otros'));

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


    ///// Funciones de apoyo/////////////////

    //Obtiene los datos para la tabla index.
    private function getDatosIndex() {
        $usuarias = PComunidad::join(
            'colonia',                  // tabla que quiero unir
            'p_comunidad.colonia_id',   // FK
            '=',                        // operador
            'colonia.id'                // PK
        )
        ->select('p_comunidad.id', 
                 'p_comunidad.nombre', 
                 'p_comunidad.ap_pat',
                 'p_comunidad.ap_mat',
                 'p_comunidad.birth_date',
                 'p_comunidad.genero',
                 'p_comunidad.lider',
                 'p_comunidad.saberes',
                 'colonia.nombre AS colonia')
        ->orderBy('nombre')
        ->get();
        return $usuarias;
    }
}
