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

class ParticipantesController extends Controller {

    public function edit_proyecto(Request $request, Proyecto $proyecto)
    {
        return $this->edit(
            $request,
            $proyecto,
            'proyecto',
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
            'taller',
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
            'centro'      => $entidad->rolesCentro()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'comunidad'   => $entidad->rolesComunidad()->get()->mapWithKeys(fn ($p) => [
                $p->id => ['rol' => $p->pivot->rol, 'otros' => $p->pivot->otros],
            ])->toArray(),
            'institucion' => $entidad->instituciones()->get()->mapWithKeys(fn ($i) => [
                $i->id => ['rol' => $i->pivot->rol, 'otros' => $i->pivot->otros],
            ])->toArray(),
            'externo'     => $entidad->rolesExternos()->get()->mapWithKeys(fn ($part) => [
                $part->id => ['rol' => $part->pivot->rol, 'otros' => $part->pivot->otros],
            ])->toArray(),
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
                $validated['roles_externo'] ?? [],
                Participacion::class,
                'externo (participación)'
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
                    $this->prepararSync(
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

    private function getValidateParticipacion($request, $entidad) {
        $rolesValidos = $this->rolesValidos($entidad);

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

    private function rolesValidos($entidad)
    {
        $datosUsuario = new DatosUsuario();

        if ($entidad instanceof Proyecto) return $datosUsuario->getEnumValues('rol_proyecto_centro','rol');
        if ($entidad instanceof Taller) return $datosUsuario->getEnumValues('rol_taller_centro','rol');

        throw new \InvalidArgumentException(
            'La entidad debe ser un Proyecto o un Taller.'
        );
    }

}
