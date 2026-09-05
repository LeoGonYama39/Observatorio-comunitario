<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Nav\personas\PCentroController;
use App\Http\Controllers\Nav\personas\PExternoController;
use App\Http\Controllers\Nav\personas\PComunidadController;
use App\Http\Controllers\Nav\ProyectosController;
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

    //Vistas del sistema con get para info

    //Con las generadas por Laravel
    Route::resource('/sistema/personas-centro', PCentroController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/personas-externo', PExternoController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/personas-usuarias', PComunidadController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/proyectos', ProyectosController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/educ_basica', EducBasicController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/educ_sup', EducSupController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/aten_pers', AtenPersController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/proc_grup', ProcGrupController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/talleres', TalleresController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/eventos', EventosController::class)->only(['index', 'show', 'create', 'store']);
    Route::resource('/sistema/colonias', ColoniasController::class)->only(['index', 'show', 'create', 'store']);
});





