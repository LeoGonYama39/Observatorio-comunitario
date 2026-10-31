<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\Colonias\Colonia;
use App\Models\Colonias\HistorialColonia;
use App\Models\ListaOpciones\Problematica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColoniasController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new SupportController();
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

    public function create(Request $request)
    {
        $problematicas = Problematica::select('id', 'nombre')->get();
        $view = view("system.modules.colonias.create", compact('problematicas'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store(Request $request) {
        try {
            $validated = $this->getValidate($request);

            $colonia = DB::transaction(function () use ($validated) {
                $colonia = Colonia::create([
                    'nombre'    => trim($validated['nombre']),
                    'viviendas' => $validated['viviendas'] ?? null,
                    'adultos'   => $validated['adultos'] ?? null,
                    'ninos'     => $validated['ninos'] ?? null,
                ]);
                $colonia->problematicas()->sync($validated['problematicas'] ?? []);
                return $colonia;
            });

            return redirect()
                ->route('colonias.show', $colonia->id)
                ->with('success', 'Colonia registrada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function show(Request $request, int $id)
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
    public function edit(Request $request, int $id)
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


    public function update(Request $request, Colonia $colonia) {
        try {
            $validated = $this->getValidate($request);

            DB::transaction(function () use ($colonia, $validated, $request) {
                $colonia->nombre = trim($validated['nombre']);
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


    public function destroy(string $id) {
        try {
            $colonia = Colonia::findOrFail($id);
            $nombre = $colonia->nombre;
            $colonia->delete();

            return redirect()
            ->route('colonias.index')
            ->with('success', "Colonia ({$nombre}) eliminada con éxito.");
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return redirect()
                ->route('colonias.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
            } catch (\Throwable $e) {
                return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
    }

    public function create_historial(Request $request, int $id) {
        $colonia = Colonia::find($id);
        $entidad = $colonia;
        $nombreEntidad = $colonia?->nombre;
        $nombreIndex = 'Colonias';
        $rutaIndex = route('colonias.index');
        $rutaShow = route('colonias.show', $id);
        $rutaStore = route('colonias.historial.store', $id);

        $view = view(
            'system.parts.forms.create_historial',
            compact(
                'entidad',
                'nombreEntidad',
                'nombreIndex',
                'rutaIndex',
                'rutaShow',
                'rutaStore'
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

    public function store_historial(Request $request, Colonia $colonia) {
        $datosUsuario = new SupportController();
        try {
            $validated = $datosUsuario->getValidateHistorial($request);

            HistorialColonia::create([
                'colonia_id'   => $colonia->id,
                'fecha'         => $validated['fecha'],
                'comentario'    => $validated['comentario'],
            ]);

            return redirect()
                ->route('colonias.show', $colonia->id)
                ->with('success', 'Registro de historial creado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy_historial(int $id) {
        try {
            $historial = HistorialColonia::findOrFail($id);
            $proyecto = $historial->colonia->id;
            $historial->delete();

            return redirect()
                ->route('colonias.show', $proyecto)
                ->with('success', "Nota eliminada con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('colonias.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
        }
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

    private function getDatosShow(int $id){
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
            'comentario',
            'id AS historial_id',
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

    private function getValidate(Request $request) {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'viviendas'    => ['nullable', 'integer', 'min:0', 'max:16777215'],
            'adultos'    => ['nullable', 'integer', 'min:0', 'max:16777215'],
            'ninos'    => ['nullable', 'integer', 'min:0', 'max:16777215'],

            'problematicas' => ['nullable', 'array'],
            'problematicas.*' => ['integer', 'distinct', 'exists:problematicas,id'],
        ],[
            'nombre.required' => 'El nombre de la colonia es obligatorio.',
            'nombre.string' => 'El nombre de la colonia debe ser una cadena de texto.',
            'nombre.max' => 'El nombre de la colonia no puede tener más de 100 caracteres.',

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


