<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
        // Aplica el middleware 'guest' a la función showLoginForm
        $this->middleware('guest')->only('login');
    }

    public function login(){
        return view('auth.login');
    }

    public function log(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // La autenticación ha sido exitosa
            return redirect()->intended('/home'); // Cambia '/dashboard' a la ruta a la que deseas redirigir después del inicio de sesión exitoso
        }

        // La autenticación ha fallado
        Session::flash('error', 'Credenciales inválidas. Por favor, intenta nuevamente.');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login'); // Cambia '/login' a la ruta a la que deseas redirigir después del logout
    }
}
