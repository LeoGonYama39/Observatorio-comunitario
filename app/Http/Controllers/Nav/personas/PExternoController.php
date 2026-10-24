<?php

namespace App\Http\Controllers\Nav\personas;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\DatosUsuario;
use App\Models\Areas\Responsabilidad;
use App\Models\listas\Institucion;
use Illuminate\Http\Request;
use App\Models\PExterno;
use App\Models\Participacion;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class PExternoController extends Controller
{
    public function index(Request $request) {
        $externos = $this->getDatosIndex();
        [$responsabilidades, $universidades, $opParticipaciones] = $this->getOpcionesFiltro();

        $view = view("system.modules.personas.p_externo.index", compact("externos", "universidades", "opParticipaciones"));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                "content" => $sections["content"],
                "title" => $sections["title"],
            ]);
        }

        return $view;
    }

    public function create(Request $request) {
        $datosUsuario = new DatosUsuario();
        $datos = $this->getDropDownOptions($datosUsuario);

        $view = view("system.modules.personas.p_externo.create", array_merge($datos ?? ["datos" => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                "content" => $sections["content"],
                "title" => $sections["title"],
            ]);
        }

        return $view;
    }

    public function store(Request $request) {
        $agregarParticipacion = $request->boolean("agregar_participacion");

        try {
            $validated = $this->getValidate($request, "crear_externo");
            $externo = DB::transaction(function () use ($request, $validated, $agregarParticipacion) {
                $crearAcceso = $request->boolean('crear_acceso');    
                $externo = PExterno::create([
                    "nombre" => trim($validated["nombre"]),
                    "ap_pat" => trim($validated["ap_pat"]),
                    "ap_mat" => !empty($validated["ap_mat"]) ? trim($validated["ap_mat"]) : null,
                    "responsabilidad_id" =>$validated["responsabilidad_id"] ?? null,
                    "universidad_id" => !empty($validated["universidad_id"]) ? trim($validated["universidad_id"]) : null,
                    "correo" => !empty($validated["correo"]) ? trim($validated["correo"]) : null,
                    "matricula" => !empty($validated["matricula"]) ? trim($validated["matricula"]) : null,
                    "carrera" => !empty($validated["carrera"]) ? trim($validated["carrera"]) : null,
                    'usuario'  => $crearAcceso ? trim($validated['usuario']) : null,
                    'password' => $crearAcceso ? Hash::make($validated['password']) : null,
                ]);

                if ($agregarParticipacion) {
                    Participacion::create([
                        "externo_id" => $externo->id,
                        "temporada" => $validated["temporada"],
                        "anio" => $validated["anio"],
                        "aport" => !empty($validated["aport"]) ? trim($validated["aport"]) : null,
                        "tipo" => $validated["tipo"],
                    ]);
                }

                return $externo;
            });

            return redirect()
                ->route("personas-externo.show", $externo->id)
                ->with("success", "Persona externa registrada con éxito.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Ocurrió un error al guardar en la base de datos: " .
                    $e->getMessage()
                );
        }
    }

    public function show(Request $request, int $id) {
        $datos = $this->getDatosShow($id);

        $view = view("system.modules.personas.p_externo.show", array_merge($datos ?? ["externo" => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                "content" => $sections["content"],
                "title" => $sections["title"],
            ]);
        }

        return $view;
    }

    public function edit(Request $request, int $id) {
        $datos = $this->getDatosEdit($id);
        $view = view("system.modules.personas.p_externo.edit", array_merge($datos ?? ["externo" => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                "content" => $sections["content"],
                "title" => $sections["title"],
            ]);
        }

        return $view;
    }

    public function update(Request $request, PExterno $personas_externo) {
        try {
            $teniaAcceso = !is_null($personas_externo->usuario);
            $eliminarAcceso = $request->boolean('eliminar_acceso');
            $crearAcceso = $request->boolean('crear_acceso');
            $accesoActivo = !$eliminarAcceso && (($teniaAcceso || $crearAcceso));

            $validated = $this->getValidate($request, "editar_externo", $personas_externo);

            $personas_externo->nombre = trim($validated["nombre"]);
            $personas_externo->ap_pat = trim($validated["ap_pat"]);
            $personas_externo->ap_mat = !empty($validated["ap_mat"]) ? trim($validated["ap_mat"]) : null;
            $personas_externo->responsabilidad_id = !empty($validated["responsabilidad_id"]) ? $validated["responsabilidad_id"] : null;
            $personas_externo->universidad_id = !empty($validated["universidad_id"]) ? trim($validated["universidad_id"]) : null;
            $personas_externo->correo = !empty($validated["correo"]) ? trim($validated["correo"]) : null;
            $personas_externo->matricula = !empty($validated["matricula"])  ? trim($validated["matricula"]) : null;
            $personas_externo->carrera = !empty($validated["carrera"]) ? trim($validated["carrera"]) : null;

            if (!$accesoActivo) {
                $personas_externo->usuario = null;
                $personas_externo->password = null;
                $personas_externo->remember_token = null;
            } else {
                $personas_externo->usuario = trim($validated['usuario']);

                if (!empty($validated['password'])) {
                    $personas_externo->password = Hash::make($validated['password']);
                }
            }

            $personas_externo->save();

            return redirect()
                ->route("personas-externo.show", $personas_externo->id)
                ->with("success", "Registro actualizado con éxito.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Ocurrió un error al guardar en la base de datos: " .
                    $e->getMessage()
                );
        }
    }

    public function destroy(string $id) {
        try {
            $externo = PExterno::findOrFail($id);
            $nombreCompleto = trim(
                $externo->nombre .
                " " .
                $externo->ap_pat .
                " " .
                ($externo->ap_mat ?? "")
            );
            $externo->delete();

            return redirect()
                ->route("personas-externo.index")
                ->with(
                    "success",
                    "Persona externa ({$nombreCompleto}) eliminada con éxito."
                );
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route("personas-externo.index")
                ->with("error", "El registro que intentas eliminar no existe.");
        } catch (\Throwable $e) {
            return back()->with(
                "error",
                "Ocurrió un error al intentar eliminar el registro: " .
                $e->getMessage()
            );
        }
    }

    public function create_participacion(Request $request, int $id) {
        $datosUsuario = new DatosUsuario();
        $datos = $this->getDatosCreateParticipacion($id, $datosUsuario);

        $view = view("system.modules.personas.p_externo.create_participacion",
                array_merge($datos ?? ["externo" => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                "content" => $sections["content"],
                "title" => $sections["title"],
            ]);
        }

        return $view;
    }

    public function store_participacion(Request $request, PExterno $externo) {
        try {
            $validated = $this->getValidate($request, "participacion");
            Participacion::create([
                "externo_id" => $externo->id,
                "temporada" => $validated["temporada"],
                "anio" => $validated["anio"],
                "aport" => !empty($validated["aport"])
                    ? trim($validated["aport"])
                    : null,
                "tipo" => $validated["tipo"],
            ]);

            return redirect()
                ->route("personas-externo.show", $externo->id)
                ->with("success", "Participación registrada con éxito.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Ocurrió un error al guardar en la base de datos: " .
                    $e->getMessage()
                );
        }
    }

    public function edit_participacion(Request $request, int $participacion) {
        $datosUsuario = new DatosUsuario();
        $participacion = Participacion::find($participacion);
        $datos = $this->getDropDownOptions($datosUsuario);

        $view = view("system.modules.personas.p_externo.edit_participacion",
            array_merge(compact('participacion'), $datos ?? ["datos" => null]));

        if ($request->ajax()) {
            $sections = $view->renderSections();
            return response()->json([
                "content" => $sections["content"],
                "title" => $sections["title"],
            ]);
        }

        return $view;
    }

    public function update_participacion(Request $request, Participacion $participacion) {
        try {
            $validated = $this->getValidate($request, "participacion");

            $participacion->temporada = trim($validated["temporada"]);
            $participacion->anio = trim($validated["anio"]);
            $participacion->tipo = $validated["tipo"];
            $participacion->aport = !empty($validated["aport"]) ? trim($validated["aport"]) : null;
            $participacion->save();

            return redirect()
                ->route("personas-externo.show", $participacion->externo->id)
                ->with("success", "Registro actualizado con éxito.");
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Ocurrió un error al guardar en la base de datos: " .
                    $e->getMessage()
                );
        }
    }

    public function destroy_participacion(Participacion $participacion) {
        try {
            $idOld = $participacion->externo->id;
            $participacion->delete();

            return redirect()
                ->route("personas-externo.show", $idOld)
                ->with("success", "Participación eliminada con éxito.");
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route("personas-externo.index")
                ->with("error", "El registro que intentas eliminar no existe.");
        } catch (\Throwable $e) {
            return back()->with(
                "error",
                "Ocurrió un error al intentar eliminar el registro: " .
                $e->getMessage()
            );
        }
    }

    //--------------------------------
    //          Funciones
    //--------------------------------

    //Obtiene los datos para la tabla index
    private function getDatosIndex()
    {
        return PExterno::with('universidad:id,nombre')
        ->select(
            "id",
            "nombre",
            "ap_pat",
            "ap_mat",
            'universidad_id')
            ->orderBy("nombre")
            ->get();
    }

    private function getDatosShow(int $id)
    {
        //Búsqueda de datos del externo
        $externo = $this->getExternoByID($id);

        if (!$externo) {
            return null;
        }

        //Búsqueda de participaciones del externo

        //Búsqueda de datos del externo
        $participaciones = $externo
            ->participaciones()
            ->select(
                "id",
                "externo_id", //Necesario hacer select a la FK porque la ocupa eloquent, aunque no la ocupe yo
                "temporada",
                "anio",
                "aport",
                "tipo"
            )
            ->orderBy("anio", "desc")
            ->orderBy("temporada", "desc")
            ->get();

        $respons = $externo->responsabilidad;
        $area = $respons ? $respons->area : null;

        return compact("externo", "participaciones", "respons", "area");
    }

    private function getDatosEdit(int $id)
    {
        $externo = $this->getExternoByID($id);
        if (!$externo) {
            return null;
        }
        [$responsabilidades, $universidades] = $this->getOpcionesFiltro();
        return compact("externo", "responsabilidades", "universidades");
    }

    private function getDatosCreateParticipacion(int $id, DatosUsuario $datosUsuario)
    {
        $externo = $this->getExternoByIDCompact($id);
        if (!$externo) {
            return null;
        }
        $opTipo = $datosUsuario->getEnumValues("participaciones", "tipo");
        $opTemporada = $datosUsuario->getEnumValues(
            "participaciones",
            "temporada"
        );

        return compact("externo", "opTipo", "opTemporada");
    }

    private function getDropDownOptions(DatosUsuario $datosUsuario)
    {
        $opTipo = $datosUsuario->getEnumValues("participaciones", "tipo");
        $opTemporada = $datosUsuario->getEnumValues(
            "participaciones",
            "temporada"
        );

        [$responsabilidades, $universidades] = $this->getOpcionesFiltro();

        return compact("opTipo", "opTemporada", "responsabilidades", "universidades");
    }

    private function getExternoByID(int $id)
    {
        return PExterno::with('universidad:id,nombre')
        ->select(
            "id",
            "nombre",
            "ap_pat",
            "ap_mat",
            "universidad_id",
            "responsabilidad_id", //Necesario para posteriormente hacer la búsqueda de resposabilidad
            "correo",
            "matricula",
            "carrera",
            "usuario",
        )->find($id);
    }

    private function getExternoByIDCompact(int $id) {
        return PExterno::select("id", "nombre", "ap_pat", "ap_mat")->find($id);
    }

    private function getOpcionesFiltro(){
        $responsabilidades = Responsabilidad::select(
            "responsabilidad.id",
            "responsabilidad.nombre",
            "responsabilidad.area_id"
        )->get();
        $universidades = Institucion::select('id', 'nombre')->where('universidad', true)->get();
        
        $datosUsuario = new DatosUsuario();
        $opParticipaciones = $datosUsuario->getEnumValues("participaciones", "tipo");

        return [$responsabilidades, $universidades, $opParticipaciones];
    }

    private function getValidate(Request $request, string $formulario, ?PExterno $externo = null): array {
        $messages = $this->getMessages();

        // Reglas comunes para los datos personales.
        $reglasPersona = [
            "nombre" => ["required", "string", "max:40"],
            "ap_pat" => ["required", "string", "max:40"],
            "ap_mat" => ["nullable", "string", "max:40"],
            "responsabilidad_id" => ["nullable", "exists:responsabilidad,id",],
            "universidad_id" => ["nullable",
                Rule::exists((new Institucion())->getTable(), "id")
                    ->where("universidad", true),
            ],
            "correo" => ["nullable", "string", "max:100"],
            "matricula" => ["nullable", "string", "max:30"],
            "carrera" => ["nullable", "string", "max:50"],
        ];

        // Reglas comunes para las participaciones.
        $datosUsuario = new DatosUsuario();

        $opTemporada = $datosUsuario->getEnumValues("participaciones", "temporada");
        $opTipo = $datosUsuario->getEnumValues("participaciones", "tipo");
        $reglasParticipacion = [
            "temporada" => ["required", "string", Rule::in($opTemporada),],
            "anio" => ["required", "digits:4", "integer", "min:1901", "max:2155", ],
            "aport" => ["nullable", "string"],
            "tipo" => ["required", "string", Rule::in($opTipo),],
        ];

        // Seleccionamos las reglas según el formulario.
        switch ($formulario) {
            case "crear_externo":
                $agregarParticipacion = $request->boolean("agregar_participacion");
                $crearAcceso = $request->boolean("crear_acceso");
                $reglas = array_merge($reglasPersona, [
                    "agregar_participacion" => ["nullable", "boolean"],
                    "temporada" => [Rule::requiredIf($agregarParticipacion), "nullable", "string", Rule::in($opTemporada),],
                    "anio" => [Rule::requiredIf($agregarParticipacion), "nullable", "digits:4", "integer", "min:1901", "max:2155",],
                    "aport" => ["nullable", "string"],
                    "tipo" => [Rule::requiredIf($agregarParticipacion), "nullable", "string", Rule::in($opTipo),],

                    "crear_acceso" => ["nullable", "boolean"],
                    "usuario" => [Rule::requiredIf($crearAcceso), "nullable", "string", "max:20", Rule::unique("p_externo", "usuario"),],
                    "password" => [Rule::requiredIf($crearAcceso), "nullable", "string", "min:6", "max:255",],
                ]);
                break;

            case "editar_externo":
                if (!$externo) {
                    throw new \InvalidArgumentException(
                        "Se necesita el externo para validar su edición."
                    );
                }

                $teniaAcceso = !is_null($externo->usuario);
                $eliminarAcceso = $request->boolean("eliminar_acceso");
                $crearAcceso = $request->boolean("crear_acceso");
                $accesoActivo = !$eliminarAcceso && ($teniaAcceso || $crearAcceso);

                $reglas = array_merge($reglasPersona, [
                    "usuario" => [Rule::requiredIf($accesoActivo), "nullable", "string", "max:20", Rule::unique("p_externo", "usuario")->ignore($externo->id),],
                    "password" => [Rule::requiredIf($accesoActivo && !$teniaAcceso), "nullable", "string", "min:6", "max:255",],
                ]);
                break;

            case "participacion":
                $reglas = $reglasParticipacion;
                break;

            default:
                throw new \InvalidArgumentException(
                    "Tipo de formulario no válido: {$formulario}"
                );
        }
        return $request->validate($reglas, $messages);
    }

    private function getMessages() {
        return [
            "nombre.required"           => "El nombre es obligatorio",
            "nombre.max"                => "El nombre no puede tener más de 40 caracteres",
            "ap_pat.required"           => "El apellido paterno es obligatorio",
            "ap_pat.max"                => "El apellido paterno no puede tener más de 40 caracteres",
            "ap_mat.max"                => "El apellido materno no puede tener más de 40 caracteres",
            "responsabilidad_id.exists" => "La responsabilidad seleccionada no es válida",
            "universidad_id.exists"     => "La universidad seleccionada no es válida",
            "correo.max"                => "El correo no puede tener más de 100 caracteres",
            "matricula.max"             => "La matrícula no puede tener más de 30 caracteres",
            "carrera.max"               => "La carrera no puede tener más de 50 caracteres",

            "temporada.required"        => "La temporada es obligatoria",
            "temporada.in"              => "La temporada seleccionada no es válida",
            "anio.required"             => "El año es obligatorio",
            "anio.digits"               => "El año debe tener 4 dígitos",
            "anio.min"                  => "El año debe ser mayor o igual a 1901",
            "anio.max"                  => "El año debe ser menor o igual a 2155",
            "tipo.required"             => "El tipo de participación es obligatoria",
            "tipo.in"                   => "El tipo de participación seleccionado no es válido",
        
            'usuario.required'  => 'El nombre de usuario es obligatorio al crear el acceso',
            'usuario.max'       => 'El usuario no puede superar los 20 caracteres',
            'usuario.unique'    => 'Este nombre de usuario ya está registrado en el sistema',
            'password.required' => 'La contraseña es obligatoria al crear el acceso',
            'password.min'      => 'La contraseña debe tener al menos 6 caracteres',
        ];
    }
}
