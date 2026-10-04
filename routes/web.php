<?php

use App\Http\Controllers\Nav\AreasController;
use App\Http\Controllers\Nav\EjesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Nav\personas\PCentroController;
use App\Http\Controllers\Nav\personas\PExternoController;
use App\Http\Controllers\Nav\personas\PComunidadController;
use App\Http\Controllers\Nav\ProyectosController;
use App\Http\Controllers\Nav\juridica\AJuridicasController;
use App\Http\Controllers\Nav\juridica\AFamiliaresController;
use App\Http\Controllers\Nav\educacion\EducBasicController;
use App\Http\Controllers\Nav\educacion\EducSupController;
use App\Http\Controllers\Nav\psicopedag\AtenPersController;
use App\Http\Controllers\Nav\psicopedag\ProcGrupController;
use App\Http\Controllers\Nav\TalleresController;
use App\Http\Controllers\Nav\EventosController;
use App\Http\Controllers\Nav\ColoniasController;

// Para usuarios sin inicio de sesión
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Para usuarios con inicio de sesión
Route::middleware('auth:centro,externo')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/menu', [LoginController::class, 'abrirMenu'])->name('dashboard');
    Route::get('/',  function () {return redirect()->route('dashboard');});

    //Vistas del sistema con get (y asignación del nombre) para index
    Route::get('/sistema', function () {return redirect()->route('personas-centro.index');});

    //Con las generadas por Laravel
    Route::resource('/sistema/areas', AreasController::class)->only(['index']);
    Route::resource('/sistema/ejes', EjesController::class);
    Route::resource('/sistema/personas-centro', PCentroController::class);
    Route::resource('/sistema/personas-externo', PExternoController::class);
    Route::resource('/sistema/personas-usuarias', PComunidadController::class);
    Route::resource('/sistema/proyectos', ProyectosController::class);
    Route::resource('/sistema/a-juridicas', AJuridicasController::class);
    Route::resource('/sistema/a-familiares', AFamiliaresController::class);
    Route::resource('/sistema/educ_basica', EducBasicController::class);
    Route::resource('/sistema/educ_sup', EducSupController::class);
    Route::resource('/sistema/aten_pers', AtenPersController::class);
    Route::resource('/sistema/proc_grup', ProcGrupController::class);
    Route::resource('/sistema/talleres', TalleresController::class);
    Route::resource('/sistema/eventos', EventosController::class);
    Route::resource('/sistema/colonias', ColoniasController::class);

    //Rutas para externos
    Route::resource('/sistema/personas-externo', PExternoController::class);
    Route::get('/sistema/personas-externo/{id}/participacion', [PExternoController::class, 'create_participacion'])->name('personas-externo.create_participacion');
    Route::post('/sistema/personas-externo/{externo}/participacion', [PExternoController::class, 'store_participacion'])->name('personas-externo.store_participacion');
    Route::get('/sistema/participacion/{participacion}/edit', [PExternoController::class, 'edit_participacion'])->name('personas-externo.edit_participacion');
    Route::put('/sistema/participacion/{participacion}', [PExternoController::class, 'update_participacion'])->name('personas-externo.update_participacion');
    Route::delete('/sistema/participacion/{participacion}', [PExternoController::class, 'destroy_participacion'])->name('personas-externo.destroy_participacion');

    //Rutas para proyectos
    Route::resource('/sistema/proyectos', ProyectosController::class);
    Route::get('/sistema/proyectos/{proyecto}/participantes', [ProyectosController::class, 'edit_participacion'])->name('proyectos.participantes.edit');
    Route::put('/sistema/proyectos/{proyecto}/participantes', [ProyectosController::class, 'update_participacion'])->name('proyectos.participantes.update');
    Route::get('/sistema/proyectos/{proyecto}/historial', [ProyectosController::class, 'create_historial'])->name('proyectos.historial.create');
    Route::post('/sistema/proyectos/{proyecto}/historial', [ProyectosController::class, 'store_historial'])->name('proyectos.historial.store');
    Route::delete('/sistema/proyectos/{proyecto}/historial/{id}', [ProyectosController::class, 'destroy_historial'])->name('proyectos.historial.destroy');

    //Para lo de areas y responsabilidades
    Route::patch('/areas/{area}/responsable', [AreasController::class, 'updateResponsableArea'])
    ->name('areas.updateResponsable');
    Route::patch('/responsabilidades/{responsabilidad}/responsable', [AreasController::class, 'updateResponsableResponsabilidad'])
    ->name('responsabilidades.updateResponsable');
});





