<?php

namespace App\Http\Controllers\Sistema\Psicopegagogia\atencion_personal;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Sup\SupportController;
use App\Models\Psicopedagogia\atencion_individual\Caso;
use App\Models\Psicopedagogia\atencion_individual\Expediente;
use App\Models\Psicopedagogia\atencion_individual\ListPadecCaso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CasoController extends Controller
{
    private const TEMPORADA_PRIMAVERA = 'primavera';
    private const TEMPORADA_OTONO     = 'otoño';
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

    //-----------------------------
    //          Funciones
    //-----------------------------

    private function getDatosCreateCaso(int $id) {
        $expediente = Expediente::find($id);
        if (!$expediente) return null;

        [$estados, $tipos, $motivos] = $this->getOptionsEnums();

        return compact('expediente', 'estados', 'tipos', 'motivos');
    }

    private function getValidate(Request $request) {
        $support = new SupportController();

        $rules = [
            'contacto_emergencia'   => ['nullable', 'string', 'max:20'],
            'comunidad_id'          => ['sometimes', 'required', 'integer', 'exists:p_comunidad,id'],
            'init'                  => ['required', 'date'],
            'tipo'                  => ['required', 'string', Rule::in($support->getEnumValues('caso', 'tipo'))],
            'estado'                => ['required', 'string', Rule::in($support->getEnumValues('caso', 'estado'))],
            'peticion'              => ['nullable', 'string', 'max:5000'],
            'canalizado'            => ['nullable', 'boolean'],
            'canalizado_site'       => ['required_if:canalizado,1,true', 'nullable', 'string', 'max:255'],

            'motivos'               => ['nullable', 'array'],
            'motivos.*'             => ['integer', 'exists:list_padec_caso,id'],
        ];

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

    private function temporadaDe(string $fecha): string {
        return Carbon::parse($fecha)->month <= 6
            ? self::TEMPORADA_PRIMAVERA
            : self::TEMPORADA_OTONO;
    }

    private function getDatosEditCaso(int $id){
        $caso = Caso::find($id);
        if (!$caso) return null;

        [$estados, $tipos, $motivos] = $this->getOptionsEnums();

        return compact('caso', 'estados', 'tipos', 'motivos');
    }

    private function getOptionsEnums() {
        $support = new SupportController();
        $estados = $support->getEnumValues('caso', 'estado');
        $tipos = $support->getEnumValues('caso', 'tipo');
        $motivos = ListPadecCaso::all();

        return [$estados, $tipos, $motivos];
    }
}
