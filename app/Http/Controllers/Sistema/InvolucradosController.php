<?php

namespace App\Http\Controllers\Sistema;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\ListaOpciones\Institucion;
use App\Models\Personas\PCentro;
use App\Models\Personas\PComunidad;
use App\Models\Personas\PExterno;
use App\Models\Proyectos\Proyecto;
use App\Models\Talleres\Taller;
use App\Models\Talleres\TallerGen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;


/*
 * Para el manejo de edits y updates de involucrados en proyectos, talleres y Eventos/charlas
 * Igual para talleristas
 */
class InvolucradosController extends Controller {

    public function edit_proyecto(Request $request, Proyecto $proyecto)
    {
        return $this->edit(
            $request,
            $proyecto,
            'Proyectos',
            route('proyectos.index'),
            route('proyectos.show', $proyecto->id),
            route('proyectos.participantes.update', $proyecto->id)
        );
    }

    public function edit_taller(Request $request, Taller $taller)
    {
        return $this->edit(
            $request,
            $taller,
            'Talleres',
            route('talleres.index'),
            route('talleres.show', $taller->id),
            route('talleres.participantes.update', $taller->id)
        );
    }

    private function edit(Request $request, $entidad, string $nombreTipo, string $rutaIndex, string $rutaShow, string $rutaUpdate) {

        $personasCentro = PCentro::all()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->cargo ? ucfirst(str_replace('_', ' ', $p->cargo)) : null,
        ]);

        $personasComunidad = PComunidad::with('colonia')
        ->where('lider', true)
        ->orderBy('nombre')
        ->get()
        ->map(fn ($p) => (object) [
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
            $participacionReciente = $externo->ultima_participacion;
            if (!$participacionReciente) {
                return null; // sin ninguna participación, no se puede vincular a un proyecto
            }

            return (object) [
                'id' => $externo->id, // id del EXTERNO, ya no de la participación
                'nombre' => trim("$externo->nombre $externo->ap_pat $externo->ap_mat"),
                'subtitle' => $externo->universidad->nombre ?? '',
                'participacion_id' => $participacionReciente->id,
            ];
        })->filter()->values();

        $seleccionadosExterno = $entidad->rolesExternos()->get()->mapWithKeys(fn ($participacion) => [
            $participacion->externo_id => [
                'rol' => $participacion->pivot->rol,
                'otros' => $participacion->pivot->otros,
                'participacion_id' => $participacion->id,
            ],
        ])->toArray();

        $seleccionados = [
            'centro'      => $entidad->rolesCentro()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'comunidad'   => $entidad->rolesComunidad()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'institucion' => $entidad->instituciones()->get()->mapWithKeys(fn ($i) => [
                $i->id => ['rol' => $i->pivot->rol, 'otros' => $i->pivot->otros],
            ])->toArray(),
            'externo'     => $seleccionadosExterno,
        ];

        $rolesOpciones = $this->rolesValidos($entidad);

        $view = view('system.parts.forms.edit_involucrados', compact(
            'entidad',
            'nombreTipo',
            'rutaIndex',
            'rutaShow',
            'rutaUpdate',
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

    public function update_proyecto(Request $request, Proyecto $proyecto)
    {
        return $this->update($request, $proyecto, 'proyectos.show');
    }

    public function edit_talleristas(Request $request, TallerGen $grupo)
    {
        $personasCentro = PCentro::all()->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->cargo ? ucfirst(str_replace('_', ' ', $p->cargo)) : null,
        ]);

        $personasComunidad = PComunidad::with('colonia')
        ->whereNotNull('saberes')
        ->get()
        ->map(fn ($p) => (object) [
            'id' => $p->id,
            'nombre' => trim("$p->nombre $p->ap_pat $p->ap_mat"),
            'subtitle' => $p->colonia_otro ?? ($p->colonia->nombre ?? null),
        ]);

        $personasExterno = PExterno::all()->map(function ($externo) {
            $participacionReciente = $externo->ultima_participacion;
            if (!$participacionReciente) return null;

            return (object) [
                'id' => $externo->id, // id del EXTERNO, ya no de la participación
                'nombre' => trim("$externo->nombre $externo->ap_pat $externo->ap_mat"),
                'subtitle' => $externo->universidad->nombre ?? '',
                'participacion_id' => $participacionReciente->id,
            ];
        })->filter()->values();

        $seleccionados = [
            'centro'    => $grupo->talleristasCentro()->get()
                ->mapWithKeys(fn ($p) => [$p->id => []])->toArray(),

            'comunidad' => $grupo->talleristasComunidad()->get()
                ->mapWithKeys(fn ($p) => [$p->id => []])->toArray(),

            'externo'   => $grupo->talleristasExternos()->get()
                ->mapWithKeys(fn ($part) => [
                    $part->externo_id => ['participacion_id' => $part->id],
                ])->toArray(),
        ];


        $view = view('system.modules.talleres.edit_talleristas', compact(
            'grupo',
            'personasCentro',
            'personasComunidad',
            'personasExterno',
            'seleccionados',
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

    public function update_talleristas(Request $request, TallerGen $grupo)
    {
        try {
            $validated = $this->getValidateTalleristas($request);

            DB::transaction(function () use ($validated, $grupo) {
                $grupo->talleristasCentro()->sync($validated['centro'] ?? []);
                $grupo->talleristasComunidad()->sync($validated['comunidad'] ?? []);
                $participacionIds = collect($validated['roles_externo'] ?? [])->pluck('participacion_id')->all();
                $grupo->talleristasExternos()->sync($participacionIds);
            });

            return redirect()
                ->route('talleres.show', $grupo->taller->id)
                ->with('success', 'Talleristas actualizados con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function update_taller(Request $request, Taller $taller)
    {
        return $this->update($request, $taller, 'talleres.show');
    }

    private function update(Request $request, $entidad, string $rutaShow) {
        try {
            $validated = $this->getValidateParticipacion($request, $entidad);

            $this->validarIdsExisten(
                $validated['roles_centro'] ?? [],
                PCentro::class,
                'centro'
            );

            $this->validarIdsExisten(
                $validated['roles_comunidad'] ?? [],
                PComunidad::class,
                'comunidad'
            );

            $this->validarIdsExisten(
                $validated['roles_institucion'] ?? [],
                Institucion::class,
                'institución'
            );

            DB::transaction(function () use ($request, $entidad) {
                $entidad->rolesCentro()->sync(
                    $this->prepararSync(
                        $request->input('roles_centro', [])
                    )
                );

                $entidad->rolesExternos()->sync(
                    $this->prepararSyncExterno(
                        $request->input('roles_externo', [])
                    )
                );

                $entidad->rolesComunidad()->sync(
                    $this->prepararSync(
                        $request->input('roles_comunidad', [])
                    )
                );

                $entidad->instituciones()->sync(
                    $this->prepararSync(
                        $request->input('roles_institucion', [])
                    )
                );
            });

            return redirect()
                ->route($rutaShow, $entidad->id)
                ->with('success', 'Involucrados actualizados con éxito.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Ocurrió un error al guardar en la base de datos: ' .
                    $e->getMessage()
                );
        }
    }

    //-----------------------------------------------------
    //              Funciones
    //-----------------------------------------------------

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

    private function prepararSyncExterno(array $rolesExterno): array
    {
        $resultado = [];
        foreach ($rolesExterno as $datos) {
            $resultado[$datos['participacion_id']] = [
                'rol'   => $datos['rol'],
                'otros' => $datos['rol'] === 'otro' ? ($datos['otros'] ?? null) : null,
            ];
        }
        return $resultado;
    }

    private function getValidateParticipacion(Request $request, $entidad) {
        $rolesValidos = $this->rolesValidos($entidad);

        return $request->validate([
            'roles_centro'                => ['nullable', 'array'],
            'roles_centro.*.rol'          => ['required', 'string', Rule::in($rolesValidos)],
            'roles_centro.*.otros'        => ['nullable', 'string', 'max:30', 'required_if:roles_centro.*.rol,otro'],

            'roles_externo'                     => ['nullable', 'array'],
            'roles_externo.*.rol'               => ['required', 'string', Rule::in($rolesValidos)],
            'roles_externo.*.otros'             => ['nullable', 'string', 'max:30', 'required_if:roles_externo.*.rol,otro'],
            'roles_externo.*.participacion_id'  => ['required', 'integer', 'exists:participaciones,id'],

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
            'roles_externo.*.participacion_id.required' => 'Falta la participación a vincular de alguna persona externa.',
            'roles_externo.*.participacion_id.exists'   => 'Una de las participaciones seleccionadas ya no existe.',

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

    private function getValidateTalleristas(Request $request) {
        return $request->validate([
            'centro'        => ['nullable', 'array'],
            'centro.*'      => ['integer', 'distinct', 'exists:p_centro,id'],

            'comunidad'     => ['nullable', 'array'],
            'comunidad.*'   => ['integer', 'distinct', 'exists:p_comunidad,id'],

            'externo'       => ['nullable', 'array'],
            'externo.*'     => ['integer', 'distinct', 'exists:p_externo,id'],
            'roles_externo' => ['nullable', 'array'],
            'roles_externo.*.participacion_id' => ['required', 'integer', 'distinct', 'exists:participaciones,id'],
        ], [
            'centro.array'          => 'La lista de personas del Centro no es válida.',
            'centro.*.integer'      => 'Una de las personas del Centro seleccionadas no es válida.',
            'centro.*.distinct'     => 'Hay personas del Centro repetidas.',
            'centro.*.exists'       => 'Una de las personas del Centro seleccionadas ya no existe.',

            'comunidad.array'       => 'La lista de personas de la Comunidad no es válida.',
            'comunidad.*.integer'   => 'Una de las personas de la Comunidad seleccionadas no es válida.',
            'comunidad.*.distinct'  => 'Hay personas de la Comunidad repetidas.',
            'comunidad.*.exists'    => 'Una de las personas de la Comunidad seleccionadas ya no existe.',

            'externo.array'         => 'La lista de personas externas no es válida.',
            'externo.*.integer'     => 'Una de las personas externas seleccionadas no es válida.',
            'externo.*.distinct'    => 'Hay personas externas repetidas.',
            'externo.*.exists'      => 'Una de las personas externas seleccionadas ya no existe.',

            'roles_externo.*.participacion_id.required' => 'Falta la participación a vincular de alguna persona externa.',
            'roles_externo.*.participacion_id.integer'  => 'Una de las participaciones seleccionadas no es válida.',
            'roles_externo.*.participacion_id.distinct' => 'Hay participaciones repetidas.',
            'roles_externo.*.participacion_id.exists'   => 'Una de las participaciones seleccionadas ya no existe.',
        ]);
    }

    private function rolesValidos($entidad)
    {
        $datosUsuario = new SupportController();

        if ($entidad instanceof Proyecto) return $datosUsuario->getEnumValues('rol_proyecto_centro','rol');
        if ($entidad instanceof Taller) return $datosUsuario->getEnumValues('rol_taller_centro','rol');

        throw new \InvalidArgumentException(
            'La entidad debe ser un Proyecto o un Taller.'
        );
    }

}
