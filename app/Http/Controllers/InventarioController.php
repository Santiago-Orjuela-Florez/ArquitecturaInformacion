<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::all();
        return view('main.inventario.index', compact('inventarios'));
    }

    public function destroy($id)
    {
        Inventario::findOrFail($id)->delete();
        return back()->with('success', 'Producto eliminado del inventario.');
    }
}
