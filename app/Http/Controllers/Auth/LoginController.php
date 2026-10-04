<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    
    public function create() {
        return view('auth.login');
    }

    public function store(Request $request) {
        $credentials = $request->validate([
            'usuario' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('centro')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/menu');
        }

        if (Auth::guard('externo')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/menu');
        }

        return back()->withErrors([
            'usuario' => 'Usuario o contraseña incorrectos.',
        ])->onlyInput('usuario');
    }

    public function destroy(Request $request) {
        Auth::guard('centro')->logout();
        Auth::guard('externo')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function abrirMenu() {return view('system.menu');}

}