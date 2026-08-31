<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Nav\NavPCentro;
use App\Http\Controllers\Nav\NavPExterno;
use App\Http\Controllers\Nav\NavPComunidad;
use App\Http\Controllers\Nav\NavProyectos;
use App\Http\Controllers\Nav\NavEducBasic;
use App\Http\Controllers\Nav\NavTalleres;
use App\Http\Controllers\Nav\NavEventos;
use App\Http\Controllers\Nav\NavColonias;
use App\Http\Controllers\Nav\NavPsicopedag;


// Para usuarios sin inicio de sesión
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Para usuarios con inicio de sesión
Route::middleware('auth:centro,externo')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/menu', [LoginController::class, 'abrirMenu'])->name('dashboard');

    //Vistas del sistema con get (y asignación del nombre) para index
    Route::get('/sistema/personas-centro', [NavPCentro::class, 'show'])->name('p_centro.index');
    Route::get('/sistema/personas-externo', [NavPExterno::class, 'show'])->name('p_externo.index');
    Route::get('/sistema/personas-usuarias', [NavPComunidad::class, 'show'])->name('p_comunidad.index');
    Route::get('/sistema/proyectos', [NavProyectos::class, 'show'])->name('proyectos.index');
    Route::get('/sistema/educ_basica', [NavEducBasic::class, 'show'])->name('educ_basica.index');
    Route::get('/sistema/talleres', [NavTalleres::class, 'show'])->name('talleres.index');
    Route::get('/sistema/eventos', [NavEventos::class, 'show'])->name('eventos.index');
    Route::get('/sistema/colonias', [NavColonias::class, 'show'])->name('colonias.index');
    Route::get('/sistema/psicopedag', [NavPsicopedag::class, 'show'])->name('psicopedag.index');
    Route::get('/sistema', function () {return redirect()->route('p_centro.index');});

    //Vistas del sistema con get para info
    Route::get('/sistema/personas-centro/info', [NavPCentro::class, 'info'])->name('p_centro.info');
});

// Redirijir a login o menu (dashboard), dependiendo de la sesión
Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : redirect()->route('login');
});




