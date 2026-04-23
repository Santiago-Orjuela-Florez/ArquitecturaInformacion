<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Muestra el dashboard principal.
     * Protegido por validación de sesión manual.
     */
    public function main()
    {
        if (!session('manual_auth')) {
            return redirect()->route('login');
        }

        return view('main.home.home');
    }
}