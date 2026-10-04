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
use Illuminate\Http\Request;
use App\Models\Talleres\Taller;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TalleresController extends Controller
{
    private function rolesValidos(): array
    {
        return (new DatosUsuario())->getEnumValues('rol_taller_centro', 'rol');
    }

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

    public function edit_participacion(Request $request, Taller $taller) {
        $personasCentro = PCentro::all()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->cargo ? ucfirst(str_replace('_', ' ', $p->cargo)) : null,
        ]);

        $personasComunidad = PComunidad::all()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->colonia_otro ?? ($p->colonia->nombre ?? null),
        ]);

        $instituciones = Institucion::all()->map(fn ($i) => (object) [
            'id' => $i->id,
            'nombre' => $i->nombre,
            'subtitle' => null,
        ]);

        $personasExterno = PExterno::all()->map(function ($externo) {
            $participacion = $externo->ultima_participacion;
            if (!$participacion) {
                return null; // externo sin ninguna participación: no se puede vincular a un proyecto
            }

            return (object) [
                'id' => $participacion->id, // id de la participación, no del externo
                'nombre' => trim("$externo->nombre $externo->ap_pat $externo->ap_mat"),
                'subtitle' => $externo->universidad,
            ];
        })->filter()->values();

        $seleccionados = [
            'centro'      => $taller->rolesCentro()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'comunidad'   => $taller->rolesComunidad()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'institucion' => $taller->instituciones()->get()->mapWithKeys(fn ($i) => [
                $i->id => ['rol' => $i->pivot->rol, 'otros' => $i->pivot->otros],
            ])->toArray(),
            'externo'     => $taller->rolesExternos()->get()->mapWithKeys(fn ($part) => [
                $part->id => ['rol' => $part->pivot->rol, 'otros' => $part->pivot->otros],
            ])->toArray(),
        ];

        $rolesOpciones = $this->rolesValidos();

        $view = view('system.modules.talleres.create_participantes', compact(
            'taller',
            'personasCentro',
            'personasExterno',
            'personasComunidad',
            'instituciones',
            'seleccionados',
            'rolesOpciones'
        ));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update_participacion(Request $request, Taller $taller) {
        try {
            $validated = $this->getValidateParticipacion($request);

            $this->validarIdsExisten($validated['roles_centro'] ?? [], PCentro::class, 'centro');
            $this->validarIdsExisten($validated['roles_externo'] ?? [], Participacion::class, 'externo (participación)');
            $this->validarIdsExisten($validated['roles_comunidad'] ?? [], PComunidad::class, 'comunidad');
            $this->validarIdsExisten($validated['roles_institucion'] ?? [], Institucion::class, 'institución');

            DB::transaction(function () use ($request, $taller) {
                $taller->rolesCentro()->sync($this->prepararSync($request->input('roles_centro', [])));
                $taller->rolesExternos()->sync($this->prepararSync($request->input('roles_externo', [])));
                $taller->rolesComunidad()->sync($this->prepararSync($request->input('roles_comunidad', [])));
                $taller->instituciones()->sync($this->prepararSync($request->input('roles_institucion', [])));
            });

            return redirect()
                ->route('talleres.show', $taller->id)
                ->with('success', 'Involucrados actualizados con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
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

    private function getValidateParticipacion($request) {
        $rolesValidos = $this->rolesValidos();

        return $request->validate([
            'roles_centro'                => ['nullable', 'array'],
            'roles_centro.*.rol'          => ['required', 'string', Rule::in($rolesValidos)],
            'roles_centro.*.otros'        => ['nullable', 'string', 'max:30', 'required_if:roles_centro.*.rol,otro'],

            'roles_externo'               => ['nullable', 'array'],
            'roles_externo.*.rol'         => ['required', 'string', Rule::in($rolesValidos)],
            'roles_externo.*.otros'       => ['nullable', 'string', 'max:30', 'required_if:roles_externo.*.rol,otro'],

            'roles_comunidad'             => ['nullable', 'array'],
            'roles_comunidad.*.rol'       => ['required', 'string', Rule::in($rolesValidos)],
            'roles_comunidad.*.otros'     => ['nullable', 'string', 'max:30', 'required_if:roles_comunidad.*.rol,otro'],

            'roles_institucion'           => ['nullable', 'array'],
            'roles_institucion.*.rol'     => ['required', 'string', Rule::in($rolesValidos)],
            'roles_institucion.*.otros'   => ['nullable', 'string', 'max:30', 'required_if:roles_institucion.*.rol,otro'],
        ], [
            'roles_centro.*.rol.required'        => 'Falta elegir un rol para alguno de los seleccionados del Centro.',
            'roles_centro.*.rol.in'              => 'Uno de los roles seleccionados del Centro no es válido.',
            'roles_centro.*.otros.max'           => 'El campo "otro rol" no puede tener más de 30 caracteres.',
            'roles_centro.*.otros.required_if'   => 'Especifica el rol cuando eliges "Otro".',

            'roles_externo.*.rol.required'       => 'Falta elegir un rol para alguna de las personas externas seleccionadas.',
            'roles_externo.*.rol.in'             => 'Uno de los roles seleccionados de personas externas no es válido.',
            'roles_externo.*.otros.max'          => 'El campo "otro rol" no puede tener más de 30 caracteres.',
            'roles_externo.*.otros.required_if'  => 'Especifica el rol cuando eliges "Otro".',

            'roles_comunidad.*.rol.required'       => 'Falta elegir un rol para alguno de los seleccionados de la Comunidad.',
            'roles_comunidad.*.rol.in'             => 'Uno de los roles seleccionados de la Comunidad no es válido.',
            'roles_comunidad.*.otros.max'          => 'El campo "otro rol" no puede tener más de 30 caracteres.',
            'roles_comunidad.*.otros.required_if'  => 'Especifica el rol cuando eliges "Otro".',

            'roles_institucion.*.rol.required'       => 'Falta elegir un rol para alguna de las instituciones seleccionadas.',
            'roles_institucion.*.rol.in'             => 'Uno de los roles seleccionados de instituciones no es válido.',
            'roles_institucion.*.otros.max'          => 'El campo "otro rol" no puede tener más de 30 caracteres.',
            'roles_institucion.*.otros.required_if'  => 'Especifica el rol cuando eliges "Otro".',
        ]);
    }

    private function prepararSync(array $roles): array {
        $resultado = [];
        foreach ($roles as $id => $datos) {
            $resultado[$id] = [
                'rol'   => $datos['rol'],
                'otros' => $datos['rol'] === 'otro' ? ($datos['otros'] ?? null) : null,
            ];
        }
        return $resultado;
    }

    private function validarIdsExisten(array $roles, string $modelo, string $etiqueta): void {
        if (empty($roles)) {
            return;
        }

        $ids = array_keys($roles);
        $existentes = $modelo::whereIn('id', $ids)->pluck('id')->all();
        $faltantes = array_diff($ids, $existentes);

        if (!empty($faltantes)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'roles' => "Uno de los elementos seleccionados de $etiqueta ya no existe. Recarga la página e inténtalo de nuevo.",
            ]);
        }
    }
}
