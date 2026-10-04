<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Sup\DatosUsuario;


class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $datosUsuario = new DatosUsuario();
            [$persona, $otros] = $datosUsuario->getDatosUsuario();

            $view->with([
                'persona' => $persona,
                'otros'   => $otros,
            ]);
        });
    }
}
