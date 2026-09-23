<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Colonia;
use App\Models\listas\Difucion;
use App\Models\listas\NoTrabaja;
use App\Models\listas\PersonasDependen;
use App\Models\listas\ServicioMedico;
use App\Models\listas\Sustento;
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

    public function create(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDropDownOptions($datosUsuario);

        $view = view(
            "system.modules.personas.p_comunidad.create",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['datos' => null]
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

        $usuaria = $this->getDatosShow($id);

        $view = view("system.modules.personas.p_comunidad.show", compact('persona', 'otros', 'usuaria'));

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
        {
            try {
                $usuaria = PComunidad::findOrFail($id);
                $nombreCompleto = trim($usuaria->nombre . ' ' . $usuaria->ap_pat . ' ' . ($usuaria->ap_mat ?? ''));
                $usuaria->delete();

                return redirect()
                    ->route('personas-usuarias.index')
                    ->with('success', "Persona del usuaria ({$nombreCompleto}) eliminada con éxito.");
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return redirect()
                    ->route('personas-usuarias.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
            } catch (\Throwable $e) {
                return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
        }
    }


    ///// Funciones de apoyo/////////////////

    //Obtiene los datos para la tabla index.
    private function getDatosIndex() {
        $usuarias = PComunidad::leftJoin(
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

    private function getDatosShow($id)
    {
        $usuaria = PComunidad::with([
            'difuciones',
            'sustentos',
            'noTrabajos',
            'serviciosMedicos',
            'personasDependen',
        ])
            ->leftJoin(
                'colonia',
                'p_comunidad.colonia_id',
                '=',
                'colonia.id'
            )
            ->select(
                'p_comunidad.id',
                'p_comunidad.nombre',
                'p_comunidad.ap_pat',
                'p_comunidad.ap_mat',
                'p_comunidad.nv_escolar',
                'p_comunidad.estado_civil',
                'p_comunidad.num_hijos',
                'p_comunidad.ocupacion',
                'p_comunidad.direccion',
                'p_comunidad.colonia_otro',
                'p_comunidad.alcaldia',
                'p_comunidad.alcaldia_otro',
                'p_comunidad.correo',
                'p_comunidad.ingreso_mensual',
                'p_comunidad.tipo_hogar',
                'p_comunidad.tipo_vivienda',
                'p_comunidad.habitantes_menos_18',
                'p_comunidad.habitantes_mas_18',
                'p_comunidad.habitantes_mas_60',
                'p_comunidad.birth_date',
                'p_comunidad.genero',
                'p_comunidad.telefono_celular',
                'p_comunidad.telefono_casa',
                'p_comunidad.lider',
                'p_comunidad.saberes',
                'colonia.nombre AS colonia'
            )
            ->where('p_comunidad.id', $id)
            ->first();

        return $usuaria;
    }

    private function getDropDownOptions($datosUsuario) {
        $generos = $datosUsuario->getEnumValues('p_comunidad', 'genero');
        $estadoCivil = $datosUsuario->getEnumValues('p_comunidad', 'estado_civil');
        $nvEscolar = $datosUsuario->getEnumValues('p_comunidad', 'nv_escolar');
        $alcaldia = $datosUsuario->getEnumValues('p_comunidad', 'alcaldia');
        $ingresoMensual = $datosUsuario->getEnumValues('p_comunidad', 'ingreso_mensual');
        $tipoHogar = $datosUsuario->getEnumValues('p_comunidad', 'tipo_hogar');
        $tipoVivienda = $datosUsuario->getEnumValues('p_comunidad', 'tipo_vivienda');
        $difuciones = Difucion::select('id', 'nombre')->get();
        $sustentos = Sustento::select('id', 'nombre')->get();
        $noTrabaja = NoTrabaja::select('id', 'nombre')->get();
        $serviciosMedicos = ServicioMedico::select('id', 'nombre')->get();
        $personasDependen = PersonasDependen::select('id', 'nombre')->get();
        $colonias = Colonia::select('id', 'nombre')->get();

        return compact(
            'generos',
            'estadoCivil',
            'nvEscolar',
            'alcaldia',
            'ingresoMensual',
            'tipoHogar',
            'tipoVivienda',
            'difuciones',
            'sustentos',
            'noTrabaja',
            'serviciosMedicos',
            'personasDependen',
            'colonias'
        );
    }
}
