<?php

namespace App\Http\Controllers;

use App\Models\Logistica;
use Illuminate\Http\Request;

class LogisticaController extends Controller
{
    public function index()
    {
        $logisticas = Logistica::with('pedido')->get();
        return view('main.logistica.index', compact('logisticas'));
    }

    public function destroy($id)
    {
        Logistica::findOrFail($id)->delete();
        return back()->with('success', 'Registro de logística eliminado correctamente.');
    }
}
