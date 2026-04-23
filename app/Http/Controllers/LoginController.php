<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('main.login');
    }

    public function login(Request $request)
{
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    // Credenciales hardcoded
    if ($request->email === 'admin@cocacola.com' && $request->password === 'admin123') {
        // Almacenar estado de autenticación manual en la sesión
        $request->session()->put('manual_auth', true);
        $request->session()->regenerate();

        return redirect()->route('home');
    }

    return back()->withErrors([
        'email' => 'Las credenciales estáticas no coinciden.',
    ])->onlyInput('email');
}

public function logout(Request $request)
{
    $request->session()->forget('manual_auth');
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
}
}