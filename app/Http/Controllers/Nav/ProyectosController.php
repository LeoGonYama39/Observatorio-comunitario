<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Eje;
use App\Models\Colonia;
use App\Models\listas\Institucion;
use App\Models\listas\Problematica;
use App\Models\PCentro;
use App\Models\PComunidad;
use App\Models\PExterno;
use Illuminate\Http\Request;
use App\Models\Proyectos\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProyectosController extends Controller
{
    public function index(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $proyectos = $this->getDatosIndex();

        $view = view("system.modules.proyectos.index",compact('persona', 'otros', 'proyectos'));

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
    public function create(Request $request)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDropDownOptions($datosUsuario);

        $view = view(
            "system.modules.proyectos.create",
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

    public function create_participacion(Request $request, $proyecto){
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDatosAddParticipantes($proyecto);

        $view = view(
            "system.modules.proyectos.create_participantes",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['proyecto' => null]
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
        $datosUsuario = new DatosUsuario();

        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $request->validate([
                'nombre'        => ['required', 'string', 'max:50'],
                'estado'        => ['required', 'string', Rule::in($datosUsuario->getEnumValues('proyecto', 'estado'))],
                'fecha_inicio'  => ['required', 'date'],
                'fecha_fin'     => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
                'antecedentes'  => ['nullable', 'string'],
                'objetivos'     => ['nullable', 'string'],
                'alcance'       => ['nullable', 'string'],
                'evaluacion'    => ['nullable', 'string'],
                'repo'          => ['nullable', 'url', 'max:2048'],
                'auditable'     => ['nullable', 'url', 'max:2048'],

                'prioritario'   => ['nullable', 'boolean'],

                'pobl_obj_low'  => ['nullable', 'integer', 'min:3', 'max:60'],
                'pobl_obj_high' => ['nullable', 'integer', 'min:3', 'max:60', 'gte:pobl_obj_low'],

                'colonias'      => ['nullable', 'array'],
                'colonias.*'    => ['integer', 'distinct', 'exists:colonia,id'],
                'ejes'          => ['nullable', 'array'],
                'ejes.*'        => ['integer', 'distinct', 'exists:eje,id'],
                'problematicas' => ['nullable', 'array'],
                'problematicas.*' => ['integer', 'distinct', 'exists:problematicas,id'],
            ], $this->getMessages());

            $proyecto = DB::transaction(function () use ($validated, $request, $limpiar) {
                $proyecto = Proyecto::create([
                    'nombre'        => trim($validated['nombre']),
                    'estado'        => trim($validated['estado']),
                    'fecha_inicio'  => $validated['fecha_inicio'],
                    'fecha_fin'     => $validated['fecha_fin'] ?? null,
                    'antecedentes'  => $limpiar($validated['antecedentes'] ?? null),
                    'objetivos'     => $limpiar($validated['objetivos'] ?? null),
                    'alcance'       => $limpiar($validated['alcance'] ?? null),
                    'evaluacion'    => $limpiar($validated['evaluacion'] ?? null),
                    'repo'          => $limpiar($validated['repo'] ?? null),
                    'auditable'     => $limpiar($validated['auditable'] ?? null),
                    'prioritario'   => $request->boolean('prioritario'),
                    'pobl_obj_low'  => $validated['pobl_obj_low'] ?? null,
                    'pobl_obj_high' => $validated['pobl_obj_high'] ?? null,
                ]);

                // Tablas intermedias: sync() recibe directamente la lista de ids ya validada
                $proyecto->colonias()->sync($validated['colonias'] ?? []);
                $proyecto->ejes()->sync($validated['ejes'] ?? []);
                $proyecto->problematicas()->sync($validated['problematicas'] ?? []);

                return $proyecto;
            });

            return redirect()
                ->route('proyectos.show', $proyecto->id)
                ->with('success', 'Proyecto registrado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $datos = $this->getDatosShow($id);

        $view = view(
            "system.modules.proyectos.show",
            array_merge(
                compact('persona', 'otros'),
                $datos ?? ['proyecto' => null]
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
                $proyecto = Proyecto::findOrFail($id);
                $nombre = $proyecto->nombre;
                $proyecto->delete();

                return redirect()
                    ->route('proyectos.index')
                    ->with('success', "Proyecto ({$nombre}) eliminado con éxito.");
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                return redirect()
                    ->route('proyectos.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
            } catch (\Throwable $e) {
                return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
        }
    }

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return Proyecto::with([
            'ejes.responsabilidades.area'
        ])
            ->select(
                'id',
                'nombre',
                'estado',
                'prioritario'
            )
            ->orderBy('nombre')
            ->get();
    }

    private function getDatosShow($id){
        $proyecto = Proyecto::find($id);
        if(!$proyecto) return null;
        $colonias = $proyecto->colonias()
            ->select('colonia.id', 'colonia.nombre')
            ->get();
        $problematicas = $proyecto->problematicas()
            ->select('problematicas.id', 'problematicas.nombre')
            ->get();
        $ejes = $proyecto->ejes;

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

        $involucrados = $proyecto->involucrados;

        $historial = $proyecto->historial()
            ->orderBy('fecha', 'desc')
            ->get();

        return compact(
            'proyecto',
            'colonias',
            'problematicas',
            'areas',
            'responsabilidades',
            'ejes',
            'involucrados',
            'historial'
        );
    }

    private function getDatosAddParticipantes($id) {
        $proyecto = $this->getDatosProyectoByIDCompact($id);
        if(!$proyecto) return null;

        $centros = $this->getPCentro();
        $externos = $this->getPExterno();
        $usuarias = $this->getPComunidad();
        $instituciones = $this->getInstitucion();

        return compact(
            'proyecto',
            'centros',
            'externos',
            'usuarias',
            'instituciones',
        );
    }

    private function getDatosProyectoByIDCompact($id){
        return Proyecto::select(
            'id',
            'nombre',
        )->find($id);
    }
    private function getPCentro(){
        return PCentro::select(
            'id',
            'nombre',
            'ap_pat',
            'ap_mat',
            'cargo',
        )->orderBy('nombre')
            ->get();
    }

    private function getPExterno(){
        return PExterno::with(
            'participaciones'
        )
            ->select(
                'id',
                'nombre',
                'ap_pat',
                'ap_mat',
                'universidad',
            )->orderBy('nombre')
            ->get();
    }

    private function getPComunidad()
    {
        return PComunidad::select(
            'id',
            'nombre',
            'ap_pat',
            'ap_mat',
            'colonia_id',
        )
            ->where('lider', true)
            ->orderBy('nombre')
            ->get();
    }

    private function getInstitucion(){
        return Institucion::select(
            'id',
            'nombre',
        )->orderBy('nombre')->get();
    }

    private function getDropDownOptions($datosUsuario)
    {
        $colonias = Colonia::select('id', 'nombre')->get();
        $ejes = Eje::select('id', 'nombre')->get();
        $problematicas = Problematica::select('id', 'nombre')->get();
        $estado = $datosUsuario->getEnumValues('proyecto', 'estado');

        return compact(
            'colonias',
            'ejes',
            'problematicas',
            'estado'
        );
    }

    private function getMessages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',

            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado seleccionado no es válido.',

            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_inicio.date' => 'La fecha de inicio no es válida.',

            'fecha_fin.date' => 'La fecha de fin no es válida.',
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio.',

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

            'prioritario.boolean' => 'El valor de destacado no es válido.',

            'pobl_obj_low.integer' => 'El límite inferior debe ser un número entero.',
            'pobl_obj_low.min' => 'La población objetivo mínima debe ser de al menos 3 personas.',
            'pobl_obj_low.max' => 'La población objetivo mínima no puede superar 60 personas.',

            'pobl_obj_high.integer' => 'El límite superior debe ser un número entero.',
            'pobl_obj_high.min' => 'La población objetivo máxima debe ser de al menos 3 personas.',
            'pobl_obj_high.max' => 'La población objetivo máxima no puede superar 60 personas.',
            'pobl_obj_high.gte' => 'La población objetivo máxima debe ser mayor o igual al límite inferior.',

            'colonias.array' => 'Las colonias seleccionadas no son válidas.',
            'colonias.*.integer' => 'Una de las colonias seleccionadas no es válida.',
            'colonias.*.distinct' => 'Una de las colonias seleccionadas está repetida',
            'colonias.*.exists' => 'Una de las colonias seleccionadas no existe.',

            'ejes.array' => 'Los ejes seleccionados no son válidos.',
            'ejes.*.integer' => 'Uno de los ejes seleccionados no es válido.',
            'ejes.*.distinct' => 'Uno de los ejes seleccionadas está repetido',
            'ejes.*.exists' => 'Uno de los ejes seleccionados no existe.',

            'problematicas.array' => 'Las problemáticas seleccionadas no son válidas.',
            'problematicas.*.integer' => 'Una de las problemáticas seleccionadas no es válida.',
            'problematicas.*.distinct' => 'Una de las problemáticas seleccionadas está repetida',
            'problematicas.*.exists' => 'Una de las problemáticas seleccionadas no existe.',
        ];
    }
}
