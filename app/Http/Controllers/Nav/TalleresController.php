<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Eje;
use Illuminate\Http\Request;
use App\Models\Talleres\Taller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TalleresController extends Controller
{
    public function index(Request $request) {
        $talleres = $this->getDatosIndex();

        $view = view("system.modules.talleres.index", compact('talleres'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function create(Request $request) {
        $datosUsuario = new DatosUsuario();
        $datos = $this->getOptions($datosUsuario);

        $view = view("system.modules.talleres.create",
            array_merge(
                $datos ?? ['datos' => null]));

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
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $this->getValidate($request);

            $taller = DB::transaction(function () use ($validated, $request, $limpiar) {
                $taller = Taller::create([
                    'nombre'        => trim($validated['nombre']),
                    'estado'        => trim($validated['estado']),
                    'objetivos'     => $limpiar($validated['objetivos'] ?? null),
                    'alcance'       => $limpiar($validated['alcance'] ?? null),
                    'evaluacion'    => $limpiar($validated['evaluacion'] ?? null),
                    'repo'          => $limpiar($validated['repo'] ?? null),
                    'auditable'     => $limpiar($validated['auditable'] ?? null),
                    'pobl_obj_low'  => $validated['pobl_obj_low'] ?? null,
                    'pobl_obj_high' => $validated['pobl_obj_high'] ?? null,
                ]);

                $taller->ejes()->sync($validated['ejes'] ?? []);
                return $taller;
            });

            return redirect()
                ->route('talleres.show', $taller->id)
                ->with('success', 'Taller registrado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $id) {
        $datos = $this->getDatosShow($id);

        $view = view(
            "system.modules.talleres.show",
            array_merge($datos ?? ['taller' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function edit(Request $request, $id) {
        $datosUsuario = new DatosUsuario();
        $datos = $this->getDatosEdit($id, $datosUsuario);

        $view = view("system.modules.talleres.edit",
            array_merge(
                $datos ?? ['taller' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }


    public function update(Request $request, Taller $tallere) {
        $datosUsuario = new DatosUsuario();
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $this->getValidate($request);

            DB::transaction(function () use ($tallere, $validated, $request, $limpiar) {
                $tallere->nombre = trim($validated['nombre']);
                $tallere->estado = trim($validated['estado']);
                $tallere->objetivos = $limpiar($validated['objetivos'] ?? null);
                $tallere->alcance  = $limpiar($validated['alcance'] ?? null);
                $tallere->evaluacion = $limpiar($validated['evaluacion'] ?? null);
                $tallere->repo = $limpiar($validated['repo'] ?? null);
                $tallere->auditable = $limpiar($validated['auditable'] ?? null);
                $tallere->pobl_obj_low = $validated['pobl_obj_low'] ?? null;
                $tallere->pobl_obj_high = $validated['pobl_obj_high'] ?? null;

                $tallere->save();

                // Tablas intermedias: sync() recibe directamente la lista de ids ya validada
                $tallere->ejes()->sync($validated['ejes'] ?? []);
            });

            return redirect()
                ->route('talleres.show', $tallere->id)
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
        try {
            $taller = Taller::findOrFail($id);
            $nombre = $taller->nombre;
            $taller->delete();

            return redirect()
                ->route('talleres.index')
                ->with('success', "Taller ({$nombre}) eliminado con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('talleres.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
        }
    }

    //---------------------------
    //      Funciones
    //---------------------------

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return Taller::with([
            'ejes.responsabilidades.area'
        ])
            ->select(
                'id',
                'nombre',
                'estado',
            )
            ->orderBy('nombre')
            ->get();
    }

    //Obtiene los datos para la ficha show
    private function getDatosShow($id)
    {
        $taller = Taller::with([
            'ejes.responsabilidades.area',
            'generaciones.talleristasCentro',
            'generaciones.talleristasComunidad',
            'generaciones.talleristasExternos.externo',
            'generaciones.grupos.colonia',
            'instituciones',
            'rolesCentro',
            'rolesComunidad',
            'rolesExternos.externo',
        ])->find($id);

        if (!$taller) {
            return null;
        }

        $ejes = $taller->ejes;

        $areas = collect();
        $responsabilidades = collect();

        foreach ($ejes as $eje) {
            $areas = $areas->merge(
                $eje->responsabilidades->pluck('area')
            );

            $responsabilidades = $responsabilidades->merge(
                $eje->responsabilidades
            );
        }

        $areas = $areas
            ->filter()
            ->unique('id')
            ->sortBy('nombre')
            ->values();

        $responsabilidades = $responsabilidades
            ->unique('id')
            ->sortBy('nombre')
            ->values();

        $involucrados = $taller->involucrados;

        $generaciones = $taller->generaciones()
            ->select(
                'id',
                'taller_id',
                'anio',
                'anio',
                'temporada',
                'evaluacion'
            )
            ->orderByDesc('anio')
            ->orderByDesc('temporada')
            ->get();

        return compact(
            'taller',
            'areas',
            'responsabilidades',
            'ejes',
            'involucrados',
            'generaciones'
        );
    }

    private function getOptions($datosUsuario){
        $ejes = Eje::select('id', 'nombre')->get();
        $estado = $datosUsuario->getEnumValues('taller', 'estado');

        return compact('ejes', 'estado');
    }

    private function getValidate($request) {
        $datosUsuario = new DatosUsuario();

        return $request->validate([
            'nombre'        => ['required', 'string', 'max:50'],
            'estado'        => ['required', 'string', Rule::in($datosUsuario->getEnumValues('taller', 'estado'))],
            'repo'          => ['nullable', 'url', 'max:2048'],
            'auditable'     => ['nullable', 'url', 'max:2048'],
            'objetivos'     => ['nullable', 'string'],
            'alcance'       => ['nullable', 'string'],
            'evaluacion'    => ['nullable', 'string'],

            'pobl_obj_low'  => ['nullable', 'integer', 'min:3', 'max:60'],
            'pobl_obj_high' => ['nullable', 'integer', 'min:3', 'max:60', 'gte:pobl_obj_low'],

            'ejes'          => ['nullable', 'array'],
            'ejes.*'        => ['integer', 'distinct', 'exists:eje,id'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',

            'antecedentes.string' => 'Los antecedentes deben ser texto.',
            'objetivos.string' => 'Los objetivos deben ser texto.',
            'alcance.string' => 'El alcance debe ser texto.',
            'evaluacion.string' => 'La evaluación debe ser texto.',

            'repo.string' => 'El enlace del repositorio debe ser texto.',
            'repo.max' => 'El enlace del repositorio no puede tener más de 2048 caracteres.',
            'repo.url' => 'El enlace del repositorio no es válido.',

            'auditable.string' => 'El enlace de auditoría debe ser texto.',
            'auditable.max' => 'El enlace de auditoría no puede tener más de 2048 caracteres.',
            'auditable.url' => 'El enlace de auditoría no es válido.',

            'pobl_obj_low.integer' => 'El límite inferior debe ser un número entero.',
            'pobl_obj_low.min' => 'La población objetivo mínima debe ser de al menos 3 personas.',
            'pobl_obj_low.max' => 'La población objetivo mínima no puede superar 60 personas.',

            'pobl_obj_high.integer' => 'El límite superior debe ser un número entero.',
            'pobl_obj_high.min' => 'La población objetivo máxima debe ser de al menos 3 personas.',
            'pobl_obj_high.max' => 'La población objetivo máxima no puede superar 60 personas.',
            'pobl_obj_high.gte' => 'La población objetivo máxima debe ser mayor o igual al límite inferior.',

            'ejes.array' => 'Los ejes seleccionados no son válidos.',
            'ejes.*.integer' => 'Uno de los ejes seleccionados no es válido.',
            'ejes.*.distinct' => 'Uno de los ejes seleccionadas está repetido',
            'ejes.*.exists' => 'Uno de los ejes seleccionados no existe.',
        ]);
    }

    private function getDatosEdit($id, $datosUsuario){
        $taller = Taller::find($id);
        if(!$taller) return null;

        $ejes = Eje::select('id', 'nombre')->get();
        $estado = $datosUsuario->getEnumValues('taller', 'estado');

        return compact('ejes', 'estado', 'taller');
    }
}
