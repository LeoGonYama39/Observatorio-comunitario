<?php

namespace App\Http\Controllers\Sistema\Talleres;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\Personas\PComunidad;
use App\Models\Talleres\Taller;
use App\Models\Talleres\TallerGen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TalleresGenController extends Controller
{
    public function create_gen(Request $request, int $taller) {
        $datosUsuario = new SupportController();
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
                'taller_id'     => $taller->id,
                'anio'          => trim($validated['anio']),
                'temporada'     => trim($validated['temporada']),
                'evaluacion'    => $limpiar($validated['evaluacion']),
                'observacion'   => $limpiar($validated['observacion']),
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

    public function edit_grupo(Request $request, int $grupo) {
        $datosUsuario = new SupportController();
        $grupo = TallerGen::find($grupo);
        $opTemporada = $datosUsuario->getEnumValues("taller_gen","temporada");
        $usuarias = $this->getUsuarias();

        $view = view("system.modules.talleres.editar_grupo", compact("grupo", "opTemporada", 'usuarias'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update_grupo(Request $request, TallerGen $grupo)
    {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        try {
            $validated = $this->getValidateGen($request);

            DB::transaction(function () use ($validated, $request, $grupo, $limpiar) {
                $grupo->anio        = $validated['anio'];
                $grupo->temporada   = $validated['temporada'];
                $grupo->evaluacion  = $limpiar($validated['evaluacion']);
                $grupo->observacion = $limpiar($validated['observacion']);
                $grupo->save();

                $idsGrupo = $request->input('grupo', []);
                $bajas = $request->input('baja', []);

                $sync = [];
                foreach ($idsGrupo as $comunidadId) {
                    $sync[$comunidadId] = ['baja' => isset($bajas[$comunidadId]) ? 1 : 0];
                }

                $grupo->grupo()->sync($sync);
            });

            return redirect()
                ->route('talleres.show', $grupo->taller->id)
                ->with('success', 'Grupo actualizado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    //----------------------------------------------------
    //              Funciones
    //----------------------------------------------------

    private function getValidateGen(Request $request) {
        $datosUsuario = new SupportController();
        $opTemporada = $datosUsuario->getEnumValues("taller_gen", "temporada");

        return $request->validate([
            "temporada"     => ["required", "string", Rule::in($opTemporada)],
            "anio"          => ["required", "digits:4", "integer", "min:1901", "max:2155"],
            'evaluacion'    => ['nullable', 'string', 'max:5000'],
            'observacion'   => ['nullable', 'string', 'max:5000'],

            'grupo'         => ['nullable', 'array'],
            'grupo.*'       => ['integer', 'distinct', 'exists:p_comunidad,id'],

            'baja'          => ['nullable', 'array'],
            'baja.*'        => ['boolean'],
        ],[
            "temporada.required"        => "La temporada es obligatoria",
            "temporada.in"              => "La temporada seleccionada no es válida",
            "anio.required"             => "El año es obligatorio",
            "anio.digits"               => "El año debe tener 4 dígitos",
            "anio.min"                  => "El año debe ser mayor o igual a 1901",
            "anio.max"                  => "El año debe ser menor o igual a 2155",

            'evaluacion.string'     => 'La evaluacion deben ser texto.',
            'evaluacion.max'        => 'El límite para evaluación es de 5000 caracteres.',
            'observacion.string'    => 'La observación debe ser texto.',
            'observacion.max'       => 'El límite para observación es de 5000 caracteres.',

            'grupo.array'       => 'La lista de participantes no es válida.',
            'grupo.*.integer'   => 'Uno de los participantes seleccionados no es válido.',
            'grupo.*.distinct'  => 'Hay participantes repetidos en la lista.',
            'grupo.*.exists'    => 'Uno de los participantes seleccionados ya no existe.',
            'baja.array'        => 'El estado de baja enviado no es válido.',
            'baja.*.boolean'    => 'El estado de baja de alguno de los participantes no es válido.',
        ]);
    }

    private function getUsuarias(){
        return PComunidad::select(
                'id',
                'nombre',
                'ap_pat',
                'ap_mat',
                'colonia_otro',
                'colonia_id',
            )
            ->orderBy('nombre')
            ->get();
    }

}
