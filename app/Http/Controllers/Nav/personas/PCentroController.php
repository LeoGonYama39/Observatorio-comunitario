<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\PCentro;

class PCentroController extends Controller
{
    public function index(Request $request)
    {
        $centros = $this->getDatosIndex();

        $view = view("system.modules.personas.p_centro.index", compact('centros'));

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
        $datosUsuario = new DatosUsuario();
        $opCargo = $datosUsuario->getEnumValues('p_centro', 'cargo');

        $view = view("system.modules.personas.p_centro.create", compact('opCargo'));

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
        $opCargo = $datosUsuario->getEnumValues('p_centro', 'cargo');

        try {
            $messages = $this->getMessages();

            $validated = $request->validate([
                'nombre' => ['required', 'string', 'max:40'],
                'ap_pat' => ['required', 'string', 'max:40'],
                'ap_mat' => ['nullable', 'string', 'max:40'],
                'cargo'  => [
                    'nullable',
                    'string',
                    Rule::in($opCargo),
                ],
                'crear_acceso' => ['nullable', 'boolean'],
                'usuario' => [
                    Rule::requiredIf($request->boolean('crear_acceso')),
                    'nullable',
                    'string',
                    'max:20',
                    Rule::unique('p_centro', 'usuario'),
                ],
                'password' => [
                    Rule::requiredIf($request->boolean('crear_acceso')),
                    'nullable',
                    'string',
                    'min:6',
                    'max:255',
                ],
            ], $messages);

            $crearAcceso = $request->boolean('crear_acceso');

            $centro = PCentro::create([
                'nombre'   => trim($validated['nombre']),
                'ap_pat'   => trim($validated['ap_pat']),
                'ap_mat'   => !empty($validated['ap_mat']) ? trim($validated['ap_mat']) : null,
                'cargo'    => !empty($validated['cargo']) ? $validated['cargo'] : null,
                'usuario'  => $crearAcceso ? trim($validated['usuario']) : null,
                'password' => $crearAcceso ? Hash::make($validated['password']) : null,
            ]);

            return redirect()
                ->route('personas-centro.show', $centro->id)
                ->with('success', 'Persona del centro registrada con éxito.');
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
        $centro = $this->getDatosShow($id);

        $view = view("system.modules.personas.p_centro.show", compact('centro'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }


    public function edit(Request $request, $id)
    {
        $datosUsuario = new DatosUsuario();
        $opCargo = $datosUsuario->getEnumValues('p_centro', 'cargo');
        $centro = $this->getDatosShow($id);

        $view = view("system.modules.personas.p_centro.edit", compact('centro', 'opCargo'));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                'content' => $sections['content'],
                'title' => $sections['title'],
            ]);
        }

        return $view;
    }

    public function update(Request $request, PCentro $personas_centro)
    {
        $datosUsuario = new DatosUsuario();
        $opCargo = $datosUsuario->getEnumValues('p_centro', 'cargo');

        // ¿En qué estado queda el acceso al sistema después de este update?
        $teniaAcceso = !is_null($personas_centro->usuario);
        $eliminarAcceso = $request->boolean('eliminar_acceso');
        $crearAcceso = $request->boolean('crear_acceso');
        $accesoActivo = !$eliminarAcceso && (($teniaAcceso || $crearAcceso));

        try {
            $messages = $this->getMessages();
            $validated = $request->validate([
                'nombre'            => ['required', 'string', 'max:40'],
                'ap_pat'            => ['required', 'string', 'max:40'],
                'ap_mat'            => ['nullable', 'string', 'max:40'],
                'cargo'             => ['nullable', 'string', Rule::in($opCargo)],
                'eliminar_acceso'   => ['nullable', 'boolean'],
                'crear_acceso'      => ['nullable', 'boolean'],
                'usuario' => [
                    Rule::requiredIf($accesoActivo),
                    'nullable',
                    'string',
                    'max:20',
                    Rule::unique('p_centro', 'usuario')->ignore($personas_centro->id),
                ],
                // Solo obligatoria si el acceso se está creando desde cero;
                // si ya existía, en blanco significa "no cambiar la contraseña"
                'password' => [
                    Rule::requiredIf($accesoActivo && !$teniaAcceso),
                    'nullable',
                    'string',
                    'min:6',
                    'max:255',
                ],
            ], $messages);

            $personas_centro->nombre = trim($validated['nombre']);
            $personas_centro->ap_pat = trim($validated['ap_pat']);
            $personas_centro->ap_mat = !empty($validated['ap_mat']) ? trim($validated['ap_mat']) : null;
            $personas_centro->cargo  = !empty($validated['cargo']) ? $validated['cargo'] : null;

            if (!$accesoActivo) {
                $personas_centro->usuario = null;
                $personas_centro->password = null;
                $personas_centro->remember_token = null;
            } else {
                $personas_centro->usuario = trim($validated['usuario']);

                if (!empty($validated['password'])) {
                    $personas_centro->password = Hash::make($validated['password']);
                }
            }

            $personas_centro->save();

            return redirect()
                ->route('personas-centro.show', $personas_centro->id)
                ->with('success', 'Registro actualizado con éxito.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Ocurrió un error al guardar en la base de datos: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        try {
            $centro = PCentro::findOrFail($id);
            $nombreCompleto = trim($centro->nombre . ' ' . $centro->ap_pat . ' ' . ($centro->ap_mat ?? ''));
            $centro->delete();

            return redirect()
                ->route('personas-centro.index')
                ->with('success', "Persona del centro ({$nombreCompleto}) eliminada con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('personas-centro.index')
                ->with('error', 'El registro que intentas eliminar no existe.');
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Ocurrió un error al intentar eliminar el registro: ' . $e->getMessage());
        }
    }

    //------------------------------
    //          Funciones
    //------------------------------

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return PCentro::with([
            'areas:id,nombre,centro_id',
            'responsabilidades:id,nombre,area_id,centro_id'
        ])
            ->select(
                'id',
                'nombre',
                'ap_pat',
                'ap_mat',
                'cargo'
            )
            ->orderBy('nombre')
            ->get();
    }

    //Obtiene los datos para ficha show
    private function getDatosShow($id)
    {
        return PCentro::with([
            'areas:id,nombre,centro_id',
            'responsabilidades:id,nombre,area_id,centro_id'
        ])
            ->select(
                'id',
                'nombre',
                'ap_pat',
                'ap_mat',
                'cargo',
                'usuario'
            )
            ->find($id);
    }

    private function getMessages(){
        return [
            'nombre.required'   => 'El nombre es obligatorio',
            'nombre.max'        => 'El nombre no puede tener más de 40 caracteres',
            'ap_pat.required'   => 'El apellido paterno es obligatorio',
            'ap_pat.max'        => 'El apellido paterno no puede tener más de 40 caracteres',
            'ap_mat.max'        => 'El apellido materno no puede tener más de 40 caracteres',
            'cargo.in'          => 'El cargo seleccionado no es válido',
            'usuario.required'  => 'El nombre de usuario es obligatorio mientras el acceso esté activo',
            'usuario.max'       => 'El usuario no puede superar los 20 caracteres',
            'usuario.unique'    => 'Este nombre de usuario ya está registrado en el sistema',
            'password.required' => 'La contraseña es obligatoria al crear el acceso',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
