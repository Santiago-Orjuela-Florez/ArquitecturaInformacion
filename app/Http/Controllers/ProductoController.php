<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function mostrar()
    {
        $productos = Producto::all();

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        Producto::create([
            'nombre' => $request->input('nombre'),
            'precio' => $request->input('precio'),
        ]);

        return redirect('/productos');
    }
}
