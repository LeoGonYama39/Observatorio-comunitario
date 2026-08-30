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

    public function abrirMenu() {
        $otros = new \stdClass();

        if (Auth::guard('centro')->check()) {
            $persona = Auth::guard('centro')->user();
            $otros->tipo = 'centro';
        } elseif (Auth::guard('externo')->check()) {
            $persona = Auth::guard('externo')->user();
            $otros->tipo = 'externo';
        } else {
            return redirect()->route('login');
        }

        $otros->initNombre = strtoupper(substr($persona->nombre, 0, 1));
        $otros->initApPat = strtoupper(substr($persona->ap_pat, 0, 1));

        return view('system.menu', compact('persona', 'otros'));
    }

}