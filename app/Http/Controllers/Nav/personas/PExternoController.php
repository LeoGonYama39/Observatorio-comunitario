<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use App\Models\PExterno;
use Illuminate\Support\Facades\DB;

class PExternoController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $ultimaParticipacion = $this->queryUltimasParticipaciones();
        $externos = $this->getDatosIndex($ultimaParticipacion);

        $view = view("system.modules.personas.p_externo.index", compact('persona', 'otros', 'externos'));

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

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $view = view("system.modules.personas.p_externo.show", compact('persona', 'otros'));

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

    //Funciones de apoyo para querys

    //Regresa la tabla de "participaciones" pero únicamente con las participaciones más
    //recientes de cada externo_id
    private function queryUltimasParticipaciones() {
        $ultimaParticipacion = DB::query()  //Objeto con el que creo querys en Laravel
        ->fromSub(                          //->fromSub($consulta, 'p'), o sea, agarra $consulta, la llama como p, y hace el where
            DB::table('participaciones')    //Indica a Laravel que se trabajará directo con la tabla, como el FROM participaciones del query
            ->select('participaciones.*',   //el SELECT, entiende participaciones.*
                DB::raw('                   
                    ROW_NUMBER() OVER (
                    PARTITION BY externo_id
                    ORDER BY anio DESC, temporada DESC
                    ) AS rn
                    ')  //Pero Laravel no entiende algunas cosas, por eso el raw mete sql crudo
                ),
            'p'
        )
        ->where('rn', 1);               //El where de la fromSub, agarra toda la consulta,
                                        //lo pasa por el where y regresa ese resultado

        return $ultimaParticipacion;
    }

    //Como referencia: el query en sql
    /**
     * 
     * 
     * SELECT *
     * FROM (
     *     SELECT
     *         participaciones.*,
     *         ROW_NUMBER() OVER (
     *             PARTITION BY externo_id
     *             ORDER BY anio DESC, temporada DESC
     *         ) AS rn
     *     FROM participaciones
     * ) AS p
     * WHERE rn = 1;
     * 
     */

    //Obtiene los datos para la tabla index, con ayuda de queryUltimasParticipaciones
    private function getDatosIndex($ultimaParticipacion) {
        $externos = PExterno::leftJoinSub(
            $ultimaParticipacion,               //Tabla a unir
            'ultima_participacion',              //Nombre de lo que se unirá, como AS
            'ultima_participacion.externo_id',   //FK a unir
            '=',                                //Operador
            'p_externo.id'                      //pk
        )
        ->select(
            'p_externo.nombre',
            'p_externo.ap_pat',
            'p_externo.ap_mat',
            'p_externo.universidad',
            'ultima_participacion.tipo',
            'ultima_participacion.anio',
            'ultima_participacion.temporada',)
        ->orderBy('p_externo.nombre')
        ->get();
        return $externos;
    }

    //Detectar los que su última participación ya no es activa
    private function normalizarUI($externos)
    {
        foreach($externos as $externo) {
            if(isset($externo->tipo)){
                $externo->tipo =  ucfirst(str_replace('_', ' ', 'practica_psicología'));
            }
        }
        return $externos;
    }
}
