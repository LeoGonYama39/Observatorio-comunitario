<?php

use App\Http\Controllers\Nav\AreasController;
use App\Http\Controllers\Nav\EjesController;
use App\Http\Controllers\Nav\ParticipantesController;
use App\Http\Controllers\Nav\TalleresGenController;
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
    Route::resource('/sistema/eventos', EventosController::class);

    //Rutas para externos
    Route::resource('/sistema/personas-externo', PExternoController::class);
    Route::get('/sistema/personas-externo/{id}/participacion', [PExternoController::class, 'create_participacion'])->name('personas-externo.create_participacion');
    Route::post('/sistema/personas-externo/{externo}/participacion', [PExternoController::class, 'store_participacion'])->name('personas-externo.store_participacion');
    Route::get('/sistema/participacion/{participacion}/edit', [PExternoController::class, 'edit_participacion'])->name('personas-externo.edit_participacion');
    Route::put('/sistema/participacion/{participacion}', [PExternoController::class, 'update_participacion'])->name('personas-externo.update_participacion');
    Route::delete('/sistema/participacion/{participacion}', [PExternoController::class, 'destroy_participacion'])->name('personas-externo.destroy_participacion');

    //Rutas para proyectos
    Route::resource('/sistema/proyectos', ProyectosController::class);
    Route::get('/sistema/proyectos/{proyecto}/participantes', [ParticipantesController::class, 'edit_proyecto'])->name('proyectos.participantes.edit');
    Route::put('/sistema/proyectos/{proyecto}/participantes', [ParticipantesController::class, 'update_proyecto'])->name('proyectos.participantes.update');
    Route::get('/sistema/proyectos/{proyecto}/historial', [ProyectosController::class, 'create_historial'])->name('proyectos.historial.create');
    Route::post('/sistema/proyectos/{proyecto}/historial', [ProyectosController::class, 'store_historial'])->name('proyectos.historial.store');
    Route::delete('/sistema/proyectos/{id}/historial/', [ProyectosController::class, 'destroy_historial'])->name('proyectos.historial.destroy');

    //Rutas para talleres
    Route::resource('/sistema/talleres', TalleresController::class);
    Route::get('/sistema/talleres/{taller}/participantes', [ParticipantesController::class, 'edit_taller'])->name('talleres.participantes.edit');
    Route::put('/sistema/talleres/{taller}/participantes', [ParticipantesController::class, 'update_taller'])->name('talleres.participantes.update');
    Route::get('/sistema/talleres/{taller}/gen', [TalleresGenController::class, 'create_gen'])->name('talleres.gen.create');
    Route::post('/sistema/talleres/{taller}/gen', [TalleresGenController::class, 'store_gen'])->name('talleres.gen.store');
    Route::delete('/sistema/talleres/{taller}/gen', [TalleresGenController::class, 'delete_gen'])->name('talleres.gen.destroy');

    //Rutas para colonias
    Route::resource('/sistema/colonias', ColoniasController::class);
    Route::get('/sistema/colonias/{colonia}/historial', [ColoniasController::class, 'create_historial'])->name('colonias.historial.create');
    Route::post('/sistema/colonias/{colonia}/historial', [ColoniasController::class, 'store_historial'])->name('colonias.historial.store');
    Route::delete('/sistema/colonias/{id}/historial/', [ColoniasController::class, 'destroy_historial'])->name('colonias.historial.destroy');

    //Para lo de áreas y responsabilidades
    Route::patch('/areas/{area}/responsable', [AreasController::class, 'updateResponsableArea'])
    ->name('areas.updateResponsable');
    Route::patch('/responsabilidades/{responsabilidad}/responsable', [AreasController::class, 'updateResponsableResponsabilidad'])
    ->name('responsabilidades.updateResponsable');
});





