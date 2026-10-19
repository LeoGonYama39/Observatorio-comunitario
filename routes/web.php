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
use App\Http\Controllers\Nav\EducacionController;
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

// Rutas solo para los del centro (con acceso al sistema)
Route::middleware('auth:centro')->group(function () {
    Route::get('/menu', [LoginController::class, 'abrirMenu'])->name('dashboard');

    //Con las generadas por Laravel
    Route::resource('/sistema/areas', AreasController::class)->only(['index']);
    Route::resource('/sistema/ejes', EjesController::class);
    Route::resource('/sistema/personas-centro', PCentroController::class);
    Route::resource('/sistema/personas-externo', PExternoController::class);
    Route::resource('/sistema/personas-usuarias', PComunidadController::class);
    Route::resource('/sistema/a-juridicas', AJuridicasController::class);
    Route::resource('/sistema/a-familiares', AFamiliaresController::class);
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

    //Rutas para proyectos, exclusivas para usuarios del centro
    Route::resource('/sistema/proyectos', ProyectosController::class)->except(['index', 'show']);

    //Rutas para educación básica y media superior, usan un controlador común
    // Educación básica
    Route::get      ('/sistema/educ_basica', [EducacionController::class, 'index'])                                         ->defaults('nivel', 'basica')->name('educ_basica.index');
    Route::get      ('/sistema/educ_basica/create', [EducacionController::class, 'create'])                                 ->defaults('nivel', 'basica')->name('educ_basica.create');
    Route::post     ('/sistema/educ_basica', [EducacionController::class, 'store'])                                         ->defaults('nivel', 'basica')->name('educ_basica.store');
    Route::put      ('/sistema/educ_basica/{id}', [EducacionController::class, 'update'])               ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica.update');
    Route::get      ('/sistema/educ_basica/{id}/edit', [EducacionController::class, 'edit'])            ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica.edit');
    Route::get      ('/sistema/educ_basica/{id}', [EducacionController::class, 'show'])                 ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica.show');
    Route::delete   ('/sistema/educ_basica/{id}', [EducacionController::class, 'destroy'])              ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica.destroy');
    Route::get      ('/sistema/educ_basica/{id}/curso', [EducacionController::class, 'create_curso'])   ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica_curso.create');
    Route::post     ('/sistema/educ_basica/{id}/curso', [EducacionController::class, 'store_curso'])    ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica_curso.store');
    Route::delete   ('/sistema/educ_basica/{id}/curso', [EducacionController::class, 'destroy_curso'])  ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica_curso.destroy');
    Route::get      ('/sistema/educ_basica/{id}/curso/edit', [EducacionController::class, 'edit_curso'])   ->whereNumber('id') ->defaults('nivel', 'basica')->name('educ_basica_curso.edit');

    // Educación media-superior
    Route::get      ('/sistema/educ_sup', [EducacionController::class, 'index'])                                        ->defaults('nivel', 'sup')->name('educ_sup.index');
    Route::get      ('/sistema/educ_sup/create', [EducacionController::class, 'create'])                                ->defaults('nivel', 'sup')->name('educ_sup.create');
    Route::post     ('/sistema/educ_sup', [EducacionController::class, 'store'])                                        ->defaults('nivel', 'sup')->name('educ_sup.store');
    Route::get      ('/sistema/educ_sup/{id}/edit', [EducacionController::class, 'edit'])           ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup.edit');
    Route::get      ('/sistema/educ_sup/{id}', [EducacionController::class, 'show'])                ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup.show');
    Route::put      ('/sistema/educ_sup/{id}', [EducacionController::class, 'update'])              ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup.update');
    Route::delete   ('/sistema/educ_sup/{id}', [EducacionController::class, 'destroy'])             ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup.destroy');    
    Route::get      ('/sistema/educ_sup/{id}/curso', [EducacionController::class, 'create_curso'])  ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup_curso.create');
    Route::post     ('/sistema/educ_sup/{id}/curso', [EducacionController::class, 'store_curso'])   ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup_curso.store');
    Route::delete   ('/sistema/educ_sup/{id}/curso', [EducacionController::class, 'destroy_curso'])  ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup_curso.destroy');
    Route::get      ('/sistema/educ_sup/{id}/curso/edit', [EducacionController::class, 'edit_curso'])  ->whereNumber('id') ->defaults('nivel', 'sup')->name('educ_sup_curso.edit');

    //Rutas para talleres
    Route::resource('/sistema/talleres', TalleresController::class);
    Route::get('/sistema/talleres/{taller}/participantes', [ParticipantesController::class, 'edit_taller'])->name('talleres.participantes.edit');
    Route::put('/sistema/talleres/{taller}/participantes', [ParticipantesController::class, 'update_taller'])->name('talleres.participantes.update');
    Route::get('/sistema/talleres/{taller}/gen', [TalleresGenController::class, 'create_gen'])->name('talleres.gen.create');
    Route::post('/sistema/talleres/{taller}/gen', [TalleresGenController::class, 'store_gen'])->name('talleres.gen.store');
    Route::delete('/sistema/talleres/{taller}/gen', [TalleresGenController::class, 'delete_gen'])->name('talleres.gen.destroy');
    Route::get('/sistema/talleres/{grupo}/grupo', [TalleresGenController::class, 'edit_grupo'])->name('talleres.grupo.edit');
    Route::put('/sistema/talleres/{grupo}/grupo', [TalleresGenController::class, 'update_grupo'])->name('talleres.grupo.update');
    Route::get('/sistema/talleres/{grupo}/talleristas', [ParticipantesController::class, 'edit_talleristas'])->name('talleres.talleristas.edit');
    Route::put('/sistema/talleres/{grupo}/talleristar', [ParticipantesController::class, 'update_talleristas'])->name('talleres.talleristas.update');

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

// Rutas para usuarios del centro y externos (con acceso al sistema)
Route::middleware('auth:centro,externo')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/',  function () {return redirect()->route('dashboard');});

    //Vistas del sistema con get (y asignación del nombre) para index
    Route::get('/sistema', function () {return redirect()->route('proyectos.index');});

    //Rutas para proyectos
    Route::resource('/sistema/proyectos', ProyectosController::class)->only(['index', 'show']);
    Route::get('/sistema/proyectos/{proyecto}/participantes', [ParticipantesController::class, 'edit_proyecto'])->name('proyectos.participantes.edit');
    Route::put('/sistema/proyectos/{proyecto}/participantes', [ParticipantesController::class, 'update_proyecto'])->name('proyectos.participantes.update');
    Route::get('/sistema/proyectos/{proyecto}/historial', [ProyectosController::class, 'create_historial'])->name('proyectos.historial.create');
    Route::post('/sistema/proyectos/{proyecto}/historial', [ProyectosController::class, 'store_historial'])->name('proyectos.historial.store');
    Route::delete('/sistema/proyectos/{id}/historial/', [ProyectosController::class, 'destroy_historial'])->name('proyectos.historial.destroy');
});



