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
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $centros = $this->getDatosIndex();

        $view = view("system.modules.personas.p_centro.index", compact('persona', 'otros', 'centros'));

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
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $opCargo = $datosUsuario->getEnumValues('p_centro', 'cargo');

        $view = view("system.modules.personas.p_centro.create", compact('persona', 'otros', 'opCargo'));

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
        try {
            $messages = [
                'nombre.required'   => 'El nombre es obligatorio.',
                'nombre.max'        => 'El nombre no puede tener más de 40 caracteres.',
                'ap_pat.required'   => 'El apellido paterno es obligatorio.',
                'ap_pat.max'        => 'El apellido paterno no puede tener más de 40 caracteres.',
                'ap_mat.max'        => 'El apellido materno no puede tener más de 40 caracteres.',
                'cargo.in'          => 'El cargo seleccionado no es válido.',
                'usuario.required'  => 'El nombre de usuario es obligatorio al crear acceso.',
                'usuario.max'       => 'El usuario no puede superar los 20 caracteres.',
                'usuario.unique'    => 'Este nombre de usuario ya está registrado en el sistema.',
                'password.required' => 'La contraseña es obligatoria al crear acceso.',
                'password.min'      => 'La contraseña debe tener al menos 6 caracteres.',
            ];

            $validated = $request->validate([
                'nombre' => ['required', 'string', 'max:40'],
                'ap_pat' => ['required', 'string', 'max:40'],
                'ap_mat' => ['nullable', 'string', 'max:40'],
                'cargo'  => [
                    'nullable',
                    'string',
                    Rule::in([
                        'coordinador_general',
                        'asistente_de_coordinación',
                        'administración',
                        'recepción',
                        'coordinador',
                        'responsable',
                    ]),
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

            PCentro::create([
                'nombre'   => trim($validated['nombre']),
                'ap_pat'   => trim($validated['ap_pat']),
                'ap_mat'   => !empty($validated['ap_mat']) ? trim($validated['ap_mat']) : null,
                'cargo'    => !empty($validated['cargo']) ? $validated['cargo'] : null,
                'usuario'  => $crearAcceso ? trim($validated['usuario']) : null,
                'password' => $crearAcceso ? Hash::make($validated['password']) : null,
            ]);

            return redirect()
                ->route('personas-centro.index')
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
        $datosUsuario = new DatosUsuario();
        $aux = $datosUsuario->getDatosUsuario();
        $persona = $aux[0];
        $otros = $aux[1];

        $centro = $this->getDatosShow($id);

        $view = view("system.modules.personas.p_centro.show", compact('persona', 'otros', 'centro'));

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
                'cargo'
            )
            ->find($id);
    }
}
