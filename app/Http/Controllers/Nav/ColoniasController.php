<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\listas\Problematica;
use Illuminate\Http\Request;
use App\Models\Colonia;
use App\Models\HistorialColonia;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ColoniasController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $colonias = $this->getDatosIndex();

        $view = view("system.modules.colonias.index", compact('colonias'));

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
        $datos = $this->getDatosShow($id);

        $colonia = $datos['colonia'];
        $problematicas = $datos['problematicas'];
        $proyectos = $datos['proyectos'];
        $historial = $datos['historial'];

        $view = view("system.modules.colonias.show", compact('colonia', 'problematicas', 'proyectos', 'historial'));

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
    public function edit(Request $request, $id)
    {
        $colonia = Colonia::find($id);
        $problematicas = Problematica::select('id', 'nombre')->get();

        $view = view("system.modules.colonias.edit", compact('colonia', 'problematicas'));

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
     * Update the specified resource in storage.
     */
    public function update(Request $request, Colonia $colonia) {
        try {
            $validated = $this->getValidate($request);

            DB::transaction(function () use ($colonia, $validated, $request) {
                $colonia->viviendas = $validated['viviendas'];
                $colonia->adultos = $validated['adultos'];
                $colonia->ninos = $validated['ninos'];
                $colonia->save();

                $colonia->problematicas()->sync($validated['problematicas'] ?? []);
            });

            return redirect()
                ->route('colonias.show', $colonia->id)
                ->with('success', 'Cambio registrado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
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

    private function getValidate($request) {
        return $request->validate([
            'viviendas'    => ['required', 'integer', 'min:0', 'max:16777215'],
            'adultos'    => ['required', 'integer', 'min:0', 'max:16777215'],
            'ninos'    => ['required', 'integer', 'min:0', 'max:16777215'],

            'problematicas' => ['nullable', 'array'],
            'problematicas.*' => ['integer', 'distinct', 'exists:problematicas,id'],
        ],[
            'viviendas.integer' => 'El número de viviendas debe ser un número entero positivo.',
            'viviendas.min'     => 'El número de viviendas no puede ser negativo.',
            'viviendas.max'     => 'El número de viviendas no puede ser más de 16,777,215.',

            'adultos.integer' => 'El número de adultos debe ser un número entero positivo.',
            'adultos.min'     => 'El número de adultos no puede ser negativo.',
            'adultos.max'     => 'El número de adultos no puede ser más de 16,777,215.',

            'ninos.integer' => 'El número de niños debe ser un número entero positivo.',
            'ninos.min'     => 'El número de niños no puede ser negativo.',
            'ninos.max'     => 'El número de niños no puede ser más de 16,777,215.',

            'problematicas.array' => 'Las problemáticas seleccionadas no son válidas.',
            'problematicas.*.integer' => 'Una de las problemáticas seleccionadas no es válida.',
            'problematicas.*.distinct' => 'Una de las problemáticas seleccionadas está repetida',
            'problematicas.*.exists' => 'Una de las problemáticas seleccionadas no existe.',
        ]);
    }
}


