<?php

namespace App\Http\Controllers\Nav;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Eje;
use App\Models\Colonia;
use App\Models\listas\Institucion;
use App\Models\listas\Problematica;
use App\Models\Participacion;
use App\Models\PCentro;
use App\Models\PComunidad;
use App\Models\PExterno;
use App\Models\Proyectos\HistorialProyecto;
use Illuminate\Http\Request;
use App\Models\Proyectos\Proyecto;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProyectosController extends Controller
{
    private function rolesValidos(): array
    {
        return (new DatosUsuario())->getEnumValues('rol_proyecto_centro', 'rol');
    }

    public function index(Request $request){
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

    public function create(Request $request) {
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

    public function store(Request $request) {
        $datosUsuario = new DatosUsuario();
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $this->getValidate($request, $this->getMessages(), $datosUsuario);

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

    public function show(Request $request, $id) {
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

    public function edit(Request $request, $id) {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $proyecto = Proyecto::find($id);
        $datos = $this->getDropDownOptions($datosUsuario);

        $view = view(
            "system.modules.proyectos.edit",
            array_merge(
                compact('persona', 'otros', 'proyecto'),
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

    public function update(Request $request, Proyecto $proyecto) {
        $datosUsuario = new DatosUsuario();
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;

        try {
            $validated = $this->getValidate($request, $this->getMessages(), $datosUsuario);

            $proyecto = DB::transaction(function () use ($proyecto, $validated, $request, $limpiar) {
                $proyecto->nombre = trim($validated['nombre']);
                $proyecto->estado = trim($validated['estado']);
                $proyecto->fecha_inicio = $validated['fecha_inicio'];
                $proyecto->fecha_fin = $validated['fecha_fin'] ?? null;
                $proyecto->antecedentes = $limpiar($validated['antecedentes'] ?? null);
                $proyecto->objetivos = $limpiar($validated['objetivos'] ?? null);
                $proyecto->alcance = $limpiar($validated['alcance'] ?? null);
                $proyecto->evaluacion = $limpiar($validated['evaluacion'] ?? null);
                $proyecto->repo = $limpiar($validated['repo'] ?? null);
                $proyecto->auditable = $limpiar($validated['auditable'] ?? null);
                $proyecto->prioritario = $request->boolean('prioritario');
                $proyecto->pobl_obj_low = $validated['pobl_obj_low'] ?? null;
                $proyecto->pobl_obj_high = $validated['pobl_obj_high'] ?? null;

                $proyecto->save();

                // Tablas intermedias: sync() recibe directamente la lista de ids ya validada
                $proyecto->colonias()->sync($validated['colonias'] ?? []);
                $proyecto->ejes()->sync($validated['ejes'] ?? []);
                $proyecto->problematicas()->sync($validated['problematicas'] ?? []);

                return $proyecto;
            });

            return redirect()
                ->route('proyectos.show', $proyecto->id)
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

    public function edit_participacion(Request $request, Proyecto $proyecto) {
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

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
            'centro'      => $proyecto->rolesCentro()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'comunidad'   => $proyecto->rolesComunidad()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'institucion' => $proyecto->instituciones()->get()->mapWithKeys(fn ($i) => [
                $i->id => ['rol' => $i->pivot->rol, 'otros' => $i->pivot->otros],
            ])->toArray(),
            'externo'     => $proyecto->rolesExternos()->get()->mapWithKeys(fn ($part) => [
                $part->id => ['rol' => $part->pivot->rol, 'otros' => $part->pivot->otros],
            ])->toArray(),
        ];

        $rolesOpciones = $this->rolesValidos();

        $view = view('system.modules.proyectos.create_participantes', compact(
            'proyecto',
            'personasCentro',
            'personasExterno',
            'personasComunidad',
            'instituciones',
            'seleccionados',
            'persona',
            'otros',
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

    public function update_participacion(Request $request, Proyecto $proyecto) {
        try {
            $validated = $this->getValidateParticipacion($request);

            $this->validarIdsExisten($validated['roles_centro'] ?? [], PCentro::class, 'centro');
            $this->validarIdsExisten($validated['roles_externo'] ?? [], Participacion::class, 'externo (participación)');
            $this->validarIdsExisten($validated['roles_comunidad'] ?? [], PComunidad::class, 'comunidad');
            $this->validarIdsExisten($validated['roles_institucion'] ?? [], Institucion::class, 'institución');

            DB::transaction(function () use ($request, $proyecto) {
                $proyecto->rolesCentro()->sync($this->prepararSync($request->input('roles_centro', [])));
                $proyecto->rolesExternos()->sync($this->prepararSync($request->input('roles_externo', [])));
                $proyecto->rolesComunidad()->sync($this->prepararSync($request->input('roles_comunidad', [])));
                $proyecto->instituciones()->sync($this->prepararSync($request->input('roles_institucion', [])));
            });

            return redirect()
                ->route('proyectos.show', $proyecto->id)
                ->with('success', 'Involucrados actualizados con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function create_historial(Request $request, $id) {
        $datosUsuario = new DatosUsuario();

        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $proyecto = Proyecto::find($id);
        $entidad = $proyecto;
        $nombreEntidad = $proyecto?->nombre;
        $nombreIndex = 'Proyectos';
        $rutaIndex = route('proyectos.index');
        $rutaShow = route('proyectos.show', $id);
        $rutaStore = route('proyectos.historial.store', $id);

        $view = view(
            'system.parts.create_historial',
            compact(
                'persona',
                'otros',
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

    public function store_historial(Request $request, Proyecto $proyecto) {
        $datosUsuario = new DatosUsuario();    
        try {
            $validated = $datosUsuario->getValidateHistorial($request);

                HistorialProyecto::create([
                    'proyecto_id'   => $proyecto->id,
                    'fecha'         => $validated['fecha'],
                    'comentario'    => $validated['comentario'],
                ]);

            return redirect()
                ->route('proyectos.show', $proyecto->id)
                ->with('success', 'Registro de historial creado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    //--------------------------------
    //          Funciones
    //--------------------------------

    //Obtiene los datos para la tabla index
    private function getDatosIndex() {
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

    private function getPExterno() {
        return PExterno::with('participaciones')
            ->whereHas('participaciones')
            ->select(
                'id',
                'nombre',
                'ap_pat',
                'ap_mat',
                'universidad',
            )
            ->orderBy('nombre')
            ->get();
    }

    private function getPComunidad() {
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

    private function getInstitucion() {
        return Institucion::select(
            'id',
            'nombre',
        )->orderBy('nombre')->get();
    }

    private function getDropDownOptions($datosUsuario) {
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

    private function getMessages(): array {
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

    private function getValidate($request, $messages, $datosUsuario) {
        return $request->validate([
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
        ], $messages);
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
    /**
     * Si el rol no es "otro", 'otros' se guarda como null aunque el campo
     * oculto del navegador haya mandado algún texto viejo (defensa extra en el servidor).
     */
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

    /**
     * Lanza un ValidationException si alguna LLAVE del array (el id) no existe
     * en la tabla del modelo indicado. Rule::exists valida VALORES, no llaves,
     * así que aquí se hace manual.
     */
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
