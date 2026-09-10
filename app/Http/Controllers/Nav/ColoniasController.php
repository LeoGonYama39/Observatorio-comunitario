<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use App\Models\Colonia;
use App\Models\HistorialColonia;
use Illuminate\Support\Facades\DB;

class ColoniasController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $colonias = $this->getDatosIndex();

        $view = view("system.modules.colonias.index", compact('persona', 'otros', 'colonias'));

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

        $colonia = $datos['colonia'];
        $problematicas = $datos['problematicas'];
        $proyectos = $datos['proyectos'];
        $historial = $datos['historial'];

        $view = view("system.modules.colonias.show", compact('persona', 'otros', 'colonia', 'problematicas', 'proyectos', 'historial'));

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


    //////Funciones para búsquedas

    private function getDatosIndex() {
        $colonias = Colonia::leftJoinSub(
            Colonia::join(
                'proyecto_colonia',
                'colonia.id',
                '=',
                'proyecto_colonia.colonia_id'
            )
            ->select(
                'colonia.id',
                DB::raw('COUNT(colonia.id) AS c')
            )
            ->groupBy('colonia.id'),
            'num',
            'colonia.id',
            '=',
            'num.id'
        )
        ->select(
            'colonia.id',
            'colonia.nombre',
            'colonia.adultos',
            'colonia.ninos',
            'num.c'
        )
        ->orderBy('colonia.nombre')
        ->get();

        return $colonias;
    }

    private function getDatosShow($id){
        $datos = [];
    
        $colonia = Colonia::select(
            'id', 
            'nombre', 
            'adultos',
            'ninos',
            'viviendas',)
        ->where('id', $id)
        ->first();

        $problematicas = Colonia::join(
            'problem_colonia',
            'colonia.id',
            '=',
            'problem_colonia.colonia_id'
        )
        ->join(
            'problematicas',
            'problem_colonia.problematica_id',
            '=',
            'problematicas.id'
        )
        ->where('colonia.id', $id)
        ->pluck('problematicas.nombre');

        $proyectos = Colonia::join(
            'proyecto_colonia',
            'colonia.id',
            '=',
            'proyecto_colonia.colonia_id'
        )
        ->join(
            'proyecto',
            'proyecto_colonia.proyecto_id',
            '=',
            'proyecto.id'
        )
        ->where('colonia.id', $id)
        ->pluck('proyecto.nombre');

        $historial = HistorialColonia::where(
            'colonia_id',
            $id
        )
        ->select(
            'fecha',
            'comentario'
        )
        ->orderBy('fecha', 'desc')
        ->get();

        return [
            'colonia' => $colonia,
            'problematicas' => $problematicas,
            'proyectos' => $proyectos,
            'historial' => $historial,
        ];
    }
}
