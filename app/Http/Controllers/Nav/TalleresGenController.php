<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Eje;
use App\Models\listas\Institucion;
use App\Models\Participacion;
use App\Models\PCentro;
use App\Models\PComunidad;
use App\Models\PExterno;
use App\Models\Proyectos\Proyecto;
use App\Models\Talleres\TallerGen;
use Illuminate\Http\Request;
use App\Models\Talleres\Taller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TalleresGenController extends Controller
{
    public function create_gen(Request $request, $taller) {
        $datosUsuario = new DatosUsuario();
        $taller = Taller::find($taller);
        $opTemporada = $datosUsuario->getEnumValues("participaciones","temporada");

        $view = view("system.modules.talleres.create_gen", compact("taller", "opTemporada"));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store_gen(Request $request, Taller $taller) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $this->getValidateGen($request);
            TallerGen::create([
                'taller_id'        => $taller->id,
                'anio'        => trim($validated['anio']),
                'temporada'        => trim($validated['temporada']),
                'evaluacion'     => $limpiar($validated['evaluacion'] ?? null),
            ]);


            return redirect()
                ->route('talleres.show', $taller->id)
                ->with('success', 'Grupo registrado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function delete_gen(string $id)
    {
        try {
            $gen = TallerGen::findOrFail($id);
            $taller = $gen->taller_id;
            $gen->delete();

            return redirect()
                ->route('talleres.show', $taller)
                ->with('success', "Grupo eliminado con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('talleres.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
        }
    }

    //----------------------------------------------------
    //              Funciones
    //----------------------------------------------------

    private function getValidateGen(Request $request) {
        $datosUsuario = new DatosUsuario();
        $opTemporada = $datosUsuario->getEnumValues("taller_gen","temporada");

        return $request->validate([
                "temporada"     => ["required", "string", Rule::in($opTemporada),],
                "anio"          => ["required", "digits:4", "integer", "min:1901", "max:2155",],
                'evaluacion'    => ['nullable', 'string'],
            ],[
                "temporada.required"        => "La temporada es obligatoria",
                "temporada.in"              => "La temporada seleccionada no es válida",
                "anio.required"             => "El año es obligatorio",
                "anio.digits"               => "El año debe tener 4 dígitos",
                "anio.min"                  => "El año debe ser mayor o igual a 1901",
                "anio.max"                  => "El año debe ser menor o igual a 2155",
                'evaluacion.string'         => 'La evaluación debe ser texto.',
        ]);
    }
}
