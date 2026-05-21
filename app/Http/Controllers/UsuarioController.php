<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return view('main.usuarios.index', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:Admin,Logística,Ventas',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return back()->with('success', 'Usuario creado exitosamente.');
    }

    public function destroy($id)
    {
        if (auth()->user()->id == $id) {
            return back()->with('error', 'No puedes eliminarte a ti mismo.');
        }
        User::findOrFail($id)->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}
