<?php

namespace App\Http\Controllers\Sistema\Psicopegagogia\atencion_personal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\Personas\PComunidad;
use App\Models\Psicopedagogia\atencion_individual\Caso;
use App\Models\Psicopedagogia\atencion_individual\Expediente;
use App\Models\Psicopedagogia\atencion_individual\ListPadecCaso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AtenPersController extends Controller
{
    private const TEMPORADA_PRIMAVERA = 'primavera';
    private const TEMPORADA_OTONO     = 'otoño';

    public function index(Request $request)
    {
        $support = new SupportController;
        $expedientes = $this->getDatosIndex();
        $tipos = $support->getEnumValues('caso', 'tipo');
        $estados = $support->getEnumValues('caso', 'estado');
        $view = view("system.modules.psicopedag.aten_pers.index",
            compact('expedientes',
                    'estados',
                    'tipos'));

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
        [$personasComunidad, $yaRegistrados] = $this->getUsuarias();

        $view = view("system.modules.psicopedag.aten_pers.create",
                compact('personasComunidad',
                        'yaRegistrados'));

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
            $expediente = Expediente::create([
                'comunidad_id'          => $validated['comunidad_id'],
                'contacto_emergencia'   => $limpiar($validated['contacto_emergencia']),
            ]);
            return redirect()
                ->route('aten_pers.show', $expediente->id)
                ->with('success', 'Persona registrada con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Illuminate\Database\QueryException $e) {
            if (($e->errorInfo[1] ?? null) === 1062) {
                return back()
                    ->withInput()
                    ->with('error', 'Esta persona ya tiene un expediente.');
            }
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function show(Request $request, int $id)
    {
        $expediente = $this->getDatosShow($id);
        $view = view("system.modules.psicopedag.aten_pers.show",
                compact('expediente'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function edit(Request $request, int $id)
    {
        $datos = $this->getDatosEdit($id);
        $view = view('system.modules.psicopedag.aten_pers.edit',
            array_merge($datos ?? ['expediente' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update(Request $request, Expediente $aten_per) {
        try {
            $validated = $this->getValidateParentescos($request);

            $this->validarIdsExisten($validated['roles_tutores'] ?? [], 'tutores');

            DB::transaction(function () use ($request, $aten_per, $validated) {
                $aten_per->contacto_emergencia = trim($validated['contacto_emergencia'] ?? null);
                $aten_per->save();

                $aten_per->tutores()->sync(
                    $this->prepararSync($request->input('roles_tutores', [])));
            });

            return redirect()
                ->route('aten_pers.show', $aten_per->id)
                ->with('success', 'Involucrados actualizados con éxito.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy(string $id) {   //Borra el expediente, o sea también casos, relaciones con tutores e historiales
        try {
                $expediente = Expediente::findOrFail($id);
                $nombre = $expediente->comunidad->nombre . ' ' . $expediente->comunidad->ap_pat . ' ' . $expediente->comunidad->ap_mat;
                $expediente->delete();

                return redirect()
                ->route('aten_pers.index')
                ->with('success', "Expediente psicopegagógico de {$nombre} eliminado con éxito");
                }
                catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    return redirect()
                    ->route('aten_pers.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
                } catch (\Throwable $e) {
                    return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
    }

    public function create_caso(Request $request, int $expediente)
    {
        $datos = $this->getDatosCreateCaso($expediente);

        $view = view('system.modules.psicopedag.aten_pers.create_caso',
            array_merge($datos ?? ['expediente' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function store_caso (Request $request, Expediente $expediente) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        try {
            $validated = $this->getValidate($request, true);

            DB::transaction(function () use ($validated, $expediente, $limpiar, $request) {

                $caso = Caso::create([
                    'expediente_id' => $expediente->id,
                    'init'          => $validated['init'],
                    'temporada'     => $this->temporadaDe($validated['init']),
                    'tipo'          => $validated['tipo'],
                    'estado'        => $validated['estado'],
                    'peticion'      => $limpiar($validated['peticion']),
                    'canalizado'    => $request->boolean('canalizado'),
                    'canalizado_site' => $request->boolean('canalizado')
                        ? $limpiar($validated['canalizado_site'] ?? null)
                        : null,
                ]);

                $caso->motivos()->sync($validated['motivos'] ?? []);
            });

            return redirect()
                ->route('aten_pers.show', $expediente->id)
                ->with('success', 'Curso y materias registrados con éxito.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function edit_caso(Request $request, int $caso) {
        $datos = $this->getDatosEditCaso($caso);
        $view = view('system.modules.psicopedag.aten_pers.edit_caso',
            array_merge($datos ?? ['caso' => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update_caso (Request $request, Caso $caso) {
        $limpiar = fn ($valor) => filled($valor) ? trim($valor) : null;
        try {
            $validated = $this->getValidate($request, true);

            DB::transaction(function () use ($limpiar, $request, $caso, $validated) {
                $caso->init = $validated['init'];
                $caso->temporada = $this->temporadaDe($validated['init']);
                $caso->tipo = $validated['tipo'];
                $caso->estado = $validated['estado'];
                $caso->peticion = $limpiar($validated['peticion']);
                $caso->canalizado = $request->boolean('canalizado');
                $caso->canalizado_site = $request->boolean('canalizado')
                        ? $limpiar($validated['canalizado_site'] ?? null)
                        : null;

                $caso->save();

                $caso->motivos()->sync($validated['motivos'] ?? []);
            });

            return redirect()
                ->route('aten_pers.show', $caso->expediente->id)
                ->with('success', 'Involucrados actualizados con éxito.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy_caso(string $id) {   //Borra un solo caso
        try {
                $caso = Caso::findOrFail($id);
                $id = $caso->expediente->id;
                $nombre = ucfirst(str_replace('_', ' ', $caso->tipo));
                $caso->delete();

                return redirect()
                ->route('aten_pers.show', $id)
                ->with('success', "Caso de {$nombre} eliminado con éxito.");
                }
                catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                    return redirect()
                    ->route('aten_pers.index')
                    ->with('error', 'El registro que intentas eliminar no existe.');
                } catch (\Throwable $e) {
                    return back()
                    ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
            }
    }

    //---------------------------------
    //          Funciones
    //---------------------------------

    private function getDatosIndex(){
        return Expediente::with([
        'casoMasReciente.seguimientoMasReciente',
        'comunidad:id,nombre,ap_pat,ap_mat'
        ])
        ->join('p_comunidad', 'expediente.comunidad_id', '=', 'p_comunidad.id')
        ->orderBy('p_comunidad.nombre')
        ->select('expediente.*')
        ->get();
    }

    private function getDatosShow(int $id): ?Expediente {
        $expediente = Expediente::with([
            'casos' => function ($query) {
                $query->orderByDesc('init');
            },
            'casos.seguimientos' => function ($query) {
                $query->orderByDesc('fecha');
            },
            'comunidad'
        ])->find($id);

        if (!$expediente) return null;
        return $expediente;
    }

    private function getUsuarias(){
        $personasComunidad = PComunidad::with('colonia')->orderBy('nombre')->get()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->colonia_otro ?? ($p->colonia->nombre ?? null),
            'detalles' => [
                'Edad' => $p->edad ? $p->edad . ' años' : null,
                'Nivel escolar' => $p->nv_escolar ? ucfirst(str_replace('_', ' ', $p->nv_escolar)) : null,
            ],
        ]);

        $yaRegistrados = Expediente::pluck('comunidad_id')->all();

        return [$personasComunidad, $yaRegistrados];
    }

    private function getValidate(Request $request, bool $esCaso = false) {
        $support = new SupportController();

        $rules = [
            'contacto_emergencia' => ['nullable', 'string', 'max:20'],
        ];

        if ($esCaso) {//Campos de la tabla 'caso'
            $rules['comunidad_id']    = ['sometimes', 'required', 'integer', 'exists:p_comunidad,id'];
            $rules['init']            = ['required', 'date'];
            $rules['tipo']            = ['required', 'string', Rule::in($support->getEnumValues('caso', 'tipo'))];
            $rules['estado']          = ['required', 'string', Rule::in($support->getEnumValues('caso', 'estado'))];
            $rules['peticion']        = ['nullable', 'string', 'max:5000'];
            $rules['canalizado']      = ['nullable', 'boolean'];
            $rules['canalizado_site'] = ['required_if:canalizado,1,true', 'nullable', 'string', 'max:255'];

            $rules['motivos']         = ['nullable', 'array'];
            $rules['motivos.*']       = ['integer', 'exists:list_padec_caso,id'];
        } else {        //Creación del expediente raíz
            $rules['comunidad_id']    = ['required', 'integer', 'exists:p_comunidad,id', 'unique:expediente,comunidad_id'];
        }

        $messages = [
            'comunidad_id.required' => 'Selecciona a una persona de la comunidad.',
            'comunidad_id.integer'  => 'La persona seleccionada no es válida.',
            'comunidad_id.exists'   => 'La persona seleccionada ya no existe.',
            'comunidad_id.unique'   => 'Esta persona ya cuenta con un expediente registrado.',

            'contacto_emergencia.max' => 'El contacto de emergencia no puede tener más de 20 caracteres.',

            'init.required' => 'La fecha de inicio es obligatoria.',
            'init.date'     => 'La fecha de inicio no es válida.',

            'tipo.required' => 'El tipo de caso es obligatorio.',
            'tipo.in'       => 'El tipo de caso seleccionado no es válido.',

            'estado.required' => 'El estado del caso es obligatorio.',
            'estado.in'       => 'El estado del caso seleccionado no es válido.',

            'peticion.max' => 'La petición de la persona no puede exceder los 5000 caracteres.',

            'canalizado.boolean'  => 'El valor de canalización no es válido.',

            'canalizado_site.required_if' => 'Especifica la institución o lugar al que se canalizó.',
            'canalizado_site.max'         => 'El lugar de canalización no puede exceder los 255 caracteres.',

            'motivos.array'     => 'Los motivos seleccionados no tienen un formato válido.',
            'motivos.*.integer' => 'El identificador del motivo no es válido.',
            'motivos.*.exists'  => 'Uno de los motivos seleccionados no existe en el catálogo.',
        ];

        return $request->validate($rules, $messages);
    }

    private function getValidateParentescos(Request $request){
        $sup = new SupportController();
        $parentescoOpciones = $sup->getEnumValues('expediente_tutor', 'parentesco');

        $rules = [
            'contacto_emergencia'   => ['nullable', 'string', 'max:20'],
            'roles_tutores'         => ['nullable', 'array'],
            'roles_tutores.*.rol'   => ['required', 'string', Rule::in($parentescoOpciones)],
            'roles_tutores.*.otros' => ['nullable', 'string', 'max:30', 'required_if:roles_tutores.*.rol,otro'],
        ];
        $messages = [
            'contacto_emergencia.max' => 'El contacto de emergencia no puede tener más de 20 caracteres.',
            'roles_tutores.*.rol.required'        => 'Falta elegir el parentesco para alguno de los seleccionados como tutores.',
            'roles_tutores.*.rol.in'              => 'Uno de los tipos de parentesco seleccionados no es válido.',
            'roles_tutores.*.otros.max'          => 'El campo "otro" no puede tener más de 30 caracteres.',
            'roles_tutores.*.otros.required_if'  => 'Especifica el parentesco cuando eliges "Otro".',
        ];

        return $request->validate($rules, $messages);
    }

    private function getDatosCreateCaso(int $id) {
        $expediente = Expediente::find($id);
        if (!$expediente) return null;

        [$estados, $tipos, $motivos] = $this->getOptionsEnums();

        return compact('expediente', 'estados', 'tipos', 'motivos');
    }

    private function getDatosEditCaso(int $id){
        $caso = Caso::find($id);
        if (!$caso) return null;

        [$estados, $tipos, $motivos] = $this->getOptionsEnums();

        return compact('caso', 'estados', 'tipos', 'motivos');
    }

    private function getDatosEdit(int $id) {
        $sup = new SupportController();
        $expediente = Expediente::find($id);
        if (!$expediente) return null;

        $personasComunidad = PComunidad::with('colonia')
        ->get()
        ->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->colonia_otro ?? ($p->colonia->nombre ?? null),
        ]);

        $seleccionados = $expediente->tutores()->get()->mapWithKeys(fn ($p) => [$p->id => ['rol' => $p->pivot->parentesco, 'otros' => $p->pivot->otro ?? '']])->toArray();

        $parentescoOpciones = $sup->getEnumValues('expediente_tutor', 'parentesco');

        return compact('expediente', 'personasComunidad', 'seleccionados', 'parentescoOpciones');
    }

    private function temporadaDe(string $fecha): string {
        return Carbon::parse($fecha)->month <= 6
            ? self::TEMPORADA_PRIMAVERA
            : self::TEMPORADA_OTONO;
    }

    private function prepararSync(array $roles): array {
        $resultado = [];
        foreach ($roles as $id => $datos) {
            $resultado[$id] = [
                'parentesco'   => $datos['rol'],
                'otro' => $datos['rol'] === 'otro' ? trim(($datos['otros'] ?? null)) : null,
            ];
        }
        return $resultado;
    }

    private function validarIdsExisten(array $roles, string $etiqueta): void {
        if (empty($roles)) return;

        $ids = array_keys($roles);
        $existentes = PComunidad::whereIn('id', $ids)->pluck('id')->all();
        $faltantes = array_diff($ids, $existentes);

        if (!empty($faltantes)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'roles' => "Uno de los elementos seleccionados de $etiqueta ya no existe. Recarga la página e inténtalo de nuevo.",
            ]);
        }
    }

    private function getOptionsEnums() {
        $support = new SupportController();
        $estados = $support->getEnumValues('caso', 'estado');
        $tipos = $support->getEnumValues('caso', 'tipo');
        $motivos = ListPadecCaso::all();

        return [$estados, $tipos, $motivos];
    }

}
